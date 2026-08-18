<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomQuiz;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller
{
    /**
     * Tampilkan Kalender Pembelajaran Interaktif & Sinkronisasi Google Calendar
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isTeacher = $user->isTeacher();

        // Ambil ID seluruh kelas aktif yang diikuti atau diajar oleh pengguna
        if ($isTeacher) {
            $classroomIds = Classroom::where('teacher_id', $user->id)
                ->where('status', 'active')
                ->pluck('id')
                ->toArray();
        } else {
            $classroomIds = Classroom::whereHas('members', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->whereNull('out_at');
                })
                ->where('status', 'active')
                ->pluck('id')
                ->toArray();
        }

        // Tentukan Bulan & Tahun Kalender (default bulan ini)
        $month = $request->integer('month', now()->month);
        $year  = $request->integer('year', now()->year);
        $currentDate = Carbon::createFromDate($year, $month, 1);

        // Ambil Data Tugas (Assignments) yang memiliki batas waktu
        $assignments = ClassroomAssignment::whereHas('post', function ($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds);
            })
            ->whereNotNull('due_date')
            ->with(['post.classroom', 'mySubmission'])
            ->get();

        // Ambil Data Kuis / Evaluasi (Quizzes) yang memiliki batas waktu
        $quizzes = ClassroomQuiz::whereHas('post', function ($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds);
            })
            ->whereNotNull('due_date')
            ->with(['post.classroom', 'quizSet'])
            ->get();

        // Ambil Materi Pembelajaran / Kegiatan Kelas Terkini
        $materials = ClassroomPost::whereIn('classroom_id', $classroomIds)
            ->where('type', 'material')
            ->with(['classroom', 'author', 'attachments'])
            ->latest()
            ->take(30)
            ->get();

        $events = collect();

        // Helper untuk membuat URL Google Calendar One-Click Add
        $generateGCalUrl = function ($title, $typeLabel, $classroomName, Carbon $dt, $url, $statusLabel) {
            $startUtc = $dt->copy()->utc()->format('Ymd\THis\Z');
            $endUtc   = $dt->copy()->addHour()->utc()->format('Ymd\THis\Z');
            $summary  = "[BasaKula {$typeLabel}] " . $title;
            $details  = "Pengingat Jadwal Pembelajaran BasaKula\n"
                      . "Agenda: " . $title . "\n"
                      . "Jenis: " . $typeLabel . "\n"
                      . "Ruang Kelas: " . $classroomName . "\n"
                      . "Status: " . $statusLabel . "\n"
                      . "Tautan Langsung: " . $url;
            return "https://calendar.google.com/calendar/render?action=TEMPLATE"
                 . "&text=" . urlencode($summary)
                 . "&dates=" . $startUtc . "/" . $endUtc
                 . "&details=" . urlencode($details)
                 . "&location=" . urlencode($classroomName);
        };

        // 1. Format Events: Tugas (Assignment)
        foreach ($assignments as $asn) {
            $isSubmitted = !$isTeacher && $asn->mySubmission !== null;
            $isOverdue   = $asn->due_date && $asn->due_date->isPast() && !$isSubmitted;
            $statusLabel = $isSubmitted ? 'Sudah Dikumpulkan' : ($isOverdue ? 'Terlewat' : 'Belum Selesai');
            $itemUrl     = $isTeacher 
                                ? route('teacher.classroom.show', $asn->post->classroom_id) 
                                : route('student.classroom.submission.show', $asn);

            $events->push([
                'id'          => 'asn_' . $asn->id,
                'raw_id'      => $asn->id,
                'title'       => $asn->post->title ?? 'Tugas Pembelajaran',
                'type'        => 'assignment',
                'type_label'  => 'Tugas',
                'classroom'   => $asn->post->classroom->name ?? 'Kelas',
                'classroom_id'=> $asn->post->classroom_id,
                'date'        => $asn->due_date->format('Y-m-d'),
                'time'        => $asn->due_date->format('H:i'),
                'datetime'    => $asn->due_date,
                'formatted'   => $asn->due_date->translatedFormat('d F Y, H:i'),
                'is_past'     => $asn->due_date->isPast(),
                'status'      => $isSubmitted ? 'submitted' : ($isOverdue ? 'overdue' : 'pending'),
                'status_label'=> $statusLabel,
                'bg_color'    => '#EF4444', // Red
                'text_color'  => '#991B1B',
                'badge_class' => 'bg-danger-subtle text-danger border border-danger',
                'icon'        => 'fa-solid fa-file-signature',
                'url'         => $itemUrl,
                'gcal_url'    => $generateGCalUrl($asn->post->title ?? 'Tugas Pembelajaran', 'Tugas', $asn->post->classroom->name ?? 'Kelas', $asn->due_date, $itemUrl, $statusLabel),
                'description' => $asn->instructions ?? 'Tugas wajib dengan batas waktu pengumpulan.',
            ]);
        }

        // 2. Format Events: Evaluasi / Kuis (Quiz)
        foreach ($quizzes as $quiz) {
            $hasAttempt = false;
            if (!$isTeacher) {
                $hasAttempt = QuizAttempt::where('quiz_set_id', $quiz->quiz_set_id)
                    ->where('user_id', $user->id)
                    ->exists();
            }
            $isOverdue   = $quiz->due_date && $quiz->due_date->isPast() && !$hasAttempt;
            $statusLabel = $hasAttempt ? 'Sudah Dikerjakan' : ($isOverdue ? 'Batas Waktu Berakhir' : 'Wajib Dikerjakan');
            $itemUrl     = $isTeacher 
                                ? route('teacher.classroom.show', $quiz->post->classroom_id) 
                                : route('student.classroom.quiz.show', $quiz);

            $events->push([
                'id'          => 'quiz_' . $quiz->id,
                'raw_id'      => $quiz->id,
                'title'       => $quiz->post->title ?? 'Kuis / Evaluasi',
                'type'        => 'quiz',
                'type_label'  => 'Kuis / Evaluasi',
                'classroom'   => $quiz->post->classroom->name ?? 'Kelas',
                'classroom_id'=> $quiz->post->classroom_id,
                'date'        => $quiz->due_date->format('Y-m-d'),
                'time'        => $quiz->due_date->format('H:i'),
                'datetime'    => $quiz->due_date,
                'formatted'   => $quiz->due_date->translatedFormat('d F Y, H:i'),
                'is_past'     => $quiz->due_date->isPast(),
                'status'      => $hasAttempt ? 'submitted' : ($isOverdue ? 'overdue' : 'pending'),
                'status_label'=> $statusLabel,
                'bg_color'    => '#8B5CF6', // Purple
                'text_color'  => '#5B21B6',
                'badge_class' => 'bg-purple-subtle text-purple border',
                'icon'        => 'fa-solid fa-pen-to-square',
                'url'         => $itemUrl,
                'gcal_url'    => $generateGCalUrl($quiz->post->title ?? 'Kuis / Evaluasi', 'Kuis', $quiz->post->classroom->name ?? 'Kelas', $quiz->due_date, $itemUrl, $statusLabel),
                'description' => $quiz->instructions ?? 'Kuis evaluasi dengan durasi ' . $quiz->duration_minutes . ' menit.',
            ]);
        }

        // 3. Format Events: Materi Pembelajaran (Material)
        foreach ($materials as $mat) {
            $statusLabel = 'Materi Aktif';
            $itemUrl     = $isTeacher 
                                ? route('teacher.classroom.material.show', [$mat->classroom, $mat]) 
                                : route('student.classroom.material.show', [$mat->classroom, $mat]);

            $events->push([
                'id'          => 'mat_' . $mat->id,
                'raw_id'      => $mat->id,
                'title'       => $mat->title ?? 'Materi Pembelajaran',
                'type'        => 'material',
                'type_label'  => 'Materi Slide / PDF',
                'classroom'   => $mat->classroom->name ?? 'Kelas',
                'classroom_id'=> $mat->classroom_id,
                'date'        => $mat->created_at->format('Y-m-d'),
                'time'        => $mat->created_at->format('H:i'),
                'datetime'    => $mat->created_at,
                'formatted'   => $mat->created_at->translatedFormat('d F Y, H:i'),
                'is_past'     => false,
                'status'      => 'published',
                'status_label'=> $statusLabel,
                'bg_color'    => '#3B82F6', // Blue
                'text_color'  => '#1E40AF',
                'badge_class' => 'bg-primary-subtle text-primary border border-primary',
                'icon'        => 'fa-solid fa-book-open',
                'url'         => $itemUrl,
                'gcal_url'    => $generateGCalUrl($mat->title ?? 'Materi Pembelajaran', 'Materi', $mat->classroom->name ?? 'Kelas', $mat->created_at, $itemUrl, $statusLabel),
                'description' => 'Materi slide pembelajaran untuk dibaca dan dipahami.',
            ]);
        }

        // Urutkan agenda mendatang
        $upcomingEvents = $events->filter(function ($e) {
            return $e['datetime']->greaterThanOrEqualTo(now()->startOfDay());
        })->sortBy('datetime')->values();

        // Kelompokkan event berdasarkan tanggal (Y-m-d) untuk kalender
        $eventsByDate = $events->groupBy('date');

        return view('calendar.index', compact(
            'currentDate',
            'month',
            'year',
            'events',
            'eventsByDate',
            'upcomingEvents',
            'isTeacher'
        ));
    }

    /**
     * Ekspor Seluruh Agenda ke Format Standar iCalendar (.ics) untuk Google Calendar / Apple Calendar / Outlook
     */
    public function exportIcs()
    {
        $user = Auth::user();
        $isTeacher = $user->isTeacher();

        if ($isTeacher) {
            $classroomIds = Classroom::where('teacher_id', $user->id)->where('status', 'active')->pluck('id')->toArray();
        } else {
            $classroomIds = Classroom::whereHas('members', fn($q) => $q->where('user_id', $user->id)->whereNull('out_at'))->where('status', 'active')->pluck('id')->toArray();
        }

        $assignments = ClassroomAssignment::whereHas('post', fn($q) => $q->whereIn('classroom_id', $classroomIds))->whereNotNull('due_date')->with(['post.classroom'])->get();
        $quizzes     = ClassroomQuiz::whereHas('post', fn($q) => $q->whereIn('classroom_id', $classroomIds))->whereNotNull('due_date')->with(['post.classroom'])->get();

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//BasaKula//Javanese Learning Calendar//ID\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";
        $ics .= "X-WR-CALNAME:Jadwal Pembelajaran BasaKula\r\n";
        $ics .= "X-WR-TIMEZONE:Asia/Jakarta\r\n";

        foreach ($assignments as $asn) {
            $dtStart = $asn->due_date->copy()->utc()->format('Ymd\THis\Z');
            $dtEnd   = $asn->due_date->copy()->addHour()->utc()->format('Ymd\THis\Z');
            $title   = preg_replace('/[^\w\s-]/', '', $asn->post->title ?? 'Tugas Pembelajaran');
            $class   = preg_replace('/[^\w\s-]/', '', $asn->post->classroom->name ?? 'Kelas');

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:basakula-asn-{$asn->id}@basakula.ac.id\r\n";
            $ics .= "DTSTAMP:" . now()->utc()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:{$dtStart}\r\n";
            $ics .= "DTEND:{$dtEnd}\r\n";
            $ics .= "SUMMARY:[Tugas] {$title}\r\n";
            $ics .= "DESCRIPTION:Tenggat pengumpulan tugas {$title} di kelas {$class}\r\n";
            $ics .= "LOCATION:{$class}\r\n";
            $ics .= "STATUS:CONFIRMED\r\n";
            $ics .= "BEGIN:VALARM\r\n";
            $ics .= "TRIGGER:-PT2H\r\n"; // Reminder 2 jam sebelum tenggat
            $ics .= "ACTION:DISPLAY\r\n";
            $ics .= "DESCRIPTION:Pengingat Tugas BasaKula\r\n";
            $ics .= "END:VALARM\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        foreach ($quizzes as $quiz) {
            $dtStart = $quiz->due_date->copy()->utc()->format('Ymd\THis\Z');
            $dtEnd   = $quiz->due_date->copy()->addHour()->utc()->format('Ymd\THis\Z');
            $title   = preg_replace('/[^\w\s-]/', '', $quiz->post->title ?? 'Kuis Evaluasi');
            $class   = preg_replace('/[^\w\s-]/', '', $quiz->post->classroom->name ?? 'Kelas');

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:basakula-quiz-{$quiz->id}@basakula.ac.id\r\n";
            $ics .= "DTSTAMP:" . now()->utc()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:{$dtStart}\r\n";
            $ics .= "DTEND:{$dtEnd}\r\n";
            $ics .= "SUMMARY:[Kuis] {$title}\r\n";
            $ics .= "DESCRIPTION:Batas pengerjaan kuis evaluasi {$title} di kelas {$class}\r\n";
            $ics .= "LOCATION:{$class}\r\n";
            $ics .= "STATUS:CONFIRMED\r\n";
            $ics .= "BEGIN:VALARM\r\n";
            $ics .= "TRIGGER:-PT2H\r\n";
            $ics .= "ACTION:DISPLAY\r\n";
            $ics .= "DESCRIPTION:Pengingat Kuis BasaKula\r\n";
            $ics .= "END:VALARM\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";

        return Response::make($ics, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="jadwal_basakula.ics"',
        ]);
    }
}
