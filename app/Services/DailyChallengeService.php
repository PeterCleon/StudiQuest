<?php

namespace App\Services;

use App\Models\DailyChallenge;

class DailyChallengeService
{
    public function generateDailyChallenges()
    {
        \Log::info('Starting daily challenge generation');
        
        // 1. Hapus yang lama
        DailyChallenge::where('is_auto_generated', true)->delete();
        \Log::info('Deleted old challenges');

        // 2. Buat 3 challenges manual tanpa random logic
        $challenges = [
            [
                'title' => 'Selesaikan 1 Quiz',
                'description' => 'Kerjakan satu quiz apapun hari ini',
                'type' => 'complete_quiz',
                'target_count' => 1,
                'xp_reward' => 25,
                'date' => today(),
                'is_active' => true,
                'is_auto_generated' => true,
            ],
            [
                'title' => 'Score Sempurna',
                'description' => 'Dapatkan score 100% pada satu quiz',
                'type' => 'perfect_score', 
                'target_count' => 1,
                'xp_reward' => 50,
                'date' => today(),
                'is_active' => true,
                'is_auto_generated' => true,
            ],
            [
                'title' => 'Quiz Master',
                'description' => 'Selesaikan 3 quiz berbeda',
                'type' => 'complete_quiz',
                'target_count' => 3,
                'xp_reward' => 100,
                'date' => today(),
                'is_active' => true,
                'is_auto_generated' => true,
            ]
        ];

        foreach ($challenges as $challenge) {
            DailyChallenge::create($challenge);
        }

        \Log::info('Created 3 new challenges');
        return 3;
    }

    public function hasGeneratedToday()
    {
        return DailyChallenge::where('date', today())
                           ->where('is_auto_generated', true)
                           ->exists();
    }
}