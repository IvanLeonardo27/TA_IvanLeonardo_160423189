<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomQuiz extends Model
{
    use SoftDeletes;

    protected $table = 'classroom_quizzes';

    protected $fillable = [
        'post_id',
        'quiz_set_id',
        'due_date',
        'duration_minutes',
        'max_score',
        'show_score',
        'max_attempts',
        'instructions',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'duration_minutes' => 'integer',
        'max_score' => 'integer',
        'show_score' => 'boolean',
        'max_attempts' => 'integer',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassroomPost::class, 'post_id');
    }

    public function quizSet(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class, 'quiz_set_id');
    }
}
