<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'quiz_set_id',
        'question',
        'question_text',
        'question_type',
        'options',
        'correct_index',
        'correct_answer',
        'is_active',
        'status',
        'difficulty',
        'explanation',
        'score',
        'points',
        'created_by',
        'reviewed_by',
        'published_by',
    ];

    public function getQuestionAttribute(): string
    {
        return $this->attributes['question'] ?? ($this->attributes['question_text'] ?? '');
    }

    public function getQuestionTextAttribute(): string
    {
        return $this->attributes['question_text'] ?? ($this->attributes['question'] ?? '');
    }

    public function getCorrectIndexAttribute(): int
    {
        if (isset($this->attributes['correct_index']) && $this->attributes['correct_index'] !== null) {
            return (int) $this->attributes['correct_index'];
        }
        return isset($this->attributes['correct_answer']) ? (int) $this->attributes['correct_answer'] : 0;
    }

    protected $casts = [
        'options'       => 'array',
        'correct_index' => 'integer',
        'is_active'     => 'boolean',
        'points'        => 'integer',
        'score'         => 'integer',
    ];

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

    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }
}
