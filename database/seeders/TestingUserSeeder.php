<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestingUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher'], ['description' => 'Pengajar/Guru']);
        $studentRole = Role::firstOrCreate(['name' => 'student'], ['description' => 'Pelajar/Siswa']);

        // 1. Akun Pengajar (Guru)
        User::updateOrCreate(
            ['email' => 'guru@sekolah.com'],
            [
                'name'     => 'Pak Guru Budi',
                'password' => Hash::make('password123'),
                'role_id'  => $teacherRole->id,
                'status'   => 'active',
            ]
        );

        // 2. Akun Pelajar (Siswa)
        User::updateOrCreate(
            ['email' => 'siswa@sekolah.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role_id'  => $studentRole->id,
                'status'   => 'active',
            ]
        );
    }
}
