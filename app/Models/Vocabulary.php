<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vocabulary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vocabularies';

    protected $fillable = [
        'indonesian_word',
        'javanese_ngoko',
        'javanese_krama',
        'category',
        'category_id',
    ];

    public function examples(): HasMany
    {
        return $this->hasMany(VocabularyExample::class, 'vocabulary_id');
    }

    public function categoryObj(): BelongsTo
    {
        return $this->belongsTo(VocabularyCategory::class, 'category_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(VocabularyView::class, 'vocabulary_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(VocabularyBookmark::class, 'vocabulary_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(VocabularyProgress::class, 'vocabulary_id');
    }
}
