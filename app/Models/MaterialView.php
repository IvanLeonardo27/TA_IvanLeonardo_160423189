<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialView extends Model
{
    use HasFactory;

    protected $table = 'material_views';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'material_id',
        'opened_at',
        'duration',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'duration'  => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
