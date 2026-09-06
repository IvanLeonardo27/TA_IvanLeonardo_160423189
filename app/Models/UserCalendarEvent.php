<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCalendarEvent extends Model
{
    use HasFactory;

    protected $table = 'user_calendar_events';

    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'event_time',
        'description',
        'color',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Relasi ke Pengguna pemilik acara (Hanya dapat dilihat oleh pemiliknya)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format jam tampilan (misal 14:00)
     */
    public function getFormattedTimeAttribute(): string
    {
        if (empty($this->event_time)) {
            return 'Sepanjang Hari';
        }

        return Carbon::parse($this->event_time)->format('H:i');
    }
}
