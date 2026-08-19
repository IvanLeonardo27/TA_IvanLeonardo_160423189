<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialTagDetail extends Model
{
    use HasFactory;

    protected $table = 'material_tag_details';

    public $timestamps = false;

    protected $fillable = [
        'material_id',
        'tag_id',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(MaterialTag::class, 'tag_id');
    }
}
