<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'teacher_id',
        'title',
        'type', // general, unggah_ungguh, sastra_jawa, aksara_jawa
        'description',
        'thumbnail',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(MaterialAttachment::class);
    }

    public function unggahUngguhBasas(): HasMany
    {
        return $this->hasMany(UnggahUngguhBasa::class);
    }

    public function sastraJawas(): HasMany
    {
        return $this->hasMany(SastraJawa::class);
    }
}
