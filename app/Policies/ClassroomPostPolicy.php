<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\User;

class ClassroomPostPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Menentukan apakah pengguna dapat melihat postingan / materi / kuis
     */
    public function view(User $user, ClassroomPost $post): bool
    {
        $classroom = $post->classroom;
        if (!$classroom) return false;

        // Guru pemilik kelas
        if ($classroom->teacher_id === $user->id) {
            return true;
        }

        // Anggota aktif kelas
        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Menentukan apakah pengguna dapat membuat postingan di kelas
     */
    public function create(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Menentukan apakah pengguna dapat menghapus postingan
     */
    public function delete(User $user, ClassroomPost $post): bool
    {
        // Pemilik kelas atau penulis postingan
        return $post->classroom->teacher_id === $user->id || $post->user_id === $user->id;
    }
}
