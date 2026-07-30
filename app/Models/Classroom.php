<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'teacher_id', 'name', 'description', 'subject',
        'code', 'banner_color', 'banner_icon', 'status',
    ];

    /** Pengajar/owner kelas */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /** Seluruh anggota aktif melalui pivot classroom_members */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'classroom_members', 'classroom_id', 'user_id')
                    ->wherePivotNull('out_at')
                    ->withPivot('role', 'joined_at', 'out_at');
    }

    /** Hanya siswa aktif */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'classroom_members', 'classroom_id', 'user_id')
                    ->wherePivot('role', 'student')
                    ->wherePivotNull('out_at')
                    ->withPivot('joined_at', 'out_at');
    }

    /** Seluruh post (pengumuman, materi, tugas) */
    public function posts(): HasMany
    {
        return $this->hasMany(ClassroomPost::class)->latest();
    }

    /** Hanya post pengumuman */
    public function announcements(): HasMany
    {
        return $this->hasMany(ClassroomPost::class)->where('type', 'announcement')->latest();
    }

    /** Hanya post assignment */
    public function assignments(): HasMany
    {
        return $this->hasMany(ClassroomPost::class)->where('type', 'assignment')->latest();
    }

    /** Generate kode kelas unik */
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(\Illuminate\Support\Str::random(4)) . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
