<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    use HasFactory;

    protected $table = 'student_profiles';

    public const GRADE_LEVELS = [
        'Kelas 1',
        'Kelas 2',
        'Kelas 3',
        'Kelas 4',
        'Kelas 5',
        'Kelas 6',
        'Kelas 7',
        'Kelas 8',
        'Kelas 9',
        'Kelas 10',
        'Kelas 11',
        'Kelas 12',
        'Diploma 1',
        'Diploma 2',
        'Diploma 3',
        'Diploma 4',
        'Sarjana 1',
        'Sarjana 2',
        'Sarjana 3',
    ];

    protected $fillable = [
        'user_id',
        'nisn',
        'grade_level',
        'phone_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
