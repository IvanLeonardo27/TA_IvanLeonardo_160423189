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
        'classroom_id', 'author_id', 'type', 'title', 'body', 'link_url', 'week_number', 'is_published',
    ];

    protected $casts = [
        'week_number' => 'integer',
        'is_published' => 'boolean',
    ];

    public function getUrlAttribute(): ?string
    {
        return $this->link_url;
    }

    public function setUrlAttribute($value): void
    {
        $this->attributes['link_url'] = $value;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Menghitung Week Keberapa untuk Post ini:
     * 1. Jika diketik/dipilih langsung oleh pengajar -> gunakan week_number.
     * 2. Jika tidak dipilih -> dihitung otomatis berbasis rentang 7 hari sejak kelas dibuat.
     */
    public function getCalculatedWeekNumberAttribute(): int
    {
        if ($this->week_number !== null) {
            return (int) $this->week_number;
        }

        if (!$this->classroom || !$this->classroom->created_at) {
            return 1;
        }

        $daysDiff = $this->created_at->diffInDays($this->classroom->created_at);
        $week = (int) floor($daysDiff / 7) + 1;

        return max(1, $week);
    }

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
            'url'          => '#0284C7',
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
            'url'          => 'link',
            default        => 'info-circle',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'material'     => 'Materi',
            'assignment'   => 'Tugas',
            'quiz'         => 'Evaluasi / Quiz',
            'announcement' => 'Pengumuman',
            'url'          => 'Tautan URL',
            default        => ucfirst($this->type ?? 'Postingan'),
        };
    }

    public function getLinkDomainAttribute(): string
    {
        if (empty($this->link_url)) return '';
        $host = parse_url($this->link_url, PHP_URL_HOST);
        return $host ? preg_replace('/^www\./', '', $host) : '';
    }

    /** Mendapatkan daftar slide materi jika diposting dalam format slide / PPT */
    public function getSlidesAttribute(): array
    {
        if (empty($this->body)) return [];

        $trimmed = trim($this->body);
        if (str_starts_with($trimmed, '{') || str_starts_with($trimmed, '[')) {
            $decoded = json_decode($trimmed, true);
            if (is_array($decoded) && isset($decoded['slides']) && is_array($decoded['slides'])) {
                return $decoded['slides'];
            }
            if (is_array($decoded) && isset($decoded['total_slides'])) {
                $total = (int) $decoded['total_slides'];
                $slides = [];
                for ($i = 1; $i <= $total; $i++) {
                    $slides[] = [
                        'title'   => "Slide {$i}",
                        'content' => $decoded['plain_summary'] ?? "Halaman {$i} dari berkas presentasi.",
                        'is_ppt'  => true,
                    ];
                }
                return $slides;
            }
        }

        // Jika dipisahkan dengan separator slide ---slide---
        if (str_contains($this->body, '---slide---')) {
            $parts = explode('---slide---', $this->body);
            $slides = [];
            foreach ($parts as $idx => $part) {
                $pTrimmed = trim($part);
                if (!empty($pTrimmed)) {
                    $slides[] = [
                        'title'   => 'Slide ' . ($idx + 1),
                        'content' => $pTrimmed,
                    ];
                }
            }
            return $slides;
        }

        return [];
    }

    public function getHasSlidesAttribute(): bool
    {
        return count($this->slides) > 1;
    }

    /** Mengambil nomor slide tempat pertanyaan checkpoint muncul */
    public function getCheckpointSlideAttribute(): int
    {
        if (!empty($this->body)) {
            $trimmed = trim($this->body);
            if (str_starts_with($trimmed, '{')) {
                $decoded = json_decode($trimmed, true);
                if (isset($decoded['checkpoint']['checkpoint_slide'])) {
                    return (int) $decoded['checkpoint']['checkpoint_slide'];
                }
            }
        }

        if (!$this->quiz) return 0;
        
        // Cek dari instructions atau difficulty di quiz question
        if (preg_match('/checkpoint_slide:(\d+)/', $this->quiz->instructions ?? '', $matches)) {
            return (int) $matches[1];
        }

        $firstQuestion = $this->quiz->quizSet?->questions?->first();
        if ($firstQuestion && preg_match('/checkpoint_slide:(\d+)/', $firstQuestion->explanation ?? '', $matches)) {
            return (int) $matches[1];
        }

        return (int) ceil(count($this->slides) / 2); // Default di tengah-tengah
    }

    public function getCheckpointQuestionAttribute(): ?object
    {
        if (!empty($this->body)) {
            $trimmed = trim($this->body);
            if (str_starts_with($trimmed, '{')) {
                $decoded = json_decode($trimmed, true);
                if (isset($decoded['checkpoint']) && !empty($decoded['checkpoint']['question'])) {
                    return (object) [
                        'question'      => $decoded['checkpoint']['question'],
                        'options'       => $decoded['checkpoint']['options'] ?? [],
                        'correct_index' => (int) ($decoded['checkpoint']['correct_index'] ?? 0),
                    ];
                }
            }
        }

        $q = $this->quiz?->quizSet?->questions?->first();
        if ($q) {
            return (object) [
                'question'      => $q->question,
                'options'       => $q->options,
                'correct_index' => (int) $q->correct_index,
            ];
        }

        return null;
    }
}
