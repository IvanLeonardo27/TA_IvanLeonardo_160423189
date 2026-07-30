<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomSubmission extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'assignment_id', 'student_id', 'original_name', 'file_path',
        'note', 'score', 'teacher_feedback', 'status',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

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
