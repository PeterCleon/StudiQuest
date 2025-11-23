<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyChallenge;

class GenerateDailyChallenges extends Command
{
    protected $signature = 'challenges:generate-daily';
    protected $description = 'Generate daily challenges automatically';

    // Pool challenges
    protected $challengePool = [
        [
            'title' => 'Selesaikan 1 Quiz',
            'description' => 'Kerjakan satu quiz apapun hari ini',
            'type' => 'complete_quiz',
            'target_count' => 1,
            'xp_reward' => 25,
        ],
        [
            'title' => 'Score Sempurna',
            'description' => 'Dapatkan score 100% pada satu quiz', 
            'type' => 'perfect_score',
            'target_count' => 1,
            'xp_reward' => 50,
        ],
        [
            'title' => 'Quiz Master', 
            'description' => 'Selesaikan 3 quiz berbeda',
            'type' => 'complete_quiz',
            'target_count' => 3,
            'xp_reward' => 100,
        ],
    ];

    public function handle()
    {
        $this->info('Starting daily challenge generation...');
        
        // Hapus yang lama
        DailyChallenge::where('is_auto_generated', true)->delete();
        $this->info('Deleted old challenges');

        // Pilih 3 random dari pool
        $selectedChallenges = $this->selectRandomChallenges(3);

        foreach ($selectedChallenges as $challenge) {
            DailyChallenge::create([
                'title' => $challenge['title'],
                'description' => $challenge['description'],
                'type' => $challenge['type'],
                'target_count' => $challenge['target_count'],
                'xp_reward' => $challenge['xp_reward'],
                'date' => now()->format('Y-m-d'),
                'is_active' => true,
                'is_auto_generated' => true,
            ]);
            $this->info("Created: {$challenge['title']}");
        }

        $this->info("✅ Successfully generated " . count($selectedChallenges) . " daily challenges");
    }

    protected function selectRandomChallenges($count = 3)
    {
        // Acak array pool
        shuffle($this->challengePool);
        
        // Ambil $count pertama
        return array_slice($this->challengePool, 0, $count);
    }
}