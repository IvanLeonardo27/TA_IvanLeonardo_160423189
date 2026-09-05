<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassroomQuiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomQuizController extends Controller
{
    /** Menampilkan lembar pengerjaan kuis kelas dengan soal aktual dari database */
    public function show(ClassroomQuiz $quiz)
    {
        Gate::authorize('view', $quiz);

        $post      = $quiz->post;
        $classroom = $post?->classroom;
        $quizSet   = $quiz->quizSet;

        // Cek jika batas pengisian adalah 1x saja dan siswa sudah pernah mengisi
        if ((int)$quiz->max_attempts === 1) {
            $existingAttempt = QuizAttempt::query()
                ->where(function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                    if (!empty($quiz->quiz_set_id)) {
                        $q->orWhere('quiz_set_id', $quiz->quiz_set_id);
                    }
                    if (!empty($quiz->quiz_master_id)) {
                        $q->orWhere('quiz_master_id', $quiz->quiz_master_id);
                    }
                })
                ->where(function($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhere('student_id', Auth::id());
                })
                ->latest('id')
                ->first();

            if ($existingAttempt) {
                return redirect()->route('student.classroom.quiz.result', [$quiz, $existingAttempt])
                    ->with('info', 'Anda telah menyelesaikan kuis ini.');
            }
        }

        // Ambil daftar soal pilihan ganda yang dibuat pengajar di kuis ini
        $questions = QuizQuestion::query()
            ->where(function($q) use ($quiz) {
                if (!empty($quiz->quiz_set_id)) {
                    $q->where('quiz_set_id', $quiz->quiz_set_id);
                }
                if (!empty($quiz->quiz_master_id)) {
                    $q->orWhere('quiz_master_id', $quiz->quiz_master_id);
                }
            })
            ->where('is_active', true)
            ->get();

        return view('student.classroom.quiz_take', compact('quiz', 'post', 'classroom', 'quizSet', 'questions'));
    }

    /** Memproses jawaban kuis siswa & menghitung nilai otomatis */
    public function submit(Request $request, ClassroomQuiz $quiz)
    {
        Gate::authorize('attempt', $quiz);

        $quizSet   = $quiz->quizSet;
        $questions = QuizQuestion::query()
            ->where(function($q) use ($quiz) {
                if (!empty($quiz->quiz_set_id)) {
                    $q->where('quiz_set_id', $quiz->quiz_set_id);
                }
                if (!empty($quiz->quiz_master_id)) {
                    $q->orWhere('quiz_master_id', $quiz->quiz_master_id);
                }
            })
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

        $startedAt = $request->filled('started_at') ? Carbon::parse($request->input('started_at')) : now()->subMinutes(1);
        $takenAt   = now();
        $timeSpentSecs = max(1, $takenAt->diffInSeconds($startedAt));

        // Simpan hasil percobaaan kuis ke database
        $attempt = QuizAttempt::create([
            'quiz_id'            => $quiz->id,
            'quiz_set_id'        => $quiz->quiz_set_id,
            'quiz_master_id'     => $quiz->quiz_master_id ?? $quiz->quiz_set_id,
            'user_id'            => Auth::id(),
            'student_id'         => Auth::id(),
            'player_name'        => Auth::user()?->name ?? 'Siswa',
            'score'              => $calculatedScore,
            'started_at'         => $startedAt,
            'time_spent_seconds' => $timeSpentSecs,
            'taken_at'           => $takenAt,
            'status'             => 'completed',
        ]);

        // Simpan rincian jawaban masing-masing soal ke tabel quiz_answers
        $pointsPerQuestion = $totalQuestions > 0 ? round(($quiz->max_score ?? 100) / $totalQuestions) : 0;
        foreach ($questions as $q) {
            $userAnsIndex = isset($userAnswers[$q->id]) && $userAnswers[$q->id] !== '' ? (int)$userAnswers[$q->id] : null;
            $isCorrect = ($userAnsIndex !== null && $userAnsIndex === (int)$q->correct_index);
            $selectedOption = $userAnsIndex !== null ? chr(65 + $userAnsIndex) : '-';
            $scoreEarned = $isCorrect ? $pointsPerQuestion : 0;

            QuizAnswer::create([
                'attempt_id'      => $attempt->id,
                'question_id'     => $q->id,
                'selected_option' => $selectedOption,
                'is_correct'      => $isCorrect,
                'score_earned'    => $scoreEarned,
            ]);
        }

        $post      = $quiz->post;
        $classroom = $post?->classroom;

        return view('student.classroom.quiz_result', compact('quiz', 'post', 'classroom', 'attempt'));
    }

    /** Menampilkan halaman preview hasil kuis yang sudah pernah dikerjakan */
    public function result(ClassroomQuiz $quiz, ?QuizAttempt $attempt = null)
    {
        Gate::authorize('view', $quiz);

        $post      = $quiz->post;
        $classroom = $post?->classroom;

        if (!$attempt) {
            $attempt = QuizAttempt::query()
                ->where(function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                    if (!empty($quiz->quiz_set_id)) {
                        $q->orWhere('quiz_set_id', $quiz->quiz_set_id);
                    }
                    if (!empty($quiz->quiz_master_id)) {
                        $q->orWhere('quiz_master_id', $quiz->quiz_master_id);
                    }
                })
                ->where(function($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhere('student_id', Auth::id());
                })
                ->latest('id')
                ->firstOrFail();
        } else {
            // Pastikan attempt ini milik user yang bersangkutan (atau pengajar kelas)
            $isOwner = ($attempt->user_id === Auth::id() || $attempt->student_id === Auth::id());
            if (!$isOwner && $classroom?->teacher_id !== Auth::id() && !Auth::user()->isAdmin()) {
                abort(403);
            }
        }

        return view('student.classroom.quiz_result', compact('quiz', 'post', 'classroom', 'attempt'));
    }
}
