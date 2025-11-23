<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use App\Models\Choice;

class TeacherController extends Controller
{
    // Dashboard Guru
    public function dashboard()
    {
        $user = Auth::user();
        
        // Redirect siswa ke dashboard siswa
        if ($user->role === 'siswa') {
            return redirect()->route('dashboard');
        }

        $totalQuizzes = Quiz::where('created_by', $user->id)->count();
        $totalQuestions = Question::where('created_by', $user->id)->count();
        
        $recentQuizzes = Quiz::where('created_by', $user->id)
                            ->withCount('questions')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('teacher.dashboard', compact('user', 'totalQuizzes', 'totalQuestions', 'recentQuizzes'));
    }

    // Kelola Quiz
    public function quizzes()
    {
        $user = Auth::user();
        $quizzes = Quiz::where('created_by', $user->id)
                      ->withCount('questions')
                      ->paginate(10);

        return view('teacher.quizzes', compact('user', 'quizzes'));
    }

    // Form Buat Quiz Baru
    public function createQuiz()
    {
        return view('teacher.quiz-create');
    }

    // Simpan Quiz Baru
    public function storeQuiz(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp' => 'required|integer|min:10|max:1000',
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'xp' => $validated['xp'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.quizzes')->with('success', 'Quiz berhasil dibuat!');
    }

    // Kelola Soal dalam Quiz
    public function questions($quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        $questions = $quiz->questions()->with('choices')->get();

        return view('teacher.questions', compact('quiz', 'questions'));
    }

    // Form Tambah Soal Baru
    public function createQuestion($quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        return view('teacher.question-create', compact('quiz'));
    }

    // Simpan Soal Baru
    public function storeQuestion(Request $request, $quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);

        $validated = $request->validate([
            'question' => 'required|string',
            'choices' => 'required|array|min:2',
            'choices.*.text' => 'required|string',
            'correct_choice' => 'required|integer|min:0',
        ]);

        // Buat soal
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question' => $validated['question'],
            'created_by' => Auth::id(),
        ]);

        // Buat pilihan jawaban
        foreach ($validated['choices'] as $index => $choiceData) {
            Choice::create([
                'question_id' => $question->id,
                'choice' => $choiceData['text'],
                'is_correct' => $index == $validated['correct_choice'],
            ]);
        }

        return redirect()->route('teacher.questions', $quiz->id)
                         ->with('success', 'Soal berhasil ditambahkan!');
    }

    // Lihat Hasil Quiz Siswa
    public function quizResults($quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        
        $results = $quiz->users()->withPivot('score', 'created_at')->get();

        return view('teacher.quiz-results', compact('quiz', 'results'));
    }

    // Toggle status quiz (aktif/tidak aktif)
    public function toggleQuizStatus($quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        
        $quiz->update([
            'is_active' => !$quiz->is_active
        ]);

        $status = $quiz->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Quiz berhasil $status!");
    }

    // Hapus quiz
    public function deleteQuiz($quizId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        
        // Hapus semua soal dan pilihan terkait
        foreach ($quiz->questions as $question) {
            $question->choices()->delete();
        }
        $quiz->questions()->delete();
        
        // Hapus dari pivot table
        $quiz->users()->detach();
        
        $quiz->delete();

        return redirect()->route('teacher.quizzes')->with('success', 'Quiz berhasil dihapus!');
    }

    public function studentResultDetail($quizId, $studentId)
    {
        $quiz = Quiz::where('created_by', Auth::id())->findOrFail($quizId);
        
        // Ambil data siswa dan hasil quiz-nya
        $student = $quiz->users()
                        ->where('user_id', $studentId)
                        ->withPivot('score', 'details', 'created_at')
                        ->firstOrFail();

        // Decode details dari JSON
        $details = json_decode($student->pivot->details, true);

        return view('teacher.student-result-detail', compact('quiz', 'student', 'details'));
    }
}