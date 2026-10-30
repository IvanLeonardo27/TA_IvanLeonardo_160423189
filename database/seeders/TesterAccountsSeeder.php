<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomPostAttachment;
use App\Models\ClassroomQuiz;
use App\Models\QuizQuestion;
use App\Models\QuizSet;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TesterAccountsSeeder extends Seeder
{
    /**
     * Seed 5 Demo Teacher Accounts, 25 Demo Student Accounts,
     * 5 Classrooms (1 Teacher + 5 Students each),
     * PDF Material (from existing uploaded PDF in DB),
     * and Next-Month Exam (from existing Question Bank).
     */
    public function run(): void
    {
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();

        $teacherRoleId = $teacherRole ? $teacherRole->id : 2;
        $studentRoleId = $studentRole ? $studentRole->id : 3;

        // Password disamakan dengan seluruh akun lain di database
        $defaultPassword = Hash::make('password123');

        // Ambil referensi materi PDF yang sudah pernah diupload ke database (Post ID 9 / Attachment PDF)
        $existingAttachment = ClassroomPostAttachment::where('mime_type', 'application/pdf')
            ->where('original_name', 'like', '%Pengenalan Dasar Bahasa Jawa%')
            ->first()
            ?? ClassroomPostAttachment::where('mime_type', 'application/pdf')->latest('id')->first();

        $pdfOriginalName = $existingAttachment ? $existingAttachment->original_name : 'Minggu 1 - Pengenalan Dasar Bahasa Jawa.pdf';
        $pdfFilePath     = $existingAttachment ? $existingAttachment->file_path : 'classrooms/23/posts/9/BYzXTwtRZl1yHvRFF4dfrWecxiYXoHBlah9DPuBw.pdf';
        $pdfFileSize     = $existingAttachment ? $existingAttachment->file_size : 480572;
        $pdfMimeType     = 'application/pdf';

        $existingMaterialPost = ClassroomPost::where('type', 'material')
            ->where('title', 'like', '%Pengenalan Bahasa Jawa%')
            ->first();

        $materialTitle = $existingMaterialPost ? $existingMaterialPost->title : 'Materi 1 - Pengenalan Bahasa Jawa';
        $materialBody  = $existingMaterialPost && $existingMaterialPost->body
            ? $existingMaterialPost->body
            : json_encode([
                'total_slides'  => 45,
                'plain_summary' => 'Pelajari materi ini baik baik, karena materi ini akan menjadi pondasi untuk Bahasa Jawa kalian',
                'is_ppt'        => true,
                'checkpoint'    => [
                    'question'         => 'Apa itu Bahasa Jawa',
                    'options'          => [
                        'Bahasa daerah tradisional yang sering digunakan oleh masyarakat untuk berkomunikasi',
                        'Bahasa yang tinggal di Pulau Jawa',
                        'Bahasa yang mempelajari perhitungan',
                        'Bahasa yang tidak perlu dipelajari',
                    ],
                    'correct_index'    => 0,
                    'checkpoint_slide' => 17,
                ],
            ]);

        // Daftar 5 soal dari Bank Soal yang sudah ada di database
        $bankQuestionsTemplate = [
            [
                'question'           => '1. Anake asu diarani apa?',
                'category'           => 'umum',
                'options'            => ['Meri', 'Kirik', 'Gudel', 'Piyik'],
                'option_percentages' => [0, 100, 0, 0],
                'correct_index'      => 1,
                'explanation'        => 'Asu berarti anjing, sedangkan kirik berarti anak anjing.',
            ],
            [
                'question'           => 'Apa sebutan kanggo anake kebo?',
                'category'           => 'umum',
                'options'            => ['Belo', 'Pricil', 'Gudel', 'Cemeng'],
                'option_percentages' => [0, 0, 100, 0],
                'correct_index'      => 2,
                'explanation'        => 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.',
            ],
            [
                'question'           => 'Anak pitik (ayam) disebut apa?',
                'category'           => 'umum',
                'options'            => ['Kuthuk', 'Genjik', 'Kirik', 'Meri'],
                'option_percentages' => [100, 0, 0, 0],
                'correct_index'      => 0,
                'explanation'        => 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.',
            ],
            [
                'question'           => 'Apa sebutan untuk anak jaran (kuda)?',
                'category'           => 'umum',
                'options'            => ['Piyik', 'Belo', 'Nener', 'Precil'],
                'option_percentages' => [0, 100, 0, 0],
                'correct_index'      => 1,
                'explanation'        => 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.',
            ],
            [
                'question'           => 'Anak kodhok (katak) disebut apa?',
                'category'           => 'umum',
                'options'            => ['Meri', 'Gudel', 'Precil', 'Kuthuk'],
                'option_percentages' => [0, 0, 100, 0],
                'correct_index'      => 2,
                'explanation'        => 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.',
            ],
        ];

        // Ambil 5 soal Bank Soal eksisting (ID 6..10) jika sudah ada di database
        $existingBankQuestionIds = QuizQuestion::whereIn('id', [6, 7, 8, 9, 10])->pluck('id')->toArray();

        // Tenggat ujian: Bulan depan (akhir bulan depan pukul 23:59)
        $nextMonthDueDate = now()->addMonth()->endOfMonth()->setTime(23, 59, 0);

        // =========================================================================
        // 1. BUAT 5 AKUN DEMO PENGAJAR
        // =========================================================================
        $teachers = [];
        for ($i = 1; $i <= 5; $i++) {
            $teacher = User::withTrashed()->updateOrCreate(
                ['email' => "pengajar{$i}@basakula.com"],
                [
                    'name'       => "Pengajar Demo {$i}",
                    'role_id'    => $teacherRoleId,
                    'user_code'  => sprintf('TCH-DEMO-%02d', $i),
                    'status'     => 'active',
                    'password'   => $defaultPassword,
                    'deleted_at' => null,
                ]
            );

            TeacherProfile::updateOrCreate(
                ['user_id' => $teacher->id],
                [
                    'nip'          => sprintf('1985010%d201501100%d', $i, $i),
                    'phone_number' => sprintf('08123000000%d', $i),
                ]
            );

            // Salin 5 soal ke Bank Soal milik masing-masing Pengajar Demo
            // agar saat pengajar membuka menu Bank Soal, soal sudah tersedia
            foreach ($bankQuestionsTemplate as $qTpl) {
                QuizQuestion::updateOrCreate(
                    [
                        'teacher_id' => $teacher->id,
                        'question'   => $qTpl['question'],
                    ],
                    [
                        'question_text'      => $qTpl['question'],
                        'category'           => $qTpl['category'],
                        'options'            => $qTpl['options'],
                        'option_percentages' => $qTpl['option_percentages'],
                        'correct_index'      => $qTpl['correct_index'],
                        'correct_answer'     => (string) $qTpl['correct_index'],
                        'points'             => 20,
                        'is_active'          => true,
                        'explanation'        => $qTpl['explanation'],
                    ]
                );
            }

            $teachers[$i] = $teacher;
        }

        // =========================================================================
        // 2. BUAT 25 AKUN DEMO PELAJAR
        // =========================================================================
        $students = [];
        for ($s = 1; $s <= 25; $s++) {
            $student = User::withTrashed()->updateOrCreate(
                ['email' => "pelajar{$s}@basakula.com"],
                [
                    'name'       => "Pelajar Demo {$s}",
                    'role_id'    => $studentRoleId,
                    'user_code'  => sprintf('STD-DEMO-%02d', $s),
                    'status'     => 'active',
                    'password'   => $defaultPassword,
                    'deleted_at' => null,
                ]
            );

            StudentProfile::updateOrCreate(
                ['user_id' => $student->id],
                [
                    'nisn'         => sprintf('0095000%03d', $s),
                    'grade_level'  => 'Kelas 10',
                    'phone_number' => sprintf('081350000%03d', $s),
                ]
            );

            $students[$s] = $student;
        }

        // =========================================================================
        // 3. BUAT 5 KELAS (1 PENGAJAR + 5 PELAJAR PER KELAS)
        //    BESERTA MATERI PDF & UJIAN TENGGAT BULAN DEPAN
        // =========================================================================
        $classLetters = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];
        $bannerColors = [1 => '#16402E', 2 => '#1E3A8A', 3 => '#7C2D12', 4 => '#581C87', 5 => '#0F766E'];

        for ($c = 1; $c <= 5; $c++) {
            $letter  = $classLetters[$c];
            $teacher = $teachers[$c];
            $code    = sprintf('JAWA0%d', $c);

            $classroom = Classroom::withTrashed()->updateOrCreate(
                ['code' => $code],
                [
                    'teacher_id'   => $teacher->id,
                    'name'         => "Kelas Bahasa Jawa {$letter}",
                    'subject'      => 'Bahasa Jawa Dasar & Unggah-Ungguh',
                    'description'  => "Ruang kelas pengujian Bahasa Jawa {$letter} yang diampu oleh {$teacher->name}.",
                    'banner_color' => $bannerColors[$c],
                    'banner_icon'  => 'fa-book-open',
                    'status'       => 'active',
                    'week_titles'  => [
                        1 => 'Minggu 1 - Pengenalan Dasar Bahasa Jawa',
                        2 => 'Minggu 2 - Unggah-Ungguh & Kosakata Kewan',
                    ],
                    'deleted_at'   => null,
                ]
            );

            // Daftarkan 1 Pengajar ke classroom_members
            ClassroomMember::updateOrCreate(
                [
                    'classroom_id' => $classroom->id,
                    'user_id'      => $teacher->id,
                ],
                [
                    'role'      => 'teacher',
                    'joined_at' => now(),
                    'out_at'    => null,
                ]
            );

            // Daftarkan 5 Pelajar ke kelas ini (Kelas 1: Pelajar 1..5, Kelas 2: Pelajar 6..10, dst.)
            $startStudentIdx = (($c - 1) * 5) + 1;
            $endStudentIdx   = $c * 5;
            for ($sIdx = $startStudentIdx; $sIdx <= $endStudentIdx; $sIdx++) {
                ClassroomMember::updateOrCreate(
                    [
                        'classroom_id' => $classroom->id,
                        'user_id'      => $students[$sIdx]->id,
                    ],
                    [
                        'role'      => 'student',
                        'joined_at' => now(),
                        'out_at'    => null,
                    ]
                );
            }

            // ---------------------------------------------------------------------
            // 4. UPLOADAN MATERI PDF DI TIAP KELAS
            // ---------------------------------------------------------------------
            $materialPost = ClassroomPost::withTrashed()->updateOrCreate(
                [
                    'classroom_id' => $classroom->id,
                    'type'         => 'material',
                    'title'        => $materialTitle,
                ],
                [
                    'author_id'    => $teacher->id,
                    'body'         => $materialBody,
                    'week_number'  => 1,
                    'is_published' => true,
                    'deleted_at'   => null,
                ]
            );

            ClassroomPostAttachment::withTrashed()->updateOrCreate(
                [
                    'post_id'       => $materialPost->id,
                    'original_name' => $pdfOriginalName,
                ],
                [
                    'file_path'  => $pdfFilePath,
                    'file_size'  => $pdfFileSize,
                    'mime_type'  => $pdfMimeType,
                    'deleted_at' => null,
                ]
            );

            // ---------------------------------------------------------------------
            // 5. UJIAN (QUIZ) DENGAN TENGGAT BULAN DEPAN DARI BANK SOAL
            // ---------------------------------------------------------------------
            $quizPostTitle = "Ujian Evaluasi Bahasa Jawa - Kelas {$letter}";
            $quizPost = ClassroomPost::withTrashed()->updateOrCreate(
                [
                    'classroom_id' => $classroom->id,
                    'type'         => 'quiz',
                    'title'        => $quizPostTitle,
                ],
                [
                    'author_id'    => $teacher->id,
                    'body'         => 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.',
                    'week_number'  => 1,
                    'is_published' => true,
                    'deleted_at'   => null,
                ]
            );

            $quizSlug = "ujian-evaluasi-bahasa-jawa-kelas-" . strtolower($letter);
            $quizSet = QuizSet::withTrashed()->updateOrCreate(
                ['slug' => $quizSlug],
                [
                    'title'              => $quizPostTitle,
                    'description'        => 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.',
                    'category'           => 'classroom',
                    'time_limit_seconds' => 1800,
                    'is_active'          => true,
                    'deleted_at'         => null,
                ]
            );

            // Tautkan soal dari Bank Soal (gunakan ID 6..10 jika ada, atau soal milik guru demo ini)
            $questionIdsToLink = count($existingBankQuestionIds) === 5
                ? $existingBankQuestionIds
                : QuizQuestion::where('teacher_id', $teacher->id)->orderBy('id')->take(5)->pluck('id')->toArray();

            $order = 1;
            foreach ($questionIdsToLink as $qId) {
                DB::table('quiz_question_items')->updateOrInsert(
                    [
                        'quiz_master_id'   => $quizSet->id,
                        'quiz_question_id' => $qId,
                    ],
                    [
                        'order_number' => $order++,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]
                );
            }

            ClassroomQuiz::withTrashed()->updateOrCreate(
                ['post_id' => $quizPost->id],
                [
                    'quiz_master_id'   => $quizSet->id,
                    'due_date'         => $nextMonthDueDate,
                    'duration_minutes' => 30,
                    'max_score'        => 100,
                    'show_score'       => true,
                    'show_explanation' => true,
                    'max_attempts'     => 1,
                    'instructions'     => 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!',
                    'deleted_at'       => null,
                ]
            );
        }
    }
}
