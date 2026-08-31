<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role id 2 (teacher) dan 3 (student) tersedia
        $teacherRole = Role::firstOrCreate(['name' => 'teacher'], ['description' => 'Pengajar']);
        $studentRole = Role::firstOrCreate(['name' => 'student'], ['description' => 'Siswa/Pelajar']);

        $passwordHash = Hash::make('password123');

        // ==========================================
        // 1. DATA DUMMY 20 PENGAJAR (TEACHERS) & TEACHER_PROFILES (20 DATA)
        // ==========================================
        $teachersData = [
            ['name' => 'Budi Santoso, S.Pd.', 'email' => 'budi.santoso@basakula.edu', 'code' => '27701001', 'nip' => '198501152010121001', 'school' => 'SMA Negeri 1 Yogyakarta', 'spec' => 'Bahasa & Sastra Jawa'],
            ['name' => 'Siti Aminah, M.Pd.', 'email' => 'siti.aminah@basakula.edu', 'code' => '27701002', 'nip' => '198703222011012003', 'school' => 'SMA Negeri 3 Surabaya', 'spec' => 'Tembang Macapat & Karawitan'],
            ['name' => 'Ki Agus Purwanto, S.Sn.', 'email' => 'agus.purwanto@basakula.edu', 'code' => '27701003', 'nip' => '198208102008041002', 'school' => 'SMA Negeri 2 Surakarta', 'spec' => 'Pewayangan lan Budaya Jawa'],
            ['name' => 'Dewi Lestari, S.Pd.', 'email' => 'dewi.lestari@basakula.edu', 'code' => '27701004', 'nip' => '199004122014022005', 'school' => 'SMP Negeri 1 Semarang', 'spec' => 'Aksara Jawa & Pasangan'],
            ['name' => 'Eko Prasetyo, M.Hum.', 'email' => 'eko.prasetyo@basakula.edu', 'code' => '27701005', 'nip' => '198411052009031004', 'school' => 'SMA Katolik St. Louis Surabaya', 'spec' => 'Unggah-Ungguh & Paramasastra'],
            ['name' => 'Sri Wahyuni, S.Pd.', 'email' => 'sri.wahyuni@basakula.edu', 'code' => '27701006', 'nip' => '198806252012042001', 'school' => 'SMA Negeri 1 Malang', 'spec' => 'Sastra Jawa Klasik'],
            ['name' => 'Bambang Wijaya, S.Pd.', 'email' => 'bambang.wijaya@basakula.edu', 'code' => '27701007', 'nip' => '198109182006041003', 'school' => 'SMA Negeri 5 Surabaya', 'spec' => 'Kebudayaan lan Seni Pertunjukan'],
            ['name' => 'Endang Rahayu, M.Pd.', 'email' => 'endang.rahayu@basakula.edu', 'code' => '27701008', 'nip' => '198602142010012008', 'school' => 'SMA Negeri 1 Surakarta', 'spec' => 'Bahasa Jawa Modern'],
            ['name' => 'Hadi Sucipto, S.Sn.', 'email' => 'hadi.sucipto@basakula.edu', 'code' => '27701009', 'nip' => '198307302009021005', 'school' => 'SMK Negeri 1 Yogyakarta', 'spec' => 'Seni Pedalangan & Wayang'],
            ['name' => 'Tri Handayani, S.Pd.', 'email' => 'tri.handayani@basakula.edu', 'code' => '27701010', 'nip' => '199105192015032002', 'school' => 'SMP Negeri 4 Surakarta', 'spec' => 'Gagrag Ngayogyakarta'],
            ['name' => 'Dr. Raden Mas Sutrisno', 'email' => 'sutrisno@basakula.edu', 'code' => '27701011', 'nip' => '197512101999031001', 'school' => 'SMA Negeri 8 Yogyakarta', 'spec' => 'Filologi & Naskah Kuno Jawa'],
            ['name' => 'Retno Palupi, S.Pd.', 'email' => 'retno.palupi@basakula.edu', 'code' => '27701012', 'nip' => '199208082016012004', 'school' => 'SMA Negeri 2 Malang', 'spec' => 'Tembang Macapat & Geguritan'],
            ['name' => 'Joko Nugroho, S.Pd.', 'email' => 'joko.nugroho@basakula.edu', 'code' => '27701013', 'nip' => '198903152014011002', 'school' => 'SMP Negeri 2 Yogyakarta', 'spec' => 'Kamus & Kosakata Basa Jawa'],
            ['name' => 'Nining Sunarni, M.Pd.', 'email' => 'nining.sunarni@basakula.edu', 'code' => '27701014', 'nip' => '198711202011022006', 'school' => 'SMA Negeri 1 Magelang', 'spec' => 'Tata Basa Krama & Ngoko'],
            ['name' => 'Kuncoro Adi, S.Sn.', 'email' => 'kuncoro.adi@basakula.edu', 'code' => '27701015', 'nip' => '198304052008011007', 'school' => 'SMK Seni Surakarta', 'spec' => 'Seni Gamelan lan Tembang'],
            ['name' => 'Lestari Ningrum, S.Pd.', 'email' => 'lestari.ningrum@basakula.edu', 'code' => '27701016', 'nip' => '199301172017022003', 'school' => 'SMA Negeri 6 Surabaya', 'spec' => 'Aksara Murda & Rekan'],
            ['name' => 'Danang Wibowo, S.Pd.', 'email' => 'danang.wibowo@basakula.edu', 'code' => '27701017', 'nip' => '199010092015021006', 'school' => 'SMA Negeri 3 Surakarta', 'spec' => 'Cerita Rakyat & Dongeng Jawa'],
            ['name' => 'Wulandari, M.Hum.', 'email' => 'wulandari@basakula.edu', 'code' => '27701018', 'nip' => '198609282011012009', 'school' => 'SMA Negeri 1 Kediri', 'spec' => 'Dialektologi & Basa Jawa Kuno'],
            ['name' => 'Sugeng Priyanto, S.Pd.', 'email' => 'sugeng.priyanto@basakula.edu', 'code' => '27701019', 'nip' => '198405122009031008', 'school' => 'SMP Negeri 1 Surakarta', 'spec' => 'Gladhen Basa Jawa'],
            ['name' => 'Yuniastuti, S.Pd.', 'email' => 'yuniastuti@basakula.edu', 'code' => '27701020', 'nip' => '199112042016022007', 'school' => 'SMA Negeri 4 Yogyakarta', 'spec' => 'Evaluasi & Pembelajaran Basa Jawa']
        ];

        $teacherUserIds = [];

        foreach ($teachersData as $idx => $td) {
            $user = User::updateOrCreate(
                ['email' => $td['email']],
                [
                    'role_id'   => $teacherRole->id,
                    'name'      => $td['name'],
                    'user_code' => $td['code'],
                    'password'  => $passwordHash,
                    'status'    => 'active',
                ]
            );

            TeacherProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip'                    => $td['nip'],
                    'institution_name'       => $td['school'],
                    'subject_specialization' => $td['spec'],
                    'phone_number'           => '0812' . sprintf('%08d', $idx + 1),
                ]
            );

            $teacherUserIds[] = $user->id;
        }

        // ==========================================
        // 2. DATA DUMMY 20 SISWA (STUDENTS) & STUDENT_PROFILES (20 DATA)
        // ==========================================
        $studentsData = [
            ['name' => 'Ahmad Rizky Pratama', 'email' => 'ahmad.rizky@student.basakula.edu', 'code' => '27705001', 'nisn' => '0051234001', 'grade' => 'Kelas XI IPA 1'],
            ['name' => 'Anisa Rahmawati', 'email' => 'anisa.rahma@student.basakula.edu', 'code' => '27705002', 'nisn' => '0051234002', 'grade' => 'Kelas XI IPA 2'],
            ['name' => 'Bagas Maulana', 'email' => 'bagas.maulana@student.basakula.edu', 'code' => '27705003', 'nisn' => '0051234003', 'grade' => 'Kelas XI IPS 1'],
            ['name' => 'Citra Dewi Permata', 'email' => 'citra.dewi@student.basakula.edu', 'code' => '27705004', 'nisn' => '0051234004', 'grade' => 'Kelas XI IPS 2'],
            ['name' => 'Dwi Cahyo Nugroho', 'email' => 'dwi.cahyo@student.basakula.edu', 'code' => '27705005', 'nisn' => '0051234005', 'grade' => 'Kelas X-A'],
            ['name' => 'Eka Putri Lestari', 'email' => 'eka.putri@student.basakula.edu', 'code' => '27705006', 'nisn' => '0051234006', 'grade' => 'Kelas X-B'],
            ['name' => 'Fajar Kurniawan', 'email' => 'fajar.kurnia@student.basakula.edu', 'code' => '27705007', 'nisn' => '0051234007', 'grade' => 'Kelas X-C'],
            ['name' => 'Gita Gutawa Putri', 'email' => 'gita.gutawa@student.basakula.edu', 'code' => '27705008', 'nisn' => '0051234008', 'grade' => 'Kelas XII IPA 1'],
            ['name' => 'Hafiz Hendrawan', 'email' => 'hafiz.hendra@student.basakula.edu', 'code' => '27705009', 'nisn' => '0051234009', 'grade' => 'Kelas XII IPA 2'],
            ['name' => 'Indah Kusuma Wardani', 'email' => 'indah.kusuma@student.basakula.edu', 'code' => '27705010', 'nisn' => '0051234010', 'grade' => 'Kelas XII IPS 1'],
            ['name' => 'Joko Susilo', 'email' => 'joko.susilo@student.basakula.edu', 'code' => '27705011', 'nisn' => '0051234011', 'grade' => 'Kelas XI Bahasa'],
            ['name' => 'Karin Novilda', 'email' => 'karin.novilda@student.basakula.edu', 'code' => '27705012', 'nisn' => '0051234012', 'grade' => 'Kelas XI IPA 3'],
            ['name' => 'Lukman Hakim', 'email' => 'lukman.hakim@student.basakula.edu', 'code' => '27705013', 'nisn' => '0051234013', 'grade' => 'Kelas X-D'],
            ['name' => 'Maya Anggraini', 'email' => 'maya.anggraini@student.basakula.edu', 'code' => '27705014', 'nisn' => '0051234014', 'grade' => 'Kelas XI IPS 3'],
            ['name' => 'Naufal Alifi', 'email' => 'naufal.alifi@student.basakula.edu', 'code' => '27705015', 'nisn' => '0051234015', 'grade' => 'Kelas XII Bahasa'],
            ['name' => 'Olivia Zalianty', 'email' => 'olivia.z@student.basakula.edu', 'code' => '27705016', 'nisn' => '0051234016', 'grade' => 'Kelas XI IPA 4'],
            ['name' => 'Panji Pradana', 'email' => 'panji.pradana@student.basakula.edu', 'code' => '27705017', 'nisn' => '0051234017', 'grade' => 'Kelas X-E'],
            ['name' => 'Qonita Rahmani', 'email' => 'qonita.rahma@student.basakula.edu', 'code' => '27705018', 'nisn' => '0051234018', 'grade' => 'Kelas XII IPA 3'],
            ['name' => 'Rian Ardianto', 'email' => 'rian.ardianto@student.basakula.edu', 'code' => '27705019', 'nisn' => '0051234019', 'grade' => 'Kelas XI IPS 4'],
            ['name' => 'Salsabila Putri', 'email' => 'salsabila.p@student.basakula.edu', 'code' => '27705020', 'nisn' => '0051234020', 'grade' => 'Kelas X-F']
        ];

        $studentUserIds = [];

        foreach ($studentsData as $idx => $sd) {
            $user = User::updateOrCreate(
                ['email' => $sd['email']],
                [
                    'role_id'   => $studentRole->id,
                    'name'      => $sd['name'],
                    'user_code' => $sd['code'],
                    'password'  => $passwordHash,
                    'status'    => 'active',
                ]
            );

            StudentProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nisn'         => $sd['nisn'],
                    'school_name'  => 'SMA Negeri 1 Yogyakarta',
                    'grade_level'  => $sd['grade'],
                    'phone_number' => '0857' . sprintf('%08d', $idx + 1),
                ]
            );

            $studentUserIds[] = $user->id;
        }

        // ==========================================
        // 3. DATA DUMMY 20 KELAS (CLASSROOMS) & CLASSROOM_MEMBERS (15 - 20 ANGGOTA DIAKAP)
        // ==========================================
        $classroomsData = [
            ['name' => 'Bahasa Jawa XI IPA 1', 'subject' => 'Bahasa Jawa', 'code' => 'JW-IPA11', 'color' => '#16402E', 'icon' => 'fa-book', 'desc' => 'Kelas pembelajaran Bahasa Jawa semester genap XI IPA 1.'],
            ['name' => 'Sinau Aksara Jawa & Pasangan', 'subject' => 'Aksara Jawa', 'code' => 'AKSARA-01', 'color' => '#0284C7', 'icon' => 'fa-pen-nib', 'desc' => 'Pendalaman materi Aksara Nglegena, Pasangan, lan Sandhangan.'],
            ['name' => 'Pewayangan lan Carita Rakyat', 'subject' => 'Seni Budaya', 'code' => 'WAYANG-101', 'color' => '#D97706', 'icon' => 'fa-masks-theater', 'desc' => 'Mengenal tokoh Pandawa, Kurawa, lan karakter Pewayangan Jawa.'],
            ['name' => 'Tembang Macapat & Paugeran', 'subject' => 'Sastra Jawa', 'code' => 'MACAPAT-22', 'color' => '#15803D', 'icon' => 'fa-scroll', 'desc' => 'Sinau 11 Tembang Macapat, Guru Gatra, Guru Wilangan, lan Guru Lagu.'],
            ['name' => 'Unggah-Ungguh Basa Krama', 'subject' => 'Bahasa Jawa', 'code' => 'KRAMA-303', 'color' => '#DC2626', 'icon' => 'fa-graduation-cap', 'desc' => 'Penerapan Basa Ngoko lan Krama Inggil sajroning panguripan sehari-hari.'],
            ['name' => 'Gagrag Ngayogyakarta & Surakarta', 'subject' => 'Seni Budaya', 'code' => 'GAGRAG-05', 'color' => '#475569', 'icon' => 'fa-landmark', 'desc' => 'Memahami perbandingan busana adat lan tata cara Ngayogyakarta & Surakarta.'],
            ['name' => 'Geguritan lan Puisi Jawa', 'subject' => 'Sastra Jawa', 'code' => 'PUISI-JW7', 'color' => '#7C3AED', 'icon' => 'fa-feather', 'desc' => 'Pengenalan lan teknik membaca geguritan Jawa modern.'],
            ['name' => 'Paramasastra lan Tata Basa Jawa', 'subject' => 'Bahasa Jawa', 'code' => 'PARAMA-88', 'color' => '#059669', 'icon' => 'fa-spell-check', 'desc' => 'Struktur ukara, tembung lingga, lan tembung rewanda.'],
            ['name' => 'Cerita Rakyat lan Dongeng Jawa', 'subject' => 'Sastra Jawa', 'code' => 'DONGENG-09', 'color' => '#D97706', 'icon' => 'fa-book-open-reader', 'desc' => 'Kumpulan legenda lan cerita rakyat Jawa Nusantara.'],
            ['name' => 'Seni Karawitan lan Gamelan', 'subject' => 'Seni Budaya', 'code' => 'GAMELAN-12', 'color' => '#B45309', 'icon' => 'fa-music', 'desc' => 'Pengenalan instrumen gamelan Jawa: saron, bonang, lan gong.'],
            ['name' => 'Aksara Murda, Swara, lan Rekan', 'subject' => 'Aksara Jawa', 'code' => 'MURDA-404', 'color' => '#0284C7', 'icon' => 'fa-file-lines', 'desc' => 'Pendalaman penulisan gelar, nama daerah, lan serapan aksara asing.'],
            ['name' => 'Bahasa Jawa X-A Reguler', 'subject' => 'Bahasa Jawa', 'code' => 'JW-XA2026', 'color' => '#16402E', 'icon' => 'fa-users', 'desc' => 'Materi kelas Bahasa Jawa dasar untuk siswa kelas X.'],
            ['name' => 'Bahasa Jawa XII IPS Unggulan', 'subject' => 'Bahasa Jawa', 'code' => 'JW-XII-IPS', 'color' => '#0369A1', 'icon' => 'fa-award', 'desc' => 'Persiapan ujian kelulusan lan materi Bahasa Jawa lanjutan.'],
            ['name' => 'Kamus Kosakata Basa Jawa', 'subject' => 'Bahasa Jawa', 'code' => 'VOCAB-55', 'color' => '#15803D', 'icon' => 'fa-language', 'desc' => 'Penguasaan 1.800+ kata Jawa Ngoko lan Krama Inggil.'],
            ['name' => 'Upacara Adat lan Tradisi Jawa', 'subject' => 'Seni Budaya', 'code' => 'TRADISI-77', 'color' => '#C026D3', 'icon' => 'fa-sun', 'desc' => 'Mengenal upacara Tedhak Siten, Mitoni, lan Pernikahan Adat Jawa.'],
            ['name' => 'Lakon Mahabarata lan Ramayana', 'subject' => 'Pewayangan', 'code' => 'MAHAB-108', 'color' => '#B91C1C', 'icon' => 'fa-shield-halved', 'desc' => 'Kisah epik Baratayuda, Perang Kurukshetra, lan kisah Ramayana.'],
            ['name' => 'Sastra Jawa Modern lan Novel', 'subject' => 'Sastra Jawa', 'code' => 'NOVEL-JW', 'color' => '#4338CA', 'icon' => 'fa-book-bookmark', 'desc' => 'Apresiasi karya novel lan cerpen Bahasa Jawa modern.'],
            ['name' => 'Pribasa, Paribasan, lan Saloka', 'subject' => 'Bahasa Jawa', 'code' => 'SALOKA-99', 'color' => '#0D9488', 'icon' => 'fa-quote-left', 'desc' => 'Memahami peribahasa Jawa lan ungkapan bijak para leluhur.'],
            ['name' => 'Pratama Aksara Jawa Digital', 'subject' => 'Aksara Jawa', 'code' => 'DIGITAL-AK', 'color' => '#2563EB', 'icon' => 'fa-keyboard', 'desc' => 'Pelatihan mengetik Aksara Jawa di Komputer lan Smartphone.'],
            ['name' => 'Ujian & Evaluasi Basa Jawa', 'subject' => 'Bahasa Jawa', 'code' => 'EVAL-2026', 'color' => '#E11D48', 'icon' => 'fa-chart-column', 'desc' => 'Ruang kuis interaktif lan ujian evaluasi Bahasa Jawa.']
        ];

        foreach ($classroomsData as $idx => $cd) {
            $assignedTeacherId = $teacherUserIds[$idx % count($teacherUserIds)];

            $classroom = Classroom::updateOrCreate(
                ['code' => $cd['code']],
                [
                    'teacher_id'   => $assignedTeacherId,
                    'name'         => $cd['name'],
                    'subject'      => $cd['subject'],
                    'description'  => $cd['desc'],
                    'banner_color' => $cd['color'],
                    'banner_icon'  => $cd['icon'],
                    'status'       => 'active',
                    'week_titles'  => [
                        "1" => "Minggu 1 - Pengenalan & Orientasi",
                        "2" => "Minggu 2 - Materi Utama & Pemahaman Konsep",
                        "3" => "Minggu 3 - Penugasan Praktik & Latihan",
                        "4" => "Minggu 4 - Evaluasi / Kuis Interaktif"
                    ]
                ]
            );

            // =========================================================
            // GENERATE CLASSROOM MEMBERS (15 - 20 ANGGOTA UNTUK TIAP KELAS)
            // =========================================================
            // 1. Pengajar Utama (Role Teacher)
            ClassroomMember::updateOrCreate(
                ['classroom_id' => $classroom->id, 'user_id' => $assignedTeacherId],
                ['role' => 'teacher', 'joined_at' => now()]
            );

            // 2. Pengajar Pendamping (Co-Teacher Acak)
            $otherTeachers = array_values(array_diff($teacherUserIds, [$assignedTeacherId]));
            $coTeacherId = $otherTeachers[array_rand($otherTeachers)];
            ClassroomMember::updateOrCreate(
                ['classroom_id' => $classroom->id, 'user_id' => $coTeacherId],
                ['role' => 'teacher', 'joined_at' => now()]
            );

            // 3. Siswa Anggota (Diacak Antara 13 - 18 Siswa agar Total Anggota = 15 - 20)
            $targetMemberCount = rand(15, 20);
            $neededStudents = $targetMemberCount - 2; // (1 Guru Utama + 1 Co-Teacher)

            $shuffledStudentIds = $studentUserIds;
            shuffle($shuffledStudentIds);
            $selectedStudentIds = array_slice($shuffledStudentIds, 0, min($neededStudents, count($shuffledStudentIds)));

            foreach ($selectedStudentIds as $stuId) {
                ClassroomMember::updateOrCreate(
                    ['classroom_id' => $classroom->id, 'user_id' => $stuId],
                    ['role' => 'student', 'joined_at' => now()]
                );
            }

            // Pastikan User ID 2 (Akun Pengujian Siswa) Terdaftar di 10 Kelas Pertama
            if ($idx < 10 && User::where('id', 2)->exists()) {
                ClassroomMember::updateOrCreate(
                    ['classroom_id' => $classroom->id, 'user_id' => 2],
                    ['role' => 'student', 'joined_at' => now()]
                );
            }
        }
    }
}
