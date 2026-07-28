<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomComment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comment'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassroomPost::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
