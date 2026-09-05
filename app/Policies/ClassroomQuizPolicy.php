<?php

namespace App\Policies;

use App\Models\ClassroomMember;
use App\Models\ClassroomQuiz;
use App\Models\QuizAttempt;
use App\Models\User;

class ClassroomQuizPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Melihat kuis
     */
    public function view(User $user, ClassroomQuiz $quiz): bool
    {
        $classroom = $quiz->post?->classroom;
        if (!$classroom) return false;

        if ($classroom->teacher_id === $user->id) return true;

        return ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();
    }

    /**
     * Mengerjakan kuis (siswa anggota aktif yang belum melebihi max_attempts)
     */
    public function attempt(User $user, ClassroomQuiz $quiz): bool
    {
        $classroom = $quiz->post?->classroom;
        if (!$classroom) return false;

        // Guru tidak mengerjakan kuis
        if ($classroom->teacher_id === $user->id) return false;

        // Harus anggota aktif
        $isMember = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->exists();

        if (!$isMember) return false;

        // Cek batas pengerjaan jika single attempt
        if ((int)$quiz->max_attempts === 1) {
            $hasAttempt = QuizAttempt::where(function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                    if (!empty($quiz->quiz_set_id)) {
                        $q->orWhere('quiz_set_id', $quiz->quiz_set_id);
                    }
                    if (!empty($quiz->quiz_master_id)) {
                        $q->orWhere('quiz_master_id', $quiz->quiz_master_id);
                    }
                })
                ->where(function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('student_id', $user->id);
                })
                ->exists();
            if ($hasAttempt) return false;
        }

        return true;
    }

    /**
     * Pratinjau hasil dan ekspor excel kuis (hanya guru pemilik)
     */
    public function manageResults(User $user, ClassroomQuiz $quiz): bool
    {
        return $quiz->post?->classroom?->teacher_id === $user->id;
    }
}
