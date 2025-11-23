<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
    protected $fillable = ['user_id', 'daily_challenge_id', 'progress', 'is_completed', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyChallenge()
    {
        return $this->belongsTo(DailyChallenge::class);
    }

    public function incrementProgress()
    {
        $this->progress += 1;
        
        if ($this->progress >= $this->dailyChallenge->target_count && !$this->is_completed) {
            $this->complete();
        }
        
        $this->save();
    }

    public function complete()
    {
        $this->is_completed = true;
        $this->completed_at = now();
        
        // Beri reward XP
        $this->user->playerProfile->addXp($this->dailyChallenge->xp_reward);
    }
}