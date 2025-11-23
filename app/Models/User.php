<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'name',
        'email',
        'gender',
        'password',
        'kelas',
        'jurusan',
        'nisn',
        'phone',
        'bio',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Scope untuk role
    public function scopeSiswa($query)
    {
        return $query->where('role', 'siswa');
    }

    public function scopeGuru($query)
    {
        return $query->where('role', 'guru');
    }

    // Relationship
    public function playerProfile()
    {
        return $this->hasOne(PlayerProfile::class, 'user_id');
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)
                    ->withPivot(['score', 'details', 'created_at'])
                    ->withTimestamps();
    }
}