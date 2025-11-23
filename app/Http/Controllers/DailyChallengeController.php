<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyChallenge;
use App\Models\UserChallenge;

class DailyChallengeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Auto generate jika belum ada challenges hari ini
        if (!DailyChallenge::where('date', today())->exists()) {
            \Artisan::call('challenges:generate-daily');
        }

        $todayChallenges = DailyChallenge::today()->paginate(6);
        
        $userChallenges = [];
        foreach ($todayChallenges as $challenge) {
            $userChallenges[] = UserChallenge::firstOrCreate([
                'user_id' => $user->id,
                'daily_challenge_id' => $challenge->id,
            ]);
        }

        return view('challenges.daily', compact('userChallenges', 'todayChallenges'));
    }

    // Manual generate untuk testing
    public function generateManually()
    {
        \Artisan::call('challenges:generate-daily');
        
        return redirect()->route('challenges.daily')
                         ->with('success', "Berhasil generate challenge harian!");
    }
}