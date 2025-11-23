<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\PlayerProfile;
use App\Models\DailyChallenge;
use App\Models\UserChallenge;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect guru ke dashboard guru
        if ($user->role === 'guru') {
            return redirect()->route('teacher.dashboard');
        }

        $player = PlayerProfile::where('user_id', $user->id)->first();

        if (!$player) {
            $player = PlayerProfile::create([
                'user_id' => $user->id,
                'level' => 1,
                'xp' => 0,
                'xp_needed' => 100,
            ]);
        }

        // HANYA tampilkan quiz AKTIF yang belum dikerjakan
        $quizzes = Quiz::whereDoesntHave('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('is_active', true) // TAMBAHKAN FILTER INI
        ->take(6)
        ->get();

        $todayChallenges = DailyChallenge::today()->take(4)->get();
        
        $userChallenges = [];
        foreach ($todayChallenges as $challenge) {
            $userChallenge = UserChallenge::firstOrCreate([
                'user_id' => $user->id,
                'daily_challenge_id' => $challenge->id,
            ]);
            $userChallenges[] = $userChallenge;
        }

        return view('dashboard', compact('user', 'player', 'quizzes', 'userChallenges'));
    }
}