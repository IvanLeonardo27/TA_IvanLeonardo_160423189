<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WayangCategory extends Model
{
    use HasFactory;

    protected $table = 'wayang_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(WayangCharacter::class, 'category_id');
    }
}
