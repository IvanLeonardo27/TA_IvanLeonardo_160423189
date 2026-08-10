<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JavaneseCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'transliteration',
        'speech_text',
    ];
}
