<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MacapatDetail extends Model
{
    use HasFactory;

    protected $table = 'macapat_details';

    protected $fillable = [
        'macapat_category_id',
        'verse',
        'meaning',
        'audio_path',
    ];

    /**
     * Relasi ke MacapatCategory (Many-to-One).
     * Setiap detail/bait tembang berinduk ke satu kategori Tembang Macapat.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MacapatCategory::class, 'macapat_category_id');
    }

    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
