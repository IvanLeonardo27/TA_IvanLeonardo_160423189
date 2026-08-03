<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassroomQuizController extends Controller
{
    /** Menampilkan lembar pengerjaan kuis kelas dengan soal aktual dari database */
    public function show(\App\Models\ClassroomQuiz $quiz)
    {
        $post      = $quiz->post;
        $classroom = $post?->classroom;
        $quizSet   = $quiz->quizSet;

        // Cek jika batas pengisian adalah 1x saja dan siswa sudah pernah mengisi
        if ((int)$quiz->max_attempts === 1) {
            $existingAttempt = \App\Models\QuizAttempt::query()
                ->where('quiz_set_id', $quiz->quiz_set_id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingAttempt) {
                return redirect()->route('student.classroom.show', $post->classroom_id)
                    ->with('error', 'Anda telah menyelesaikan kuis ini. Kuis hanya dapat diisi 1 kali.');
            }
        }

        // Ambil daftar soal pilihan ganda yang dibuat pengajar di kuis ini
        $questions = \App\Models\QuizQuestion::query()
            ->where('quiz_set_id', $quiz->quiz_set_id)
            ->where('is_active', true)
            ->get();

        return view('student.classroom.quiz_take', compact('quiz', 'post', 'classroom', 'quizSet', 'questions'));
    }

    /** Memproses jawaban kuis siswa & menghitung nilai otomatis */
    public function submit(Request $request, \App\Models\ClassroomQuiz $quiz)
    {
        $quizSet   = $quiz->quizSet;
        $questions = \App\Models\QuizQuestion::query()
            ->where('quiz_set_id', $quiz->quiz_set_id)
            ->where('is_active', true)
            ->get();

        $userAnswers = $request->input('answers', []);
        $totalQuestions = $questions->count();
        $correctCount   = 0;

        foreach ($questions as $index => $q) {
            $userAnsIndex = isset($userAnswers[$q->id]) ? (int)$userAnswers[$q->id] : null;
            if ($userAnsIndex !== null && $userAnsIndex === (int)$q->correct_index) {
                $correctCount++;
            }
        }

        $calculatedScore = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * ($quiz->max_score ?? 100)) : 0;

        $startedAt = $request->filled('started_at') ? \Carbon\Carbon::parse($request->input('started_at')) : now()->subMinutes(1);
        $takenAt   = now();
        $timeSpentSecs = max(1, $takenAt->diffInSeconds($startedAt));

        // Simpan hasil percobaaan kuis ke database
        $attempt = \App\Models\QuizAttempt::create([
            'quiz_set_id'        => $quiz->quiz_set_id,
            'user_id'            => auth()->id(),
            'player_name'        => auth()->user()?->name ?? 'Siswa',
            'score'              => $calculatedScore,
            'started_at'         => $startedAt,
            'time_spent_seconds' => $timeSpentSecs,
            'taken_at'           => $takenAt,
        ]);

        $post      = $quiz->post;
        $classroom = $post?->classroom;

        return view('student.classroom.quiz_result', compact('quiz', 'post', 'classroom', 'attempt'));
    }

    /** Menampilkan halaman preview hasil kuis yang sudah pernah dikerjakan */
    public function result(\App\Models\ClassroomQuiz $quiz, ?\App\Models\QuizAttempt $attempt = null)
    {
        $post      = $quiz->post;
        $classroom = $post?->classroom;

        if (!$attempt) {
            $attempt = \App\Models\QuizAttempt::query()
                ->where('quiz_set_id', $quiz->quiz_set_id)
                ->where('user_id', auth()->id())
                ->latest()
                ->firstOrFail();
        }

        return view('student.classroom.quiz_result', compact('quiz', 'post', 'classroom', 'attempt'));
    }
}
