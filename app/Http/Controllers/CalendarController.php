<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomQuiz;
use App\Models\QuizAttempt;
use App\Models\UserCalendarEvent;
use App\Services\IndonesianHolidayService;
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
        $isAdmin   = $user->isAdmin();
        $isTeacher = $user->isTeacher();

        // Tentukan Bulan & Tahun Kalender (default bulan ini)
        $month = $request->integer('month', now()->month);
        $year  = $request->integer('year', now()->year);

        if ($month < 1 || $month > 12) {
            $month = now()->month;
        }
        if ($year < 1900 || $year > 2100) {
            $year = now()->year;
        }

        $currentDate = Carbon::createFromDate($year, $month, 1);
        $holidays    = IndonesianHolidayService::getHolidaysForMonth($year, $month);

        // Khusus Administrator: Kalender murni penanggalan sistem tanpa pencatatan tugas / materi
        if ($isAdmin) {
            $startOfMonth   = $currentDate->copy()->startOfMonth();
            $endOfMonth     = $currentDate->copy()->endOfMonth();
            $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Senin) .. 7 (Minggu)
            $daysInMonth    = $currentDate->daysInMonth;
            $monthName      = $currentDate->translatedFormat('F Y');

            return view('admin.calendar.index', compact(
                'currentDate',
                'month',
                'year',
                'startDayOfWeek',
                'daysInMonth',
                'monthName',
                'holidays'
            ));
        }

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

        // 4. Format Events: Jadwal Acara Pribadi Pengguna (User Calendar Events)
        // PRIVASI TINGGI: Hanya dapat dilihat oleh pemilik akun masing-masing (Guru maupun Pelajar tidak saling melihat)
        $personalEvents = UserCalendarEvent::where('user_id', $user->id)
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->get();

        foreach ($personalEvents as $pe) {
            $dt = $pe->event_date->copy();
            if ($pe->event_time) {
                $timeParts = explode(':', $pe->event_time);
                $dt->setTime((int)$timeParts[0], (int)($timeParts[1] ?? 0));
            } else {
                $dt->setTime(8, 0);
            }

            $events->push([
                'id'          => 'pe_' . $pe->id,
                'raw_id'      => $pe->id,
                'title'       => $pe->title,
                'type'        => 'personal',
                'type_label'  => 'Jadwal Acara Pribadi',
                'classroom'   => 'Agenda Pribadi',
                'classroom_id'=> null,
                'date'        => $pe->event_date->format('Y-m-d'),
                'time'        => $pe->event_time ? Carbon::parse($pe->event_time)->format('H:i') : 'Sepanjang Hari',
                'datetime'    => $dt,
                'formatted'   => $pe->event_date->translatedFormat('d F Y') . ($pe->event_time ? ', ' . Carbon::parse($pe->event_time)->format('H:i') . ' WIB' : ''),
                'is_past'     => $dt->isPast(),
                'status'      => 'personal',
                'status_label'=> 'Acara Pribadi',
                'bg_color'    => $pe->color ?: '#10B981', // Default Emerald green
                'text_color'  => '#065F46',
                'badge_class' => 'text-white',
                'icon'        => 'fa-solid fa-calendar-check',
                'url'         => '#',
                'gcal_url'    => $generateGCalUrl($pe->title, 'Jadwal Pribadi', 'Agenda Pribadi', $dt, route('calendar.index'), 'Jadwal Acara Pribadi'),
                'description' => $pe->description ?: 'Tidak ada keterangan tambahan.',
                'is_personal' => true,
                'personal_model' => $pe,
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
            'personalEvents',
            'isTeacher',
            'holidays'
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

        // Tambahkan Jadwal Acara Pribadi Pengguna ke Export ICS
        $personalEvents = UserCalendarEvent::where('user_id', $user->id)->get();
        foreach ($personalEvents as $pe) {
            $dt = $pe->event_date->copy();
            if ($pe->event_time) {
                $timeParts = explode(':', $pe->event_time);
                $dt->setTime((int)$timeParts[0], (int)($timeParts[1] ?? 0));
            } else {
                $dt->setTime(8, 0);
            }
            $dtStart = $dt->copy()->utc()->format('Ymd\THis\Z');
            $dtEnd   = $dt->copy()->addHour()->utc()->format('Ymd\THis\Z');
            $title   = preg_replace('/[^\w\s-]/', '', $pe->title);

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:basakula-pe-{$pe->id}-{$user->id}@basakula.ac.id\r\n";
            $ics .= "DTSTAMP:" . now()->utc()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:{$dtStart}\r\n";
            $ics .= "DTEND:{$dtEnd}\r\n";
            $ics .= "SUMMARY:[Jadwal Pribadi] {$title}\r\n";
            $ics .= "DESCRIPTION:" . preg_replace('/[^\w\s-]/', '', $pe->description ?: 'Agenda Pribadi') . "\r\n";
            $ics .= "LOCATION:Agenda Pribadi\r\n";
            $ics .= "STATUS:CONFIRMED\r\n";
            $ics .= "BEGIN:VALARM\r\n";
            $ics .= "TRIGGER:-PT1H\r\n";
            $ics .= "ACTION:DISPLAY\r\n";
            $ics .= "DESCRIPTION:Pengingat Jadwal Pribadi BasaKula\r\n";
            $ics .= "END:VALARM\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";

        return Response::make($ics, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="jadwal_basakula.ics"',
        ]);
    }

    /**
     * Simpan Jadwal Acara Pribadi Baru
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'event_time'  => 'nullable|string',
            'description' => 'nullable|string|max:1000',
            'color'       => 'nullable|string|max:20',
        ]);

        $event = UserCalendarEvent::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'event_date'  => $request->event_date,
            'event_time'  => $request->event_time ?: null,
            'description' => $request->description,
            'color'       => $request->color ?: '#10B981',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal acara pribadi berhasil ditambahkan!',
                'event'   => $event,
            ]);
        }

        return redirect()->route('calendar.index', [
            'month' => Carbon::parse($request->event_date)->month,
            'year'  => Carbon::parse($request->event_date)->year,
        ])->with('success', 'Jadwal acara pribadi berhasil ditambahkan!');
    }

    /**
     * Perbarui Jadwal Acara Pribadi Milik Pengguna Sendiri
     */
    public function updateEvent(Request $request, $id)
    {
        $event = UserCalendarEvent::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'event_time'  => 'nullable|string',
            'description' => 'nullable|string|max:1000',
            'color'       => 'nullable|string|max:20',
        ]);

        $event->update([
            'title'       => $request->title,
            'event_date'  => $request->event_date,
            'event_time'  => $request->event_time ?: null,
            'description' => $request->description,
            'color'       => $request->color ?: '#10B981',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal acara pribadi berhasil diperbarui!',
                'event'   => $event,
            ]);
        }

        return redirect()->route('calendar.index', [
            'month' => Carbon::parse($request->event_date)->month,
            'year'  => Carbon::parse($request->event_date)->year,
        ])->with('success', 'Jadwal acara pribadi berhasil diperbarui!');
    }

    /**
     * Hapus Jadwal Acara Pribadi Milik Pengguna Sendiri
     */
    public function destroyEvent(Request $request, $id)
    {
        $event = UserCalendarEvent::where('user_id', Auth::id())->findOrFail($id);
        $event->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal acara pribadi berhasil dihapus!',
            ]);
        }

        return redirect()->back()->with('success', 'Jadwal acara pribadi berhasil dihapus!');
    }
}
