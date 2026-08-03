<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'quiz_set_id',
        'user_id',
        'player_name',
        'score',
        'started_at',
        'time_spent_seconds',
        'taken_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'time_spent_seconds' => 'integer',
        'started_at' => 'datetime',
        'taken_at' => 'datetime',
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
        return $this->belongsTo(QuizSet::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAttemptAnswer::class);
    }
}
