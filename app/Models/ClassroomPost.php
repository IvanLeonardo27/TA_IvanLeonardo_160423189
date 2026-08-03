<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomPost extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'classroom_id', 'author_id', 'type', 'title', 'body', 'is_pinned',
    ];

    protected $casts = ['is_pinned' => 'boolean'];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ClassroomPostAttachment::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ClassroomComment::class, 'post_id')->latest();
    }

    /** Hanya ada jika type = 'assignment' */
    public function assignment(): HasOne
    {
        return $this->hasOne(ClassroomAssignment::class, 'post_id');
    }

    /** Hanya ada jika type = 'quiz' */
    public function quiz(): HasOne
    {
        return $this->hasOne(ClassroomQuiz::class, 'post_id');
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'material'     => '#3B82F6',
            'assignment'   => '#EF4444',
            'quiz'         => '#8B5CF6',
            'announcement' => '#10B981',
            default        => '#6B7280',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'material'     => 'book-open',
            'assignment'   => 'clipboard-list',
            'quiz'         => 'pen-to-square',
            'announcement' => 'bullhorn',
            default        => 'info-circle',
        };
    }
}
