<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
