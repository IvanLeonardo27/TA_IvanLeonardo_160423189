<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JavaneseScriptCategory extends Model
{
    use HasFactory;

    protected $table = 'javanese_script_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi ke JavaneseScriptDetail (One-to-Many).
     * Satu kategori aksara (misal: Aksara Carakan) memiliki banyak karakter aksara.
     */
    public function details(): HasMany
    {
        return $this->hasMany(JavaneseScriptDetail::class, 'category_id');
    }
}
