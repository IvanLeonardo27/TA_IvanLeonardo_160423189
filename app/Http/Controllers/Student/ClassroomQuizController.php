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

        // Ambil riwayat percobaan siswa jika ada
        $existingAttempt = QuizAttempt::query()
            ->where(function($q) use ($quiz) {
                $q->where('quiz_id', $quiz->id);
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

        // 1. Cek jika batas pengisian adalah 1x saja dan siswa sudah pernah mengisi
        if ((int)$quiz->max_attempts === 1 && $existingAttempt) {
            return redirect()->route('student.classroom.quiz.result', [$quiz, $existingAttempt])
                ->with('info', 'Anda telah menyelesaikan kuis ini.');
        }

        // 2. Cek apakah batas waktu pengerjaan kuis telah berakhir
        if ($quiz->due_date && now()->greaterThan($quiz->due_date)) {
            if ($existingAttempt) {
                return redirect()->route('student.classroom.quiz.result', [$quiz, $existingAttempt])
                    ->with('error', 'Batas waktu pengerjaan kuis telah berakhir pada ' . $quiz->due_date->format('d M Y, H:i') . '. Pengerjaan ulang telah ditutup.');
            }

            return redirect()->route('student.classroom.show', $classroom?->id ?? 1)
                ->with('error', 'Maaf, batas waktu pengerjaan kuis ini telah berakhir pada ' . $quiz->due_date->format('d M Y, H:i') . '. Kuis sudah ditutup.');
        }

        // Ambil daftar soal pilihan ganda kuis
        $questions = $quiz->getQuestionsList();

        return view('student.classroom.quiz_take', compact('quiz', 'post', 'classroom', 'quizSet', 'questions'));
    }

    /** Memproses jawaban kuis siswa & menghitung nilai otomatis */
    public function submit(Request $request, ClassroomQuiz $quiz)
    {
        $post      = $quiz->post;
        $classroom = $post?->classroom;

        // Cek apakah batas waktu pengerjaan kuis telah berakhir saat submit
        if ($quiz->due_date && now()->greaterThan($quiz->due_date)) {
            return redirect()->route('student.classroom.show', $classroom?->id ?? 1)
                ->with('error', 'Maaf, batas waktu pengerjaan kuis ini telah berakhir pada ' . $quiz->due_date->format('d M Y, H:i') . '. Jawaban Anda tidak dapat diterima.');
        }

        Gate::authorize('attempt', $quiz);

        $quizSet   = $quiz->quizSet;
        $questions = $quiz->getQuestionsList();

        $userAnswers = $request->input('answers', []);
        $totalQuestions = $questions->count();
        $maxScore = (float) ($quiz->max_score ?? 100);
        $questionWeight = $totalQuestions > 0 ? ($maxScore / $totalQuestions) : 0;
        $totalEarnedPoints = 0;

        foreach ($questions as $q) {
            $userAnsIndex = isset($userAnswers[$q->id]) && $userAnswers[$q->id] !== '' ? (int)$userAnswers[$q->id] : null;
            $optWeights   = $q->option_percentages ?? [];

            $pct = 0.0;
            if ($userAnsIndex !== null) {
                if (!empty($optWeights) && isset($optWeights[$userAnsIndex])) {
                    $pct = (float) $optWeights[$userAnsIndex];
                } else {
                    $pct = ($userAnsIndex === (int)$q->correct_index) ? 100.0 : 0.0;
                }
            }

            $totalEarnedPoints += ($questionWeight * ($pct / 100.0));
        }

        $calculatedScore = $totalQuestions > 0 ? (int) round($totalEarnedPoints) : 0;

        $startedAt = $request->filled('started_at') ? Carbon::parse($request->input('started_at')) : now()->subMinutes(1);
        $takenAt   = now();
        $timeSpentSecs = max(1, $takenAt->diffInSeconds($startedAt));

        // Simpan hasil percobaaan kuis ke database
        $attempt = QuizAttempt::create([
            'quiz_id'            => $quiz->id,
            'quiz_master_id'     => $quiz->quiz_master_id,
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
        $pointsPerQuestion = $totalQuestions > 0 ? ($maxScore / $totalQuestions) : 0;
        foreach ($questions as $q) {
            $userAnsIndex = isset($userAnswers[$q->id]) && $userAnswers[$q->id] !== '' ? (int)$userAnswers[$q->id] : null;
            $optWeights   = $q->option_percentages ?? [];

            $pct = 0.0;
            if ($userAnsIndex !== null) {
                if (!empty($optWeights) && isset($optWeights[$userAnsIndex])) {
                    $pct = (float) $optWeights[$userAnsIndex];
                } else {
                    $pct = ($userAnsIndex === (int)$q->correct_index) ? 100.0 : 0.0;
                }
            }

            $isCorrect      = ($pct >= 100.0);
            $selectedOption = $userAnsIndex !== null ? chr(65 + $userAnsIndex) : '-';
            $scoreEarned    = (int) round($pointsPerQuestion * ($pct / 100.0));

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

    /** Menampilkan halaman pembahasan & rincian jawaban soal kuis */
    public function review(ClassroomQuiz $quiz, ?QuizAttempt $attempt = null)
    {
        Gate::authorize('view', $quiz);

        $post      = $quiz->post;
        $classroom = $post?->classroom;

        if (!$attempt) {
            $attempt = QuizAttempt::query()
                ->where(function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
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
            // Pastikan attempt ini milik user yang bersangkutan (atau pengajar kelas / admin)
            $isOwner = ($attempt->user_id === Auth::id() || $attempt->student_id === Auth::id());
            if (!$isOwner && $classroom?->teacher_id !== Auth::id() && !Auth::user()->isAdmin()) {
                abort(403);
            }
        }

        // Cek izin akses pembahasan dari pengajar (Kecuali jika yang melihat adalah guru pemilik kelas / admin)
        $isTeacherOrAdmin = (Auth::id() === $classroom?->teacher_id || Auth::user()->isAdmin());
        if (!$quiz->show_explanation && !$isTeacherOrAdmin) {
            return redirect()->route('student.classroom.quiz.result', [$quiz, $attempt])
                ->with('error', 'Pembahasan kuis ini belum dibuka oleh pengajar.');
        }

        // Ambil daftar soal pilihan ganda kuis
        $questions = $quiz->getQuestionsList();

        // Ambil mapping jawaban siswa [question_id => QuizAnswer]
        $answers = $attempt->answers->keyBy('question_id');

        return view('student.classroom.quiz_review', compact('quiz', 'post', 'classroom', 'attempt', 'questions', 'answers'));
    }
}
