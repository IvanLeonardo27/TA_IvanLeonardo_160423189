<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaterialTag extends Model
{
    use HasFactory;

    protected $table = 'material_tags';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'material_tag_details', 'tag_id', 'material_id');
    }
}
