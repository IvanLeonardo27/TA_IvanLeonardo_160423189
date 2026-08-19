<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabularyProgress extends Model
{
    use HasFactory;

    protected $table = 'vocabulary_progress';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'vocabulary_id',
        'is_mastered',
    ];

    protected $casts = [
        'is_mastered' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
