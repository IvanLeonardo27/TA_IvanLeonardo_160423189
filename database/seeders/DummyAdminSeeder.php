<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyAdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'name'      => 'Administrator BasaKula',
                'password'  => Hash::make('password123'),
                'role_id'   => $adminRole->id,
                'status'    => 'active',
                'user_code' => 'ADM001',
            ]
        );

        $this->command->info("Dummy Administrator berhasil dibuat/diperbarui:");
        $this->command->info("Nama     : " . $admin->name);
        $this->command->info("Email    : " . $admin->email);
        $this->command->info("Password : password123");
        $this->command->info("Role     : Admin (ID: " . $adminRole->id . ")");
    }
}
