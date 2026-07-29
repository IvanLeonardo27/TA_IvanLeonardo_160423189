<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vocabulary extends Model
{
    protected $table = 'vocabularies';

    protected $fillable = [
        'id',
        'indonesian_word',
        'javanese_ngoko',
        'javanese_krama',
        'category',
    ];

    public function examples(): HasMany
    {
        return $this->hasMany(VocabularyExample::class, 'vocabulary_id');
    }
}
