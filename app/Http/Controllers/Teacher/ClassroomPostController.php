<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomPost;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomPostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassroomPostController extends Controller
{
    /** Form buat post (pengumuman / materi / tugas) */
    public function create(Classroom $classroom)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', [ClassroomPost::class, $classroom]);
        return view('teacher.classroom.post.create', compact('classroom'));
    }

    /** Simpan post baru */
    public function store(Request $request, Classroom $classroom)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', [ClassroomPost::class, $classroom]);

        $validated = $request->validate([
            'type'             => 'required|in:announcement,material,assignment,quiz',
            'title'            => 'nullable|string|max:200',
            'body'             => 'nullable|string',
            'is_pinned'        => 'boolean',
            'files.*'          => 'nullable|file|max:20480', // 20MB per file
            // Assignment / Quiz fields
            'due_date'            => 'nullable|date',
            'assignment_due_date' => 'nullable|date',
            'quiz_due_date'       => 'nullable|date',
            'duration_minutes'    => 'nullable|integer|min:1|max:300',
            'max_score'           => 'nullable|integer|min:0|max:1000',
            'show_score'          => 'nullable|boolean',
            'max_attempts'        => 'nullable|integer|in:0,1',
            'instructions'        => 'nullable|string',
        ]);

        $postBody = $validated['body'] ?? null;
        if ($validated['type'] === 'material') {
            $inputMode = $request->input('material_input_mode', 'ppt');
            
            $checkpointData = null;
            if ($request->boolean('has_practice_questions')) {
                $questionsInput = $request->input('material_questions', $request->input('questions', []));
                if (is_array($questionsInput) && count($questionsInput) > 0) {
                    $q1 = $questionsInput[0];
                    $optionsRaw = $q1['options'] ?? [];
                    $correctLetter = $q1['correct'] ?? 'A';
                    $optionsList = [];
                    $correctIndex = 0;
                    $idx = 0;
                    foreach ($optionsRaw as $letter => $optText) {
                        if (!empty($optText)) {
                            $optionsList[] = $optText;
                            if ($letter === $correctLetter) {
                                $correctIndex = $idx;
                            }
                            $idx++;
                        }
                    }
                    if (!empty($q1['text'])) {
                        $checkpointData = [
                            'question'         => $q1['text'],
                            'options'          => $optionsList,
                            'correct_index'    => $correctIndex,
                            'checkpoint_slide' => (int) $request->input('checkpoint_slide', 1),
                        ];
                    }
                }
            }

            if ($inputMode === 'ppt' || $request->filled('total_ppt_slides')) {
                $totalSlides = max(1, (int) $request->input('total_ppt_slides', 10));
                $postBody = json_encode([
                    'total_slides'  => $totalSlides,
                    'plain_summary' => $validated['body'] ?? 'Materi Pembelajaran PDF',
                    'is_ppt'        => true,
                    'checkpoint'    => $checkpointData,
                ]);
            } elseif ($request->has('slides') && is_array($request->input('slides'))) {
                $slidesList = [];
                foreach ($request->input('slides') as $sIndex => $s) {
                    if (!empty($s['content']) || !empty($s['title'])) {
                        $slidesList[] = [
                            'title'   => !empty($s['title']) ? $s['title'] : ('Slide ' . (count($slidesList) + 1)),
                            'content' => $s['content'] ?? '',
                        ];
                    }
                }
                if (count($slidesList) > 0) {
                    $postBody = json_encode([
                        'slides'        => $slidesList,
                        'plain_summary' => $validated['body'] ?? '',
                        'checkpoint'    => $checkpointData,
                    ]);
                }
            }
        }

        $post = ClassroomPost::create([
            'classroom_id' => $classroom->id,
            'author_id'    => Auth::id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'] ?? null,
            'body'         => $postBody,
            'is_pinned'    => $request->boolean('is_pinned'),
        ]);

        // Upload lampiran
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store("classrooms/{$classroom->id}/posts/{$post->id}", 'public');
                ClassroomPostAttachment::create([
                    'post_id'       => $post->id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path'     => $path,
                    'file_size'     => $file->getSize(),
                    'mime_type'     => $file->getMimeType(),
                ]);
            }
        }

        // Jika tipe tugas, simpan detail assignment
        if ($validated['type'] === 'assignment') {
            $assignmentDueDate = $validated['assignment_due_date'] 
                              ?? ($validated['due_date'] ?? $request->input('assignment_due_date', $request->input('due_date')));

            ClassroomAssignment::create([
                'post_id'      => $post->id,
                'due_date'     => $assignmentDueDate ?: null,
                'max_score'    => $validated['max_score'] ?? 100,
                'instructions' => $validated['instructions'] ?? null,
            ]);
        }

        // Jika tipe kuis formal, simpan detail classroom_quiz dan buat QuizSet beserta QuizQuestions
        if ($validated['type'] === 'quiz') {
            $quizTitle = $validated['title'] ?? ('Kuis Kelas: ' . $classroom->name);
            $durationMinutes = (int) ($validated['duration_minutes'] ?? 30);

            // 1. Buat Set Kuis untuk bank soal
            $quizSet = \App\Models\QuizSet::create([
                'title'               => $quizTitle,
                'slug'                => \Illuminate\Support\Str::slug($quizTitle . '-' . time()),
                'time_limit_seconds'  => max(1, $durationMinutes) * 60,
                'is_active'           => true,
            ]);

            // 2. Simpan setiap soal pilihan ganda yang diinput pengajar
            $questionsInput = $validated['type'] === 'material' 
                ? $request->input('material_questions', $request->input('questions', []))
                : $request->input('questions', []);

            $checkpointSlide = (int) $request->input('checkpoint_slide', 1);

            if (is_array($questionsInput)) {
                foreach ($questionsInput as $qData) {
                    if (empty($qData['text'])) continue;

                    $optionsRaw    = $qData['options'] ?? [];
                    $correctLetter = $qData['correct'] ?? 'A';
                    
                    // Format options ke array dan cari correct_index (0 untuk A, 1 untuk B, dst)
                    $optionsList = [];
                    $correctIndex = 0;
                    $idx = 0;
                    foreach ($optionsRaw as $letter => $optText) {
                        $optionsList[] = $optText;
                        if ($letter === $correctLetter) {
                            $correctIndex = $idx;
                        }
                        $idx++;
                    }

                    \App\Models\QuizQuestion::create([
                        'quiz_set_id'   => $quizSet->id,
                        'question'      => $qData['text'],
                        'options'       => $optionsList,
                        'correct_index' => $correctIndex,
                        'points'        => 10,
                        'is_active'     => true,
                        'explanation'   => "checkpoint_slide:{$checkpointSlide}",
                    ]);
                }
            }

            // 3. Tautkan post dengan quiz_set_id yang baru dibuat
            $baseInstructions = $request->input('material_instructions') ?: 'Kerjakan pertanyaan checkpoint berikut untuk menguji pemahaman materi yang baru saja dipelajari.';
            $quizDueDate = $validated['quiz_due_date'] 
                        ?? ($validated['due_date'] ?? $request->input('quiz_due_date', $request->input('due_date')));

            \App\Models\ClassroomQuiz::create([
                'post_id'          => $post->id,
                'quiz_set_id'      => $quizSet->id,
                'due_date'         => $validated['type'] === 'material' ? null : ($quizDueDate ?: null),
                'duration_minutes' => $durationMinutes,
                'max_score'        => $validated['max_score'] ?? 100,
                'show_score'       => true,
                'max_attempts'     => $validated['type'] === 'material' ? (int)$request->input('material_max_attempts', 0) : (int)$request->input('max_attempts', 1),
                'instructions'     => $validated['type'] === 'material' ? "{$baseInstructions} [checkpoint_slide:{$checkpointSlide}]" : ($validated['instructions'] ?? null),
            ]);
        }

        $successMsg = match($validated['type']) {
            'material'     => $hasPractice ? 'Materi belajar beserta latihan soal berhasil dipublikasikan!' : 'Materi belajar berhasil dipublikasikan!',
            'assignment'   => 'Tugas berhasil dipublikasikan!',
            'quiz'         => 'Evaluasi / Kuis pilihan ganda berhasil dibuat!',
            'announcement' => 'Pengumuman berhasil dipublikasikan!',
            default        => 'Postingan berhasil dipublikasikan!',
        };

        return redirect()->route('teacher.classroom.show', $classroom)
            ->with('success', $successMsg);
    }

    /** Hapus post */
    public function destroy(Classroom $classroom, ClassroomPost $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $post);

        // Hapus file lampiran dari storage
        foreach ($post->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $post->delete();

        return back()->with('success', 'Postingan berhasil dihapus.');
    }

    /** Ekspor hasil & jawaban kuis siswa ke file Excel / Spreadsheet CSV */
    public function exportQuizAnswersExcel(\App\Models\ClassroomQuiz $quiz)
    {
        \Illuminate\Support\Facades\Gate::authorize('manageResults', $quiz);
        $post      = $quiz->post;
        $classroom = $post?->classroom;

        $filename = 'hasil-kuis-' . \Illuminate\Support\Str::slug($post->title ?? 'kuis') . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($quiz) {
            $out = fopen('php://output', 'w');

            // Header Spreadsheet / Excel
            fputcsv($out, ['Nama Siswa', 'Email Siswa', 'Tanggal Pengerjaan', 'Status', 'Nilai Akhir', 'Status Lulus']);

            // Mengambil hasil percobaan kuis dari database
            $attempts = \App\Models\QuizAttempt::query()
                ->where('quiz_set_id', $quiz->quiz_set_id)
                ->get();

            foreach ($attempts as $attempt) {
                fputcsv($out, [
                    $attempt->player_name ?? 'Siswa',
                    '-',
                    $attempt->taken_at ? $attempt->taken_at->format('d/m/Y H:i') : '-',
                    'Selesai',
                    $attempt->score ?? 0,
                    ($attempt->score >= 70) ? 'LULUS' : 'TIDAK LULUS',
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /** Menampilkan halaman preview hasil pengerjaan kuis siswa untuk pengajar */
    public function previewQuizSubmissions(\App\Models\ClassroomQuiz $quiz)
    {
        \Illuminate\Support\Facades\Gate::authorize('manageResults', $quiz);
        $post      = $quiz->post;
        $classroom = $post?->classroom;

        // Ambil daftar soal pilihan ganda kuis
        $questions = \App\Models\QuizQuestion::query()
            ->where('quiz_set_id', $quiz->quiz_set_id)
            ->where('is_active', true)
            ->get();

        // Ambil seluruh percobaan kuis siswa
        $attempts = \App\Models\QuizAttempt::query()
            ->where('quiz_set_id', $quiz->quiz_set_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.classroom.quiz_preview', compact('quiz', 'post', 'classroom', 'questions', 'attempts'));
    }
}
