<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JavaneseScriptExample extends Model
{
    use HasFactory;

    protected $table = 'javanese_script_examples';

    protected $fillable = [
        'script_detail_id',
        'javanese_script_text',
        'javanese_latin_text',
        'indonesian_text',
    ];

    /**
     * Relasi ke JavaneseScriptDetail (Many-to-One).
     */
    public function scriptDetail(): BelongsTo
    {
        return $this->belongsTo(JavaneseScriptDetail::class, 'script_detail_id');
    }
}
