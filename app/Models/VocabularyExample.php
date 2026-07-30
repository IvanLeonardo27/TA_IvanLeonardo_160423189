<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class VocabularyExample extends Model
{
    use SoftDeletes;
    protected $table = 'vocabulary_examples';

    public $timestamps = false;

    protected $fillable = [
        'vocabulary_id',
        'indonesian_sentence',
        'ngoko_sentence',
        'krama_sentence',
        'javanese_sentence',
        'created_at',
    ];

    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
