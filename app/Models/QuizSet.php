<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizSet extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'is_active',
        'is_default',
        'time_limit_seconds',
        'max_attempts_per_player',
        'randomize_questions',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'randomize_questions' => 'boolean',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
