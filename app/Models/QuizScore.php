<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizScore extends Model
{
    use HasFactory;

    protected $table = 'quiz_scores';

    public $timestamps = false;

    protected $fillable = [
        'attempt_id',
        'total_score',
        'grade',
        'passed',
    ];

    protected $casts = [
        'total_score' => 'integer',
        'passed'      => 'boolean',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }
}
