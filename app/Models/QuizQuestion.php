<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'quiz_set_id',
        'question',
        'options',
        'correct_index',
        'is_active',
        'status',
        'difficulty',
        'explanation',
        'points',
        'created_by',
        'reviewed_by',
        'published_by',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_index' => 'integer',
        'is_active' => 'boolean',
        'points' => 'integer',
    ];

    public function quizSet(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class);
    }
}
