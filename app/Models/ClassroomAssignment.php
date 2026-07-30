<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomAssignment extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = ['post_id', 'material_id', 'due_date', 'max_score', 'instructions'];

    protected $casts = ['due_date' => 'datetime'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassroomPost::class, 'post_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ClassroomSubmission::class, 'assignment_id');
    }

    /** Submission milik student tertentu */
    public function mySubmission(): HasOne
    {
        return $this->hasOne(ClassroomSubmission::class, 'assignment_id')
                    ->where('student_id', auth()->id());
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast();
    }
}
