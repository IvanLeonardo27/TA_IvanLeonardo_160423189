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

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class, 'quiz_set_id');
    }

    /** Attempt milik student tertentu */
    public function myAttempt(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(QuizAttempt::class, 'quiz_id')
                    ->where(function($q) {
                        $q->where('student_id', auth()->id())
                          ->orWhere('user_id', auth()->id());
                    })
                    ->latest();
    }

    /** Accessor cerdas untuk myAttempt (mencakup quiz_id, quiz_set_id, dan quiz_master_id) */
    public function getMyAttemptAttribute()
    {
        $userId = auth()->id();
        if (!$userId) {
            return null;
        }

        if ($this->relationLoaded('myAttempt')) {
            $rel = $this->getRelation('myAttempt');
            if ($rel) return $rel;
        }

        return QuizAttempt::query()
            ->where(function($q) {
                $q->where('quiz_id', $this->id);
                if (!empty($this->quiz_set_id)) {
                    $q->orWhere('quiz_set_id', $this->quiz_set_id);
                }
                if (!empty($this->quiz_master_id)) {
                    $q->orWhere('quiz_master_id', $this->quiz_master_id);
                }
            })
            ->where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('student_id', $userId);
            })
            ->latest('id')
            ->first();
    }

    /** Semua attempts pada quiz ini */
    public function attempts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'quiz_id');
    }
}

