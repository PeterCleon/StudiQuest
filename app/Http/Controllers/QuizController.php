<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\UserChallenge;
use App\Models\DailyChallenge;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // Tampilkan semua quiz yang belum dikerjakan
    public function index()
    {
        $user = Auth::user();
        
        // Pakai scope active()
        $quizzes = Quiz::whereDoesntHave('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->active() // PAKAI SCOPE INI
        ->paginate(12);

        return view('quiz.index', compact('quizzes', 'user'));
    }

    public function start($id)
    {
        $user = Auth::user();
        
        // Pakai scope active()
        $quiz = Quiz::active() // PAKAI SCOPE INI
                    ->with('questions.choices')
                    ->findOrFail($id);

        // Cek apakah user sudah pernah mengerjakan
        $taken = $user->quizzes()->where('quiz_id', $id)->exists();
        if ($taken) {
            return redirect()->route('quiz.result', $id)
                            ->with('info', 'Kamu sudah mengerjakan quiz ini. Lihat hasilnya di bawah!');
        }

        return view('quiz.start', compact('quiz', 'user'));
    }

    public function result($id)
    {
        $user = Auth::user();
        
        // Untuk result, tetap bisa akses meski quiz tidak aktif (karena sudah dikerjakan)
        $quiz = Quiz::findOrFail($id);

        $result = session('quiz_result');

        if (!$result) {
            $pivot = $user->quizzes()->where('quiz_id', $id)->first()?->pivot;
            if (!$pivot) {
                return redirect()->route('quiz.index')
                                ->with('error', 'Hasil quiz tidak ditemukan.');
            }

            $details = json_decode($pivot->details, true);

            $result = [
                'score' => $pivot->score,
                'total' => count($details),
                'details' => $details,
            ];
        }

        return view('quiz.result', compact('quiz', 'result', 'user'));
    }

    // Submit jawaban
    public function submit(Request $request, $id)
    {
        
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        $user = Auth::user();

        $score = 0;
        $details = [];

        foreach ($quiz->questions as $q) {
            // UBAH DI SINI - dari 'answer_' jadi 'question_'
            $userAnswer = $request->input('question_' . $q->id);
            
            $correctChoice = $q->choices->where('is_correct', 1)->first();
            $isCorrect = $correctChoice && $userAnswer == $correctChoice->id;

            if ($isCorrect) {
                $score++;
            }

            $choicesArray = $q->choices->map(function ($c) {
                return [
                    'id' => $c->id,
                    'label' => $c->label ?? null,
                    'text' => $c->choice, // Juga pastikan ini 'choice' bukan 'choice_text'
                    'is_correct' => $c->is_correct,
                ];
            })->toArray();

            $details[] = [
                'question' => $q->question,
                'choices' => $choicesArray,
                'selected' => $userAnswer,
                'correct_answer' => $correctChoice->id ?? null,
                'is_correct' => $isCorrect,
            ];
        }

        // Tambahkan XP
        $player = $user->playerProfile;
        if ($player) {
            $player->xp += $quiz->xp;
            $player->save();
        }

        // Simpan ke pivot table (history)
        $user->quizzes()->syncWithoutDetaching([
            $quiz->id => [
                'score' => $score,
                'details' => json_encode($details),
            ]
        ]);

        $player = $user->playerProfile;
        if ($player) {
            $player->addXp($quiz->xp); // Gunakan method auto level up
        }

        // Simpan ke session supaya result page bisa langsung dibaca
        session([
            'quiz_result' => [
                'score' => $score,
                'total' => count($quiz->questions),
                'details' => $details,
            ]
        ]);

        $this->updateDailyChallenges($user, $score, count($quiz->questions));

        return redirect()->route('quiz.result', $quiz->id);
    }

    protected function updateDailyChallenges($user, $score, $totalQuestions)
    {
        $todayChallenges = DailyChallenge::today()->get();
        
        foreach ($todayChallenges as $challenge) {
            $userChallenge = UserChallenge::firstOrCreate([
                'user_id' => $user->id,
                'daily_challenge_id' => $challenge->id,
            ]);

            if ($userChallenge->is_completed) continue;

            switch ($challenge->type) {
                case 'complete_quiz':
                    $userChallenge->incrementProgress();
                    break;
                    
                case 'perfect_score':
                    if ($score == $totalQuestions) {
                        $userChallenge->incrementProgress();
                    }
                    break;
                    
                case 'streak':
                    // Logic untuk cek streak
                    break;
            }
        }
    }

    // History quiz
    public function history()
    {
        $user = Auth::user();
        $history = $user->quizzes()
            ->withPivot('score', 'details', 'created_at')
            ->withCount('questions') // Pastikan ini ada
            ->orderBy('quiz_user.created_at', 'desc')
            ->paginate(10);

        return view('quiz.history', compact('history', 'user'));
    }
}
