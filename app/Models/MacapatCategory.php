<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MacapatCategory extends Model
{
    use HasFactory;

    protected $table = 'macapat_categories';

    protected $fillable = [
        'name',
        'guru_gatra',
        'guru_wilangan',
        'guru_lagu',
        'watak',
        'description',
    ];

    /**
     * Relasi ke MacapatDetail (One-to-Many).
     * Satu kategori Tembang Macapat dapat memiliki banyak contoh bait.
     */
    public function details(): HasMany
    {
        return $this->hasMany(MacapatDetail::class, 'macapat_category_id');
    }
}
