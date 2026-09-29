<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_masters';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'is_active',
        'is_default',
        'time_limit_seconds',
        'max_attempts_per_player',
        'randomize_questions',
    ];

    protected $casts = [
        'is_active'               => 'boolean',
        'is_default'              => 'boolean',
        'randomize_questions'     => 'boolean',
        'time_limit_seconds'      => 'integer',
        'max_attempts_per_player' => 'integer',
    ];

    public function questions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(QuizQuestion::class, 'quiz_question_items', 'quiz_master_id', 'quiz_question_id')
                    ->withPivot('order_number')
                    ->withTimestamps()
                    ->orderByPivot('order_number', 'asc');
    }

    public function directQuestions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_master_id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'quiz_master_id');
    }

    public function classroomQuizzes(): HasMany
    {
        return $this->hasMany(ClassroomQuiz::class, 'quiz_master_id');
    }
}
