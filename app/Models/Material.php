<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'teacher_id',
        'title',
        'type', // general, sastra_jawa, aksara_jawa
        'description',
        'thumbnail',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(MaterialAttachment::class, 'material_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(MaterialSection::class, 'material_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(MaterialTag::class, 'material_tag_details', 'material_id', 'tag_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(MaterialView::class, 'material_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(MaterialBookmark::class, 'material_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(MaterialProgress::class, 'material_id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'material_id');
    }
}
