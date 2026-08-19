<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialResource extends Model
{
    use HasFactory;

    protected $table = 'material_resources';

    protected $fillable = [
        'section_id',
        'resource_type',
        'title',
        'file_path',
        'file_size',
        'mime_type',
        'duration',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'duration'  => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(MaterialSection::class, 'section_id');
    }
}
