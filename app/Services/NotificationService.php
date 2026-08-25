<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomComment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomSubmission;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Dapatkan daftar notifikasi cerdas dan real-time sesuai role pengguna aktif.
     */
    public static function getForUser(?User $user): Collection
    {
        if (!$user) {
            return collect();
        }

        $notifications = collect();

        if ($user->isAdmin()) {
            // ======================== NOTIFIKASI ADMIN ========================
            
            // 1. Pengguna baru terdaftar di sistem
            $newUsers = User::where('id', '!=', $user->id)
                ->with('role')
                ->latest()
                ->take(3)
                ->get();

            foreach ($newUsers as $u) {
                $roleLabel = $u->role->display_name ?? ($u->role->name ?? 'Pengguna');
                $notifications->push([
                    'id'         => 'usr_' . $u->id,
                    'title'      => 'Pengguna Baru Terdaftar',
                    'message'    => "{$u->name} bergabung sebagai {$roleLabel}",
                    'time'       => $u->created_at ? $u->created_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $u->created_at ?? now(),
                    'icon'       => 'fa-solid fa-user-plus text-primary',
                    'icon_bg'    => '#EFF6FF',
                    'url'        => $u->isTeacher() ? route('admin.users.teachers.index') : route('admin.users.students.index'),
                    'badge'      => 'Akun Baru',
                    'badge_class'=> 'bg-primary-subtle text-primary border border-primary',
                ]);
            }

            // 2. Ruang kelas baru yang dibuat
            $newClassrooms = Classroom::with('teacher')->latest()->take(3)->get();
            foreach ($newClassrooms as $c) {
                $teacherName = $c->teacher->name ?? 'Pengajar';
                $notifications->push([
                    'id'         => 'cls_' . $c->id,
                    'title'      => 'Ruang Kelas Baru',
                    'message'    => "Kelas \"{$c->name}\" dibuat oleh {$teacherName}",
                    'time'       => $c->created_at ? $c->created_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $c->created_at ?? now(),
                    'icon'       => 'fa-solid fa-school text-success',
                    'icon_bg'    => '#DCFCE7',
                    'url'        => route('admin.activities.index'),
                    'badge'      => 'Kelas',
                    'badge_class'=> 'bg-success-subtle text-success border border-success',
                ]);
            }

        } elseif ($user->isTeacher()) {
            // ======================== NOTIFIKASI PENGAJAR ========================
            $classrooms = Classroom::where('teacher_id', $user->id)->get();
            $classroomIds = $classrooms->pluck('id')->toArray();

            // 1. Pengumpulan tugas siswa terbaru
            $recentSubmissions = ClassroomSubmission::whereHas('assignment.post', fn($q) => $q->whereIn('classroom_id', $classroomIds))
                ->with(['student', 'assignment.post.classroom'])
                ->latest('submitted_at')
                ->take(4)
                ->get();

            foreach ($recentSubmissions as $sub) {
                $studentName = $sub->student->name ?? 'Siswa';
                $taskTitle   = $sub->assignment->post->title ?? ($sub->assignment->post->body ? Str::limit(strip_tags($sub->assignment->post->body), 25) : 'Tugas');
                $className   = $sub->assignment->post->classroom->name ?? 'Kelas';
                $isGraded    = $sub->status === 'graded';

                $notifications->push([
                    'id'         => 'sub_' . $sub->id,
                    'title'      => $isGraded ? 'Tugas Selesai Dinilai' : 'Pengumpulan Tugas Siswa',
                    'message'    => "{$studentName} mengumpulkan tugas \"{$taskTitle}\" ({$className})",
                    'time'       => $sub->submitted_at ? $sub->submitted_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $sub->submitted_at ?? now(),
                    'icon'       => 'fa-solid fa-file-arrow-up text-danger',
                    'icon_bg'    => '#FEE2E2',
                    'url'        => route('teacher.classroom.show', $sub->assignment->post->classroom_id),
                    'badge'      => $isGraded ? 'Nilai: ' . $sub->score : 'Perlu Dinilai',
                    'badge_class'=> $isGraded ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning-emphasis border border-warning',
                ]);
            }

            // 2. Komentar siswa pada postingan kelas
            $recentComments = ClassroomComment::whereHas('post', fn($q) => $q->whereIn('classroom_id', $classroomIds))
                ->where('user_id', '!=', $user->id)
                ->with(['user', 'post.classroom'])
                ->latest()
                ->take(3)
                ->get();

            foreach ($recentComments as $cm) {
                $commenterName = $cm->user->name ?? 'Siswa';
                $commentSnippet = Str::limit(strip_tags($cm->comment), 28);
                $className = $cm->post->classroom->name ?? 'Kelas';

                $notifications->push([
                    'id'         => 'cm_' . $cm->id,
                    'title'      => 'Komentar Siswa di Kelas',
                    'message'    => "{$commenterName}: \"{$commentSnippet}\" ({$className})",
                    'time'       => $cm->created_at ? $cm->created_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $cm->created_at ?? now(),
                    'icon'       => 'fa-regular fa-comment-dots text-primary',
                    'icon_bg'    => '#EFF6FF',
                    'url'        => route('teacher.classroom.show', $cm->post->classroom_id),
                    'badge'      => 'Komentar',
                    'badge_class'=> 'bg-primary-subtle text-primary border border-primary',
                ]);
            }

            // 3. Siswa baru bergabung di kelas
            $newMembers = ClassroomMember::whereIn('classroom_id', $classroomIds)
                ->where('user_id', '!=', $user->id)
                ->where('role', 'student')
                ->whereNull('out_at')
                ->with(['user', 'classroom'])
                ->latest('joined_at')
                ->take(3)
                ->get();

            foreach ($newMembers as $m) {
                $studentName = $m->user->name ?? 'Siswa';
                $className   = $m->classroom->name ?? 'Kelas';
                $notifications->push([
                    'id'         => 'mbr_' . $m->id,
                    'title'      => 'Siswa Baru Bergabung',
                    'message'    => "{$studentName} telah bergabung ke ruang {$className}",
                    'time'       => $m->joined_at ? $m->joined_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $m->joined_at ?? now(),
                    'icon'       => 'fa-solid fa-user-plus text-success',
                    'icon_bg'    => '#DCFCE7',
                    'url'        => route('teacher.classroom.show', $m->classroom_id),
                    'badge'      => 'Siswa Baru',
                    'badge_class'=> 'bg-success-subtle text-success border border-success',
                ]);
            }

        } else {
            // ======================== NOTIFIKASI SISWA / PELAJAR ========================
            $joinedClassroomIds = Classroom::whereHas('members', fn($q) => $q->where('user_id', $user->id)->whereNull('out_at'))
                ->pluck('id')
                ->toArray();

            // 1. Tugas baru dari guru
            $activeAssignments = ClassroomAssignment::whereHas('post', fn($q) => $q->whereIn('classroom_id', $joinedClassroomIds))
                ->with(['post.classroom', 'post.author', 'submissions' => fn($q) => $q->where('student_id', $user->id)])
                ->latest('id')
                ->take(4)
                ->get();

            foreach ($activeAssignments as $asn) {
                $hasSubmitted = $asn->submissions->isNotEmpty();
                $taskTitle = $asn->post->title ?? ($asn->post->body ? Str::limit(strip_tags($asn->post->body), 25) : 'Tugas');
                $className = $asn->post->classroom->name ?? 'Kelas';
                $dueDateStr = $asn->due_date ? 'Tenggat: ' . $asn->due_date->translatedFormat('d M, H:i') : 'Tanpa tenggat';

                if (!$hasSubmitted) {
                    $notifications->push([
                        'id'         => 'asn_' . $asn->id,
                        'title'      => 'Tugas Baru Diberikan',
                        'message'    => "\"{$taskTitle}\" di {$className} ({$dueDateStr})",
                        'time'       => $asn->created_at ? $asn->created_at->diffForHumans() : 'Baru saja',
                        'datetime'   => $asn->created_at ?? now(),
                        'icon'       => 'fa-solid fa-clipboard-list text-danger',
                        'icon_bg'    => '#FEE2E2',
                        'url'        => route('student.classroom.submission.show', $asn),
                        'badge'      => 'Wajib Dikerjakan',
                        'badge_class'=> 'bg-danger-subtle text-danger border border-danger',
                    ]);
                }
            }

            // 2. Nilai tugas yang telah dinilai guru
            $gradedSubmissions = ClassroomSubmission::where('student_id', $user->id)
                ->where('status', 'graded')
                ->with(['assignment.post.classroom'])
                ->latest('id')
                ->take(3)
                ->get();

            foreach ($gradedSubmissions as $sub) {
                $taskTitle = $sub->assignment->post->title ?? ($sub->assignment->post->body ? Str::limit(strip_tags($sub->assignment->post->body), 25) : 'Tugas');
                $notifications->push([
                    'id'         => 'grd_' . $sub->id,
                    'title'      => 'Nilai Tugas Telah Keluar',
                    'message'    => "Kamu mendapat nilai {$sub->score}/{$sub->assignment->max_score} pada tugas \"{$taskTitle}\"",
                    'time'       => $sub->submitted_at ? $sub->submitted_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $sub->submitted_at ?? now(),
                    'icon'       => 'fa-solid fa-award text-success',
                    'icon_bg'    => '#DCFCE7',
                    'url'        => route('student.classroom.submission.show', $sub->assignment_id),
                    'badge'      => 'Skor: ' . $sub->score,
                    'badge_class'=> 'bg-success-subtle text-success border border-success',
                ]);
            }

            // 3. Materi baru yang dipublikasikan guru
            $recentMaterials = ClassroomPost::where('type', 'material')
                ->whereIn('classroom_id', $joinedClassroomIds)
                ->with(['classroom', 'author'])
                ->latest()
                ->take(3)
                ->get();

            foreach ($recentMaterials as $mat) {
                $matTitle = $mat->title ?? ($mat->body ? Str::limit(strip_tags($mat->body), 25) : 'Materi Pembelajaran');
                $className = $mat->classroom->name ?? 'Kelas';

                $notifications->push([
                    'id'         => 'mat_' . $mat->id,
                    'title'      => 'Materi Pembelajaran Baru',
                    'message'    => "\"{$matTitle}\" telah dipublikasikan di ruang {$className}",
                    'time'       => $mat->created_at ? $mat->created_at->diffForHumans() : 'Baru saja',
                    'datetime'   => $mat->created_at ?? now(),
                    'icon'       => 'fa-solid fa-book-open text-primary',
                    'icon_bg'    => '#EFF6FF',
                    'url'        => route('student.classroom.show', $mat->classroom_id),
                    'badge'      => 'Materi',
                    'badge_class'=> 'bg-primary-subtle text-primary border border-primary',
                ]);
            }
        }

        return $notifications->sortByDesc('datetime')->values();
    }
}
