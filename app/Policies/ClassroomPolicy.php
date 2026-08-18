<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\User;

class ClassroomPolicy
{
    /**
     * Hak akses umum / superadmin bypass
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Menentukan apakah pengguna dapat melihat daftar kelas
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Menentukan apakah pengguna dapat melihat detail ruang kelas
     */
    public function view(User $user, Classroom $classroom): bool
    {
        // Guru pemilik kelas
        if ($classroom->teacher_id === $user->id) {
            return true;
        }

        // Siswa yang merupakan anggota aktif kelas (out_at IS NULL)
        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Menentukan apakah pengguna dapat membuat kelas baru (hanya pengajar)
     */
    public function create(User $user): bool
    {
        return $user->isTeacher();
    }

    /**
     * Menentukan apakah pengajar dapat memperbarui kelas
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Menentukan apakah pengajar dapat menghapus kelas
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Menentukan apakah pengajar dapat mengeluarkan anggota dari kelas
     */
    public function manageMembers(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Menentukan apakah siswa dapat bergabung ke kelas
     */
    public function join(User $user, Classroom $classroom): bool
    {
        // Pengajar pemilik tidak boleh bergabung sebagai murid
        if ($classroom->teacher_id === $user->id) {
            return false;
        }

        // Tidak boleh gabung jika sudah aktif
        $alreadyActive = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();

        return !$alreadyActive;
    }
}
