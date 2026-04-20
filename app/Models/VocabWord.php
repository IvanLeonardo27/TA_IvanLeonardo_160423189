<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabWord extends Model
{
    protected $fillable = [
        'vocab_category_id',
        'indo',
        'jawa',
        'emoji',
        'is_published',
        'status',
        'submitted_at',
        'reviewed_at',
        'published_at',
        'created_by',
        'reviewed_by',
        'published_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VocabCategory::class, 'vocab_category_id');
    }
}
