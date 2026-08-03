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
        abort_if($classroom->teacher_id !== Auth::id(), 403);
        return view('teacher.classroom.post.create', compact('classroom'));
    }

    /** Simpan post baru */
    public function store(Request $request, Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        $validated = $request->validate([
            'type'             => 'required|in:announcement,material,assignment,quiz',
            'title'            => 'nullable|string|max:200',
            'body'             => 'nullable|string',
            'is_pinned'        => 'boolean',
            'files.*'          => 'nullable|file|max:20480', // 20MB per file
            // Assignment / Quiz fields
            'due_date'         => 'nullable|date|after:now',
            'duration_minutes' => 'nullable|integer|min:1|max:300',
            'max_score'        => 'nullable|integer|min:0|max:1000',
            'show_score'       => 'nullable|boolean',
            'max_attempts'     => 'nullable|integer|in:0,1',
            'instructions'     => 'nullable|string',
        ]);

        $post = ClassroomPost::create([
            'classroom_id' => $classroom->id,
            'author_id'    => Auth::id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'] ?? null,
            'body'         => $validated['body'] ?? null,
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
            ClassroomAssignment::create([
                'post_id'      => $post->id,
                'due_date'     => $validated['due_date'] ?? null,
                'max_score'    => $validated['max_score'] ?? 100,
                'instructions' => $validated['instructions'] ?? null,
            ]);
        }

        // Jika tipe kuis, simpan detail classroom_quiz dan buat QuizSet beserta QuizQuestions (Pilihan Ganda)
        if ($validated['type'] === 'quiz') {
            // 1. Buat Set Kuis untuk bank soal
            $quizSet = \App\Models\QuizSet::create([
                'title'               => $validated['title'] ?? 'Kuis Kelas: ' . $classroom->name,
                'slug'                => \Illuminate\Support\Str::slug(($validated['title'] ?? 'kuis') . '-' . time()),
                'time_limit_seconds'  => ($validated['duration_minutes'] ?? 30) * 60,
                'is_active'           => true,
            ]);

            // 2. Simpan setiap soal pilihan ganda yang diinput pengajar
            if ($request->has('questions') && is_array($request->input('questions'))) {
                foreach ($request->input('questions') as $qData) {
                    if (empty($qData['text'])) continue;

                    $optionsRaw   = $qData['options'] ?? [];
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
                    ]);
                }
            }

            // 3. Tautkan post kuis dengan quiz_set_id yang baru dibuat
            \App\Models\ClassroomQuiz::create([
                'post_id'          => $post->id,
                'quiz_set_id'      => $quizSet->id,
                'due_date'         => $validated['due_date'] ?? null,
                'duration_minutes' => $validated['duration_minutes'] ?? 30,
                'max_score'        => $validated['max_score'] ?? 100,
                'show_score'       => $request->boolean('show_score', true),
                'max_attempts'     => $request->input('max_attempts', 1),
                'instructions'     => $validated['instructions'] ?? null,
            ]);
        }

        return redirect()->route('teacher.classroom.show', $classroom)
            ->with('success', 'Kuis pilihan ganda berhasil dibuat!');
    }

    /** Hapus post */
    public function destroy(Classroom $classroom, ClassroomPost $post)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

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
        $post      = $quiz->post;
        $classroom = $post?->classroom;
        abort_if(!$classroom || $classroom->teacher_id !== Auth::id(), 403);

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
        $post      = $quiz->post;
        $classroom = $post?->classroom;
        abort_if(!$classroom || $classroom->teacher_id !== Auth::id(), 403);

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
