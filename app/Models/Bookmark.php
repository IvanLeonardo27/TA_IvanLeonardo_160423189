<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
    ];

    /**
     * Relasi Polymorphic untuk mendapatkan objek materi yang dibookmark
     * (bisa berupa WayangCharacter, MacapatDetail, JavaneseScriptDetail, Vocabulary, dll)
     */
    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke User pemilik bookmark
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
