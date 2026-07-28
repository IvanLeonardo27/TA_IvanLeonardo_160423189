<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = 'vocabularies';

    protected $fillable = [
        'id',
        'indonesian_word',
        'javanese_ngoko',
        'javanese_krama',
        'category',
        'example_indonesian',
        'example_ngoko',
        'example_krama',
    ];
}
