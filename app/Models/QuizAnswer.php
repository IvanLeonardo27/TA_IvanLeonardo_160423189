<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_answers';

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option',
        'is_correct',
        'score_earned',
        'score',
        'option_id',
        'essay_answer',
    ];

    protected $casts = [
        'is_correct'   => 'boolean',
        'score_earned' => 'integer',
    ];

    public function getScoreAttribute(): int
    {
        return (int) ($this->attributes['score_earned'] ?? 0);
    }

    public function setScoreAttribute($value): void
    {
        $this->attributes['score_earned'] = (int) $value;
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
