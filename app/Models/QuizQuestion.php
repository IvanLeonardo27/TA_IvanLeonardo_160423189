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
        'teacher_id',
        'quiz_id',
        'quiz_master_id',
        'quiz_set_id',
        'category',
        'question',
        'question_text',
        'image_path',
        'question_type',
        'options',
        'option_percentages',
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

    /**
     * Mengambil array persentase nilai opsi [index => persen]
     * Jika null, otomatis fallback: correct_index = 100, opsi lain = 0
     */
    public function getOptionPercentagesAttribute(): array
    {
        if (!empty($this->attributes['option_percentages'])) {
            $decoded = is_string($this->attributes['option_percentages'])
                ? json_decode($this->attributes['option_percentages'], true)
                : $this->attributes['option_percentages'];
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        $options = $this->options ?? [];
        $weights = [];
        $correct = $this->correct_index;
        foreach ($options as $idx => $opt) {
            $weights[$idx] = ($idx === $correct) ? 100 : 0;
        }
        return $weights;
    }

    protected $casts = [
        'options'            => 'array',
        'option_percentages' => 'array',
        'correct_index'      => 'integer',
        'is_active'          => 'boolean',
        'points'             => 'integer',
        'score'              => 'integer',
    ];

    public function getQuizSetIdAttribute()
    {
        return $this->quiz_master_id;
    }

    public function setQuizSetIdAttribute($value)
    {
        $this->attributes['quiz_master_id'] = $value;
    }

    public function quizSet(): BelongsTo
    {
        return $this->belongsTo(QuizMaster::class, 'quiz_master_id');
    }

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(QuizMaster::class, 'quiz_master_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(ClassroomQuiz::class, 'quiz_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function quizMasters(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(QuizMaster::class, 'quiz_question_items', 'quiz_question_id', 'quiz_master_id')
                    ->withPivot('order_number')
                    ->withTimestamps();
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
