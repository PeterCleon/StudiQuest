<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'xp',
        'created_by',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot(['score', 'details', 'created_at'])
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk quiz aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk quiz tidak aktif
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}