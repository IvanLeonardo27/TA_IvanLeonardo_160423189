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
        'week_titles',
    ];

    protected $casts = [
        'week_titles' => 'array',
    ];

    /**
     * Mendapatkan Judul Header Minggu/Section (Kustom dari Pengajar atau Default)
     */
    public function getWeekTitle(int $weekNumber): string
    {
        $titles = $this->week_titles ?? [];
        
        if (isset($titles[$weekNumber]) && !empty(trim($titles[$weekNumber]))) {
            return $titles[$weekNumber];
        }

        if ($weekNumber === 0) {
            return 'General';
        }

        return "Week {$weekNumber}";
    }

    /**
     * Menghitung Persentase Kemajuan Belajar Siswa di Kelas Ini (Real-time Dynamic Calculation)
     */
    public function getStudentProgressPercent(?int $studentId = null): int
    {
        $studentId = $studentId ?? auth()->id();
        if (!$studentId) return 0;

        // Total seluruh item evaluasi (Tugas dan Quiz) yang wajib dituntaskan
        $totalAssignments = ClassroomAssignment::whereHas('post', function ($q) {
            $q->where('classroom_id', $this->id);
        })->count();

        $totalQuizzes = ClassroomQuiz::whereHas('post', function ($q) {
            $q->where('classroom_id', $this->id);
        })->count();

        $totalItems = $totalAssignments + $totalQuizzes;
        if ($totalItems === 0) {
            return 0; // Default 0% jika kelas belum memiliki tugas/kuis
        }

        // Hitung tugas yang sudah dikumpulkan siswa
        $completedAssignments = ClassroomSubmission::whereHas('assignment.post', function ($q) {
            $q->where('classroom_id', $this->id);
        })->where('student_id', $studentId)
          ->distinct('assignment_id')
          ->count('assignment_id');

        // Hitung quiz yang sudah dikerjakan siswa
        $completedQuizzes = QuizAttempt::whereHas('quiz.post', function ($q) {
            $q->where('classroom_id', $this->id);
        })->where(function ($q) use ($studentId) {
            $q->where('student_id', $studentId)->orWhere('user_id', $studentId);
        })->distinct('quiz_id')
          ->count('quiz_id');

        $completedCount = $completedAssignments + $completedQuizzes;
        $percentage = (int) round(($completedCount / $totalItems) * 100);

        return min(100, max(0, $percentage));
    }

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
