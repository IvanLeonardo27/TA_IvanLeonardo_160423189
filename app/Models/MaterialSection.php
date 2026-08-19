<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialSection extends Model
{
    use HasFactory;

    protected $table = 'material_sections';

    protected $fillable = [
        'material_id',
        'title',
        'description',
        'order_number',
    ];

    protected $casts = [
        'order_number' => 'integer',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(MaterialResource::class, 'section_id');
    }
}
