<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrutaneTurunan extends Model
{
    use HasFactory;

    protected $table = 'urutane_turunan';

    protected $fillable = [
        'javanese_term',
        'indonesia_meaning',
    ];

    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
