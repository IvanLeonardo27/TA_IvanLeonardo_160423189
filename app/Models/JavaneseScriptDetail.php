<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JavaneseScriptDetail extends Model
{
    use HasFactory;

    protected $table = 'javanese_script_details';

    protected $fillable = [
        'category_id',
        'name',
        'latin',
        'pronunciation',
        'image_path',
        'audio_path',
        'description',
    ];

    /**
     * Relasi ke JavaneseScriptCategory (Many-to-One).
     * Setiap detail karakter aksara berinduk ke satu kategori aksara.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JavaneseScriptCategory::class, 'category_id');
    }

    /**
     * Relasi ke JavaneseScriptExample (One-to-Many).
     * Contoh kalimat penggunaan aksara Jawa.
     */
    public function examples(): HasMany
    {
        return $this->hasMany(JavaneseScriptExample::class, 'script_detail_id');
    }

    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
