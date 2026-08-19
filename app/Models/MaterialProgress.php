<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialProgress extends Model
{
    use HasFactory;

    protected $table = 'material_progress';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'material_id',
        'percentage',
        'completed',
    ];

    protected $casts = [
        'percentage' => 'integer',
        'completed'  => 'boolean',
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
