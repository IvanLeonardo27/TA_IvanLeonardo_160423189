<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'name',
        'code',
        'email',
        'role',
        'action',
        'action_type',
        'description',
        'target',
        'ip_address',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin'   => 'Administrator',
            'teacher' => 'Pengajar',
            'student' => 'Pelajar',
            default   => ucfirst($this->role ?? 'Tamu'),
        };
    }

    public function getTimestampAttribute()
    {
        return $this->created_at;
    }

    /**
     * Icon FontAwesome dinamis berdasarkan action_type (tanpa disimpan di database)
     */
    public function getIconAttribute(): string
    {
        return match($this->action_type) {
            'login'      => 'fa-solid fa-right-to-bracket',
            'logout'     => 'fa-solid fa-right-from-bracket',
            'classroom'  => 'fa-solid fa-chalkboard-user',
            'post'       => 'fa-solid fa-bullhorn',
            'submission' => 'fa-solid fa-file-arrow-up',
            'grade'      => 'fa-solid fa-check-double',
            'quiz'       => 'fa-solid fa-medal',
            'comment'    => 'fa-regular fa-comment-dots',
            'profile'    => 'fa-solid fa-user-pen',
            'material'   => 'fa-solid fa-book-open',
            default      => 'fa-solid fa-clock-rotate-left',
        };
    }

    /**
     * Warna Badge dinamis berdasarkan action_type (tanpa disimpan di database)
     */
    public function getBadgeColorAttribute(): string
    {
        return match($this->action_type) {
            'login'      => 'bg-success',
            'logout'     => 'bg-secondary',
            'classroom'  => 'bg-success',
            'post'       => 'bg-primary',
            'submission' => 'bg-info',
            'grade'      => 'bg-success',
            'quiz'       => 'bg-purple',
            'comment'    => 'bg-secondary',
            'profile'    => 'bg-warning',
            'material'   => 'bg-primary',
            default      => 'bg-secondary',
        };
    }

    /**
     * Helper statis untuk mencatat log aktivitas dengan cepat
     */
    public static function log($user, string $action, string $actionType, string $description, ?string $target = null, ?\DateTimeInterface $createdAt = null): self
    {
        $role = 'student';
        if ($user) {
            if ($user->isAdmin()) {
                $role = 'admin';
            } elseif ($user->isTeacher()) {
                $role = 'teacher';
            } else {
                $role = 'student';
            }
        }

        $req = request();

        return static::create([
            'user_id'     => $user?->id,
            'name'        => $user?->name ?? 'Tamu Sistem',
            'code'        => $user?->user_code ?? '-',
            'email'       => $user?->email ?? '-',
            'role'        => $role,
            'action'      => $action,
            'action_type' => $actionType,
            'description' => $description,
            'target'      => $target,
            'ip_address'  => $req ? $req->ip() : null,
            'created_at'  => $createdAt ?? now(),
            'updated_at'  => $createdAt ?? now(),
        ]);
    }
}
