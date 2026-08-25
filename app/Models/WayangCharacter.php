<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WayangCharacter extends Model
{
    use HasFactory;

    protected $table = 'wayang_characters';

    protected $fillable = [
        'category_id',
        'name',
        'other_names',
        'gender',
        'role',
        'character_traits',
        'weapon',
        'family',
        'allegiance',
        'description',
        'story',
        'image_path',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(WayangCategory::class, 'category_id');
    }
}
