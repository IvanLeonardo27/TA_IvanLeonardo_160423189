<?php

namespace App\Policies;

use App\Models\ClassroomAssignment;
use App\Models\ClassroomMember;
use App\Models\User;

class ClassroomAssignmentPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Melihat tugas
     */
    public function view(User $user, ClassroomAssignment $assignment): bool
    {
        $classroom = $assignment->post?->classroom;
        if (!$classroom) return false;

        if ($classroom->teacher_id === $user->id) return true;

        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Mengumpulkan tugas (hanya murid anggota aktif kelas)
     */
    public function submit(User $user, ClassroomAssignment $assignment): bool
    {
        $classroom = $assignment->post?->classroom;
        if (!$classroom) return false;

        if ($classroom->teacher_id === $user->id) return false;

        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Menilai tugas (hanya guru pemilik kelas)
     */
    public function grade(User $user, ClassroomAssignment $assignment): bool
    {
        return $assignment->post?->classroom?->teacher_id === $user->id;
    }
}
