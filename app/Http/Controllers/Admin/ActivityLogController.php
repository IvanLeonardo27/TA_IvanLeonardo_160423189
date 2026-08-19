<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomComment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomSubmission;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan Halaman Monitoring Log Aktivitas Interaksi Pembelajaran
     */
    public function index(Request $request)
    {
        Gate::authorize('admin');

        $roleFilter   = $request->query('role', 'all');   // all, teacher, student
        $actionFilter = $request->query('action', 'all'); // all, classroom, post, submission, quiz, comment
        $search       = trim($request->query('search', ''));

        $logs = collect();

        // 1. Aktivitas Pengajar: Membuat Ruang Kelas
        if ($roleFilter === 'all' || $roleFilter === 'teacher') {
            if ($actionFilter === 'all' || $actionFilter === 'classroom') {
                $classrooms = Classroom::with('teacher')->latest()->take(50)->get();
                foreach ($classrooms as $c) {
                    if (!$c->teacher) continue;
                    $logs->push([
                        'id'          => 'cls_' . $c->id,
                        'timestamp'   => $c->created_at,
                        'role'        => 'teacher',
                        'role_label'  => 'Pengajar',
                        'actor_name'  => $c->teacher->name,
                        'actor_code'  => $c->teacher->user_code ?? '-',
                        'actor_email' => $c->teacher->email,
                        'action'      => 'Membuat Ruang Kelas',
                        'action_type' => 'classroom',
                        'badge_color' => 'bg-success',
                        'icon'        => 'fa-solid fa-chalkboard-user',
                        'description' => "Membuat kelas baru '{$c->name}' dengan kode akses {$c->code}.",
                        'target'      => $c->name,
                    ]);
                }
            }
        }

        // 2. Aktivitas Pengajar: Membuat Postingan / Materi / Tugas / Kuis
        if ($roleFilter === 'all' || $roleFilter === 'teacher') {
            if ($actionFilter === 'all' || $actionFilter === 'post') {
                $posts = ClassroomPost::with(['author', 'classroom'])->latest()->take(60)->get();
                foreach ($posts as $p) {
                    if (!$p->author) continue;
                    $typeLabel = ucfirst($p->type);
                    $logs->push([
                        'id'          => 'pst_' . $p->id,
                        'timestamp'   => $p->created_at,
                        'role'        => 'teacher',
                        'role_label'  => 'Pengajar',
                        'actor_name'  => $p->author->name,
                        'actor_code'  => $p->author->user_code ?? '-',
                        'actor_email' => $p->author->email,
                        'action'      => "Mempublikasikan {$typeLabel}",
                        'action_type' => 'post',
                        'badge_color' => 'bg-primary',
                        'icon'        => 'fa-solid fa-bullhorn',
                        'description' => "Menambahkan {$p->type} berjudul '{$p->title}' di kelas " . ($p->classroom->name ?? 'Kelas') . ".",
                        'target'      => $p->classroom->name ?? 'Kelas',
                    ]);
                }
            }
        }

        // 3. Aktivitas Siswa: Bergabung ke Ruang Kelas
        if ($roleFilter === 'all' || $roleFilter === 'student') {
            if ($actionFilter === 'all' || $actionFilter === 'classroom') {
                $members = ClassroomMember::with(['user', 'classroom'])
                    ->where('role', 'student')
                    ->latest('joined_at')
                    ->take(50)
                    ->get();

                foreach ($members as $m) {
                    if (!$m->user || !$m->classroom) continue;
                    $logs->push([
                        'id'          => 'join_' . $m->id,
                        'timestamp'   => $m->joined_at ?? $m->created_at,
                        'role'        => 'student',
                        'role_label'  => 'Pelajar',
                        'actor_name'  => $m->user->name,
                        'actor_code'  => $m->user->user_code ?? '-',
                        'actor_email' => $m->user->email,
                        'action'      => 'Bergabung ke Kelas',
                        'action_type' => 'classroom',
                        'badge_color' => 'bg-info text-dark',
                        'icon'        => 'fa-solid fa-door-open',
                        'description' => "Bergabung ke ruang kelas '{$m->classroom->name}'.",
                        'target'      => $m->classroom->name,
                    ]);
                }
            }
        }

        // 4. Aktivitas Siswa & Guru: Pengumpulan & Penilaian Tugas
        if ($actionFilter === 'all' || $actionFilter === 'submission') {
            $submissions = ClassroomSubmission::with(['student', 'assignment.post.classroom'])->latest('submitted_at')->take(50)->get();
            foreach ($submissions as $sub) {
                if ($sub->student && ($roleFilter === 'all' || $roleFilter === 'student')) {
                    $logs->push([
                        'id'          => 'sub_' . $sub->id,
                        'timestamp'   => $sub->submitted_at ?? $sub->created_at,
                        'role'        => 'student',
                        'role_label'  => 'Pelajar',
                        'actor_name'  => $sub->student->name,
                        'actor_code'  => $sub->student->user_code ?? '-',
                        'actor_email' => $sub->student->email,
                        'action'      => 'Mengumpulkan Tugas',
                        'action_type' => 'submission',
                        'badge_color' => 'bg-warning text-dark',
                        'icon'        => 'fa-solid fa-file-arrow-up',
                        'description' => "Menyerahkan berkas tugas '" . ($sub->assignment->post->title ?? 'Tugas') . "' di kelas " . ($sub->assignment->post->classroom->name ?? 'Kelas') . ".",
                        'target'      => $sub->assignment->post->classroom->name ?? 'Kelas',
                    ]);
                }

                // Log penilaian jika sudah dinilai guru
                if ($sub->status === 'graded' && ($roleFilter === 'all' || $roleFilter === 'teacher')) {
                    $teacher = $sub->assignment->post->classroom->teacher ?? null;
                    if ($teacher) {
                        $logs->push([
                            'id'          => 'grd_' . $sub->id,
                            'timestamp'   => $sub->updated_at,
                            'role'        => 'teacher',
                            'role_label'  => 'Pengajar',
                            'actor_name'  => $teacher->name,
                            'actor_code'  => $teacher->user_code ?? '-',
                            'actor_email' => $teacher->email,
                            'action'      => 'Menilai Tugas Siswa',
                            'action_type' => 'submission',
                            'badge_color' => 'bg-success',
                            'icon'        => 'fa-solid fa-check-double',
                            'description' => "Memberikan nilai {$sub->score} kepada siswa " . ($sub->student->name ?? 'Siswa') . " untuk tugas '" . ($sub->assignment->post->title ?? 'Tugas') . "'.",
                            'target'      => $sub->student->name ?? 'Siswa',
                        ]);
                    }
                }
            }
        }

        // 5. Aktivitas Siswa: Mengerjakan Kuis & Evaluasi
        if ($roleFilter === 'all' || $roleFilter === 'student') {
            if ($actionFilter === 'all' || $actionFilter === 'quiz') {
                $attempts = QuizAttempt::with(['user', 'quizSet'])->latest('taken_at')->take(50)->get();
                foreach ($attempts as $att) {
                    $actorName = $att->user ? $att->user->name : $att->player_name;
                    $actorCode = $att->user ? ($att->user->user_code ?? '-') : '-';
                    $actorEmail = $att->user ? $att->user->email : '-';

                    $logs->push([
                        'id'          => 'att_' . $att->id,
                        'timestamp'   => $att->taken_at ?? $att->created_at,
                        'role'        => 'student',
                        'role_label'  => 'Pelajar',
                        'actor_name'  => $actorName,
                        'actor_code'  => $actorCode,
                        'actor_email' => $actorEmail,
                        'action'      => 'Menyelesaikan Kuis',
                        'action_type' => 'quiz',
                        'badge_color' => 'bg-purple-subtle text-purple border',
                        'icon'        => 'fa-solid fa-medal',
                        'description' => "Menyelesaikan kuis '" . ($att->quizSet->title ?? 'Evaluasi Pembelajaran') . "' dengan skor {$att->score} (" . $att->time_spent_formatted . ").",
                        'target'      => $att->quizSet->title ?? 'Kuis',
                    ]);
                }
            }
        }

        // 6. Aktivitas Siswa & Guru: Komentar Diskusi
        if ($actionFilter === 'all' || $actionFilter === 'comment') {
            $comments = ClassroomComment::with(['user.role', 'post.classroom'])->latest()->take(50)->get();
            foreach ($comments as $cm) {
                if (!$cm->user) continue;
                $isTeach = $cm->user->isTeacher();
                $cRole = $isTeach ? 'teacher' : 'student';

                if ($roleFilter !== 'all' && $roleFilter !== $cRole) continue;

                $logs->push([
                    'id'          => 'cm_' . $cm->id,
                    'timestamp'   => $cm->created_at,
                    'role'        => $cRole,
                    'role_label'  => $isTeach ? 'Pengajar' : 'Pelajar',
                    'actor_name'  => $cm->user->name,
                    'actor_code'  => $cm->user->user_code ?? '-',
                    'actor_email' => $cm->user->email,
                    'action'      => 'Menulis Komentar',
                    'action_type' => 'comment',
                    'badge_color' => 'bg-secondary',
                    'icon'        => 'fa-regular fa-comment-dots',
                    'description' => "Menulis komentar pada postingan '" . ($cm->post->title ?? 'Materi') . "': \"" . \Illuminate\Support\Str::limit($cm->comment, 60) . "\"",
                    'target'      => $cm->post->classroom->name ?? 'Kelas',
                ]);
            }
        }

        // Filter search jika ada
        if (!empty($search)) {
            $logs = $logs->filter(function ($item) use ($search) {
                return stripos($item['actor_name'], $search) !== false
                    || stripos($item['actor_code'], $search) !== false
                    || stripos($item['actor_email'], $search) !== false
                    || stripos($item['description'], $search) !== false;
            });
        }

        // Urutkan berdasarkan waktu terkini
        $sortedLogs = $logs->sortByDesc(function ($item) {
            return $item['timestamp'] ? Carbon::parse($item['timestamp'])->timestamp : 0;
        })->values();

        // Paginate collection (15 item per halaman)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentPageItems = $sortedLogs->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedLogs = new LengthAwarePaginator(
            $currentPageItems,
            $sortedLogs->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $stats = [
            'total_activities'   => $sortedLogs->count(),
            'teacher_activities' => $sortedLogs->where('role', 'teacher')->count(),
            'student_activities' => $sortedLogs->where('role', 'student')->count(),
        ];

        return view('admin.activities.index', compact('paginatedLogs', 'stats', 'roleFilter', 'actionFilter', 'search'));
    }
}
