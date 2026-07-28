<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomPostAttachment extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id', 'original_name', 'file_path', 'file_size', 'mime_type'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassroomPost::class, 'post_id');
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }

    public function getFileIconAttribute(): string
    {
        $type = $this->mime_type ?? '';
        if (str_contains($type, 'pdf'))   return 'file-pdf';
        if (str_contains($type, 'word'))  return 'file-word';
        if (str_contains($type, 'image')) return 'file-image';
        if (str_contains($type, 'video')) return 'file-video';
        return 'file-lines';
    }
}
