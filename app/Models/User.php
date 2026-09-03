<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_code',
        'password',
        'role_id',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'password'   => 'hashed',
    ];

    /**
     * Relasi ke model Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    public function teacherProfile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class, 'user_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class, 'user_id');
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }

    public function classroomMemberships(): HasMany
    {
        return $this->hasMany(ClassroomMember::class, 'user_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ClassroomSubmission::class, 'student_id');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'user_id');
    }

    public function isTeacher(): bool
    {
        if (isset($this->attributes['role']) && $this->attributes['role'] === 'teacher') return true;
        if (isset($this->attributes['role_id']) && $this->attributes['role_id'] == 2) return true;
        return $this->role && $this->role->name === 'teacher';
    }

    public function isStudent(): bool
    {
        if (isset($this->attributes['role']) && $this->attributes['role'] === 'student') return true;
        if (isset($this->attributes['role_id']) && $this->attributes['role_id'] == 3) return true;
        return $this->role && $this->role->name === 'student';
    }

    public function isAdmin(): bool
    {
        if (isset($this->attributes['role']) && $this->attributes['role'] === 'admin') return true;
        if (isset($this->attributes['role_id']) && $this->attributes['role_id'] == 1) return true;
        return $this->role && $this->role->name === 'admin';
    }

    /**
     * Generate Kode Pengguna Unik Otomatis
     * - Pelajar (Student): 27705 + YY + sequence (e.g. 277052601)
     * - Pengajar (Teacher): 277 + YY + sequence (e.g. 2772601)
     */
    public static function generateUserCode(string $roleName, ?string $year = null): string
    {
        $yy = $year ?? date('y');
        $prefix = ($roleName === 'student') ? ('27705' . $yy) : ('277' . $yy);

        // Cari kode tertinggi dengan prefix tersebut
        $latestUser = self::where('user_code', 'LIKE', "{$prefix}%")
            ->orderBy('user_code', 'desc')
            ->first();

        if ($latestUser && !empty($latestUser->user_code)) {
            $lastSeq = (int) substr($latestUser->user_code, strlen($prefix));
            $nextSeq = $lastSeq + 1;
        } else {
            // Hitung total pengguna dengan role tersebut di tahun ini sebagai baseline
            $role = Role::where('name', $roleName)->first();
            $count = $role ? self::where('role_id', $role->id)->count() : 0;
            $nextSeq = max(1, $count + 1);
        }

        do {
            $code = $prefix . sprintf('%02d', $nextSeq);
            $exists = self::where('user_code', $code)->exists();
            if ($exists) {
                $nextSeq++;
            }
        } while ($exists);

        return $code;
    }
}
