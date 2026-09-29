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
        'syllable_breakdown',
    ];

    protected $casts = [
        'syllable_breakdown' => 'array',
    ];

    /**
     * Dapatkan pasangan [aksara, latin] per suku kata.
     * Menggunakan data kustom jika ada, atau auto-generate via JavaneseSyllableService.
     */
    public function getResolvedSyllablesAttribute(): array
    {
        if (!empty($this->syllable_breakdown)) {
            return is_array($this->syllable_breakdown)
                ? $this->syllable_breakdown
                : (json_decode($this->syllable_breakdown, true) ?: []);
        }

        return \App\Services\JavaneseSyllableService::alignSentence(
            $this->javanese_script_text,
            $this->javanese_latin_text
        );
    }

    /**
     * Relasi ke JavaneseScriptDetail (Many-to-One).
     */
    public function scriptDetail(): BelongsTo
    {
        return $this->belongsTo(JavaneseScriptDetail::class, 'script_detail_id');
    }
}
