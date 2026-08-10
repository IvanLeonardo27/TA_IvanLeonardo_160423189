<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnggahUngguhBasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'context_scenario',
        'ngoko_text',
        'krama_text',
        'indonesian_text',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
