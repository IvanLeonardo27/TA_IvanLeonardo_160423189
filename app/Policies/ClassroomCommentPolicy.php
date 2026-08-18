<?php

namespace App\Policies;

use App\Models\ClassroomComment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\User;

class ClassroomCommentPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Membuat komentar di sebuah postingan / materi
     */
    public function create(User $user, ClassroomPost $post): bool
    {
        $classroom = $post->classroom;
        if (!$classroom) return false;

        // Guru pemilik kelas
        if ($classroom->teacher_id === $user->id) return true;

        // Anggota aktif
        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Menghapus komentar (penulis komentar atau guru pemilik kelas)
     */
    public function delete(User $user, ClassroomComment $comment): bool
    {
        // Penulis komentar
        if ($comment->user_id === $user->id) return true;

        // Guru pemilik kelas tempat komentar berada
        return $comment->post?->classroom?->teacher_id === $user->id;
    }
}
