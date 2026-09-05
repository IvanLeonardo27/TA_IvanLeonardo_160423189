<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomComment extends Model
{
    use SoftDeletes;
    protected $fillable = ['post_id', 'user_id', 'comment', 'body'];

    protected static function booted(): void
    {
        static::saving(function (ClassroomComment $c) {
            $val = $c->attributes['comment'] ?? $c->attributes['body'] ?? null;
            if ($val !== null) {
                $c->attributes['comment'] = $val;
                $c->attributes['body'] = $val;
            }
        });
    }

    public function getCommentAttribute(): ?string
    {
        return $this->attributes['comment'] ?? $this->attributes['body'] ?? null;
    }

    public function getBodyAttribute(): ?string
    {
        return $this->attributes['body'] ?? $this->attributes['comment'] ?? null;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassroomPost::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
