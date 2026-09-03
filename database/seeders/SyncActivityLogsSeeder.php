<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Classroom;
use App\Models\ClassroomComment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomSubmission;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Database\Seeder;

class SyncActivityLogsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Catat Riwayat Login dari Users
        $users = User::all();
        foreach ($users as $user) {
            $role = $user->isAdmin() ? 'admin' : ($user->isTeacher() ? 'teacher' : 'student');
            $loginTime = $user->last_login ?? $user->updated_at ?? $user->created_at;

            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $user->id,
                    'action_type' => 'login',
                    'created_at'  => $loginTime,
                ],
                [
                    'name'        => $user->name,
                    'code'        => $user->user_code ?? '-',
                    'email'       => $user->email,
                    'role'        => $role,
                    'action'      => 'Masuk ke Sistem (Login)',
                    'description' => "Berhasil masuk ke dalam sistem BasaKula LMS sebagai " . ucfirst($role) . ".",
                    'target'      => 'Portal BasaKula',
                    'ip_address'  => '127.0.0.1',
                    'updated_at'  => $loginTime,
                ]
            );
        }

        // 2. Ruang Kelas yang Dibuat
        $classrooms = Classroom::with('teacher')->get();
        foreach ($classrooms as $c) {
            if (!$c->teacher) continue;
            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $c->teacher_id,
                    'action_type' => 'classroom',
                    'description' => "Membuat kelas baru '{$c->name}' dengan kode akses {$c->code}.",
                ],
                [
                    'name'        => $c->teacher->name,
                    'code'        => $c->teacher->user_code ?? '-',
                    'email'       => $c->teacher->email,
                    'role'        => 'teacher',
                    'action'      => 'Membuat Ruang Kelas',
                    'target'      => $c->name,
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $c->created_at,
                    'updated_at'  => $c->updated_at,
                ]
            );
        }

        // 3. Postingan Materi, Tugas, Kuis di Kelas
        $posts = ClassroomPost::with(['author', 'classroom'])->get();
        foreach ($posts as $p) {
            if (!$p->author) continue;
            $typeLabel = match($p->type) {
                'material'   => 'Materi Pembelajaran',
                'assignment' => 'Tugas Kelas',
                'quiz'       => 'Evaluasi / Kuis',
                default      => ucfirst($p->type),
            };

            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $p->author_id,
                    'action_type' => 'post',
                    'description' => "Mempublikasikan {$typeLabel} berjudul '{$p->title}' di kelas " . ($p->classroom->name ?? 'Kelas') . ".",
                ],
                [
                    'name'        => $p->author->name,
                    'code'        => $p->author->user_code ?? '-',
                    'email'       => $p->author->email,
                    'role'        => 'teacher',
                    'action'      => "Mempublikasikan {$typeLabel}",
                    'target'      => $p->classroom->name ?? 'Kelas',
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            );
        }

        // 4. Siswa Bergabung ke Kelas
        $members = ClassroomMember::with(['user', 'classroom'])->where('role', 'student')->get();
        foreach ($members as $m) {
            if (!$m->user || !$m->classroom) continue;
            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $m->user_id,
                    'action_type' => 'classroom',
                    'description' => "Bergabung ke ruang kelas '{$m->classroom->name}'.",
                ],
                [
                    'name'        => $m->user->name,
                    'code'        => $m->user->user_code ?? '-',
                    'email'       => $m->user->email,
                    'role'        => 'student',
                    'action'      => 'Bergabung ke Kelas',
                    'target'      => $m->classroom->name,
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $m->joined_at ?? $m->created_at,
                    'updated_at'  => $m->joined_at ?? $m->created_at,
                ]
            );
        }

        // 5. Siswa Mengumpulkan Tugas
        $submissions = ClassroomSubmission::with(['student', 'assignment.post.classroom'])->get();
        foreach ($submissions as $sub) {
            if (!$sub->student) continue;
            $taskTitle = $sub->assignment->post->title ?? 'Tugas';
            $className = $sub->assignment->post->classroom->name ?? 'Kelas';

            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $sub->student_id,
                    'action_type' => 'submission',
                    'description' => "Mengumpulkan tugas '{$taskTitle}' di kelas {$className}.",
                ],
                [
                    'name'        => $sub->student->name,
                    'code'        => $sub->student->user_code ?? '-',
                    'email'       => $sub->student->email,
                    'role'        => 'student',
                    'action'      => 'Mengumpulkan Tugas',
                    'target'      => $taskTitle,
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $sub->submitted_at ?? $sub->created_at,
                    'updated_at'  => $sub->submitted_at ?? $sub->created_at,
                ]
            );

            // Jika tugas sudah dinilai oleh pengajar
            if (!is_null($sub->score) && $sub->graded_at) {
                $teacher = $sub->assignment->post->classroom->teacher ?? null;
                if ($teacher) {
                    ActivityLog::firstOrCreate(
                        [
                            'user_id'     => $teacher->id,
                            'action_type' => 'grade',
                            'description' => "Memberikan nilai {$sub->score} kepada siswa {$sub->student->name} untuk tugas '{$taskTitle}'.",
                        ],
                        [
                            'name'        => $teacher->name,
                            'code'        => $teacher->user_code ?? '-',
                            'email'       => $teacher->email,
                            'role'        => 'teacher',
                            'action'      => 'Menilai Tugas Siswa',
                            'target'      => $sub->student->name,
                            'ip_address'  => '127.0.0.1',
                            'created_at'  => $sub->graded_at,
                            'updated_at'  => $sub->graded_at,
                        ]
                    );
                }
            }
        }

        // 6. Siswa Mengerjakan Kuis & Evaluasi
        $attempts = QuizAttempt::with(['user', 'quizSet'])->get();
        foreach ($attempts as $att) {
            $actorName = $att->user ? $att->user->name : $att->player_name;
            $actorCode = $att->user ? ($att->user->user_code ?? '-') : '-';
            $actorEmail = $att->user ? $att->user->email : '-';
            $quizTitle = $att->quizSet->title ?? 'Evaluasi Pembelajaran';

            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $att->user_id,
                    'action_type' => 'quiz',
                    'description' => "Menyelesaikan kuis '{$quizTitle}' dengan perolehan skor {$att->score}.",
                ],
                [
                    'name'        => $actorName,
                    'code'        => $actorCode,
                    'email'       => $actorEmail,
                    'role'        => 'student',
                    'action'      => 'Menyelesaikan Kuis',
                    'target'      => $quizTitle,
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $att->taken_at ?? $att->created_at,
                    'updated_at'  => $att->taken_at ?? $att->created_at,
                ]
            );
        }

        // 7. Komentar Diskusi di Kelas
        $comments = ClassroomComment::with(['user', 'post.classroom'])->get();
        foreach ($comments as $cm) {
            if (!$cm->user) continue;
            $isTeach = $cm->user->isTeacher();
            $role = $isTeach ? 'teacher' : 'student';

            ActivityLog::firstOrCreate(
                [
                    'user_id'     => $cm->user_id,
                    'action_type' => 'comment',
                    'description' => "Menulis komentar pada postingan '" . ($cm->post->title ?? 'Materi') . "': \"" . \Illuminate\Support\Str::limit($cm->comment, 60) . "\"",
                ],
                [
                    'name'        => $cm->user->name,
                    'code'        => $cm->user->user_code ?? '-',
                    'email'       => $cm->user->email,
                    'role'        => $role,
                    'action'      => 'Menulis Komentar',
                    'target'      => $cm->post->classroom->name ?? 'Kelas',
                    'ip_address'  => '127.0.0.1',
                    'created_at'  => $cm->created_at,
                    'updated_at'  => $cm->updated_at,
                ]
            );
        }
    }
}
