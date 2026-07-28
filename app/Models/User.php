<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'photo',
        'status',
        'last_login',
    ];

    /**
     * Relasi ke model Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isTeacher(): bool
    {
        return $this->role && $this->role->name === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role && $this->role->name === 'student';
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }
}
