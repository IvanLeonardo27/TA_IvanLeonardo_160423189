<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'quiz_set_id',
        'user_id',
        'student_id',
        'player_name',
        'score',
        'started_at',
        'time_spent_seconds',
        'taken_at',
        'start_time',
        'finish_time',
        'status',
    ];

    protected $casts = [
        'score'              => 'integer',
        'time_spent_seconds' => 'integer',
        'started_at'         => 'datetime',
        'taken_at'           => 'datetime',
        'start_time'         => 'datetime',
        'finish_time'        => 'datetime',
    ];

    public function getTimeSpentFormattedAttribute(): string
    {
        $secs = $this->time_spent_seconds;
        if (!$secs || $secs <= 0) {
            return '< 1 Menit';
        }
        $mins = floor($secs / 60);
        $remSecs = $secs % 60;
        if ($mins <= 0) {
            return "{$remSecs} Detik";
        }
        if ($remSecs <= 0) {
            return "{$mins} Menit";
        }
        return "{$mins} M {$remSecs} D";
    }

    public function quizSet(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class, 'quiz_set_id');
    }

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class, 'quiz_set_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(ClassroomQuiz::class, 'quiz_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    public function quizScore(): HasOne
    {
        return $this->hasOne(QuizScore::class, 'attempt_id');
    }

    public function quizReview(): HasOne
    {
        return $this->hasOne(QuizReview::class, 'attempt_id');
    }
}
