<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomSubmission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'original_name',
        'original_filename',
        'note',
        'notes',
        'score',
        'graded_at',
        'teacher_feedback',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at'    => 'datetime',
        'score'        => 'integer',
    ];

    public function setOriginalNameAttribute($value)
    {
        $this->attributes['original_name'] = $value;
        $this->attributes['original_filename'] = $value;
    }

    public function setOriginalFilenameAttribute($value)
    {
        $this->attributes['original_filename'] = $value;
        $this->attributes['original_name'] = $value;
    }

    public function getOriginalNameAttribute()
    {
        return $this->attributes['original_name'] ?? $this->attributes['original_filename'] ?? null;
    }

    public function getOriginalFilenameAttribute()
    {
        return $this->attributes['original_filename'] ?? $this->attributes['original_name'] ?? null;
    }

    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = $value;
        $this->attributes['notes'] = $value;
    }

    public function setNotesAttribute($value)
    {
        $this->attributes['notes'] = $value;
        $this->attributes['note'] = $value;
    }

    public function getNoteAttribute()
    {
        return $this->attributes['note'] ?? $this->attributes['notes'] ?? null;
    }

    public function getNotesAttribute()
    {
        return $this->attributes['notes'] ?? $this->attributes['note'] ?? null;
    }

    public function getStatusAttribute()
    {
        if (!empty($this->attributes['status'])) {
            return $this->attributes['status'];
        }
        if ($this->score !== null || $this->graded_at !== null) {
            return 'graded';
        }
        return 'submitted';
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ClassroomAssignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'graded'   => '<span class="badge bg-success rounded-pill">Sudah Dinilai</span>',
            'returned' => '<span class="badge bg-warning text-dark rounded-pill">Dikembalikan</span>',
            default    => '<span class="badge bg-info text-dark rounded-pill">Diserahkan</span>',
        };
    }
}
