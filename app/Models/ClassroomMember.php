<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomMember extends Model
{
    public $timestamps = false;

    protected $fillable = ['classroom_id', 'user_id', 'role', 'joined_at', 'out_at'];

    protected $casts = [
        'joined_at' => 'datetime',
        'out_at'    => 'datetime',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
