<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebutaneBocah extends Model
{
    use HasFactory;

    protected $table = 'sebutane_bocah';

    protected $fillable = [
        'javanese_term',
        'indonesia_meaning',
    ];

    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
