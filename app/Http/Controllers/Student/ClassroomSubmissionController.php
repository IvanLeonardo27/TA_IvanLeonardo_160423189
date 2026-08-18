<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ClassroomSubmissionController extends Controller
{
    /** Halaman detail tugas + form upload */
    public function show(ClassroomAssignment $assignment)
    {
        Gate::authorize('view', $assignment);

        $classroom = $assignment->post->classroom;
        $submission = ClassroomSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->first();

        return view('student.classroom.submission.show', compact('assignment', 'classroom', 'submission'));
    }

    /** Siswa menyerahkan/upload file tugas */
    public function store(Request $request, ClassroomAssignment $assignment)
    {
        Gate::authorize('submit', $assignment);

        $classroom = $assignment->post->classroom;

        $request->validate([
            'file' => 'required|file|max:20480',
            'note' => 'nullable|string|max:500',
        ]);

        // Hapus submission lama jika ada (ganti file)
        $existing = ClassroomSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existing && $existing->file_path) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $file  = $request->file('file');
        $path  = $file->store("classrooms/{$classroom->id}/submissions/{$assignment->id}", 'public');

        ClassroomSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => Auth::id()],
            [
                'original_name' => $file->getClientOriginalName(),
                'file_path'     => $path,
                'note'          => $request->note,
                'submitted_at'  => now(),
                'status'        => 'submitted',
                'score'         => null,
                'teacher_feedback' => null,
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /** Siswa menarik kembali submission */
    public function destroy(ClassroomAssignment $assignment)
    {
        Gate::authorize('submit', $assignment);

        $submission = ClassroomSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if ($submission->file_path) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return back()->with('success', 'Pengumpulan tugas berhasil dibatalkan.');
    }
}
