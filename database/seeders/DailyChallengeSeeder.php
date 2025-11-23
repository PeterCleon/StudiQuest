<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyChallenge;

class DailyChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Selesaikan 1 Quiz',
                'description' => 'Kerjakan satu quiz apapun hari ini',
                'type' => 'complete_quiz',
                'target_count' => 1,
                'xp_reward' => 25,
                'date' => today(),
                'is_active' => true,
            ],
            [
                'title' => 'Score Sempurna',
                'description' => 'Dapatkan score 100% pada satu quiz',
                'type' => 'perfect_score',
                'target_count' => 1,
                'xp_reward' => 50,
                'date' => today(),
                'is_active' => true,
            ],
            [
                'title' => 'Quiz Master',
                'description' => 'Selesaikan 3 quiz berbeda',
                'type' => 'complete_quiz',
                'target_count' => 3,
                'xp_reward' => 100,
                'date' => today(),
                'is_active' => true,
            ],
        ];

        foreach ($challenges as $challenge) {
            DailyChallenge::create($challenge);
        }
    }
}