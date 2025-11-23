<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'xp',
        'xp_needed',
        'history',
    ];    
    
    // Tambahkan method untuk auto level up
    // Method untuk menambah XP dengan auto level up
    public function addXp($amount)
    {
        $this->xp += $amount;
        
        // Check dan proses auto level up
        while ($this->xp >= $this->xp_needed) {
            $this->levelUp();
        }
        
        $this->save();
    }
    
    protected function levelUp()
    {
        // Kurangi XP dengan xp_needed level saat ini
        $this->xp -= $this->xp_needed;
        
        // Naik level
        $this->level += 1;
        
        // Tingkatkan XP needed untuk level berikutnya
        $this->xp_needed = $this->calculateXpForNextLevel();
        
        // Optional: Tambahkan reward atau notifikasi level up di sini
        // session()->flash('level_up', 'Selamat! Anda naik ke level ' . $this->level);
    }
    
    public function calculateXpForNextLevel()
    {
        // Formula: 100 * (level^1.5) 
        // Atau bisa pakai formula linear: 100 + (level * 50)
        return 100 + ($this->level * 50);
    }
    
    // Method untuk progress bar
    public function getLevelProgressPercentage()
    {
        if ($this->xp_needed <= 0) return 100;
        
        return min(100, round(($this->xp / $this->xp_needed) * 100));
    }
    
    // Method untuk mendapatkan XP yang dibutuhkan ke next level
    public function getXpToNextLevel()
    {
        return max(0, $this->xp_needed - $this->xp);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
