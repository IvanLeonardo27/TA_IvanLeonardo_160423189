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

class TesterAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherRole = Role::firstOrCreate(['name' => 'teacher'], ['description' => 'Pengajar/Guru']);
        $studentRole = Role::firstOrCreate(['name' => 'student'], ['description' => 'Pelajar/Siswa']);

        $passwordHash = Hash::make('tester123');

        // 1. Buat 10 Akun Pengajar & Kelas Masing-Masing
        $classrooms = [];

        for ($i = 1; $i <= 10; $i++) {
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            $email = "testerpengajar{$num}@test.com";

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => "Tester Pengajar $num",
                    'user_code' => "TPG{$num}",
                    'password'  => $passwordHash,
                    'role_id'   => $teacherRole->id,
                    'status'    => 'active',
                ]
            );

            TeacherProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip'                    => '19800101' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'institution_name'       => 'SMP/SMA Negeri BasaKula',
                    'subject_specialization' => 'Bahasa & Sastra Jawa',
                    'phone_number'           => '0812' . str_pad($i, 8, '0', STR_PAD_LEFT),
                ]
            );

            // Buat 1 Kelas untuk pengajar ini
            $classCode = "TEST-CLS{$num}";
            $classroom = Classroom::updateOrCreate(
                ['code' => $classCode],
                [
                    'teacher_id'   => $user->id,
                    'name'         => "Kelas Gladhen Basa Jawa $num",
                    'subject'      => 'Bahasa & Sastra Jawa',
                    'description'  => "Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar $num.",
                    'banner_color' => '#16402E',
                    'banner_icon'  => 'fa-book',
                    'status'       => 'active',
                ]
            );

            // Daftarkan pengajar sebagai member kelas (role = teacher)
            ClassroomMember::updateOrCreate(
                ['classroom_id' => $classroom->id, 'user_id' => $user->id],
                [
                    'role'      => 'teacher',
                    'joined_at' => now(),
                    'out_at'    => null,
                ]
            );

            $classrooms[$i] = $classroom;
        }

        // 2. Buat 30 Akun Pelajar & Gabungkan ke 1 Kelas Masing-Masing (3 Pelajar per Kelas)
        for ($i = 1; $i <= 30; $i++) {
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            $email = "testerpelajar{$num}@test.com";

            $student = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => "Tester Pelajar $num",
                    'user_code' => "TPL{$num}",
                    'password'  => $passwordHash,
                    'role_id'   => $studentRole->id,
                    'status'    => 'active',
                ]
            );

            StudentProfile::updateOrCreate(
                ['user_id' => $student->id],
                [
                    'nisn'         => '008' . str_pad($student->id, 7, '0', STR_PAD_LEFT),
                    'school_name'  => 'SMP/SMA Negeri BasaKula',
                    'grade_level'  => 'Kelas 8',
                    'phone_number' => '0821' . str_pad($i, 8, '0', STR_PAD_LEFT),
                ]
            );

            // Masukkan pelajar ke 1 kelas (Pelajar 1-3 masuk Kelas 1, Pelajar 4-6 masuk Kelas 2, dst.)
            $targetClassIndex = (int) ceil($i / 3);
            if (isset($classrooms[$targetClassIndex])) {
                ClassroomMember::updateOrCreate(
                    ['classroom_id' => $classrooms[$targetClassIndex]->id, 'user_id' => $student->id],
                    [
                        'role'      => 'student',
                        'joined_at' => now(),
                        'out_at'    => null,
                    ]
                );
            }
        }

        $this->command->info('40 Akun Tester, 10 Kelas, dan Keanggotaan berhasil dibuat.');
    }
}
