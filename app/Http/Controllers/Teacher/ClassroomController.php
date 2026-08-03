<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /** Daftar kelas milik pengajar */
    public function index()
    {
        $classrooms = Classroom::where('teacher_id', Auth::id())
            ->withCount('students')
            ->latest()
            ->get();

        return view('teacher.classroom.index', compact('classrooms'));
    }

    /** Form buat kelas baru */
    public function create()
    {
        return view('teacher.classroom.create');
    }

    /** Simpan kelas baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:120',
            'subject'      => 'nullable|string|max:80',
            'description'  => 'nullable|string',
            'banner_color' => 'required|string|max:7',
            'banner_icon'  => 'required|string|max:60',
        ]);

        $classroom = Classroom::create([
            ...$validated,
            'teacher_id' => Auth::id(),
            'code'       => Classroom::generateCode(),
        ]);

        // Catat pengajar yang membuat kelas ke classroom_members sebagai role teacher
        ClassroomMember::create([
            'classroom_id' => $classroom->id,
            'user_id'      => Auth::id(),
            'role'         => 'teacher',
            'joined_at'    => now(),
        ]);

        return redirect()->route('teacher.classroom.show', $classroom)
            ->with('success', 'Kelas berhasil dibuat!');
    }

    /** Detail/manajemen kelas */
    public function show(Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        $posts = $classroom->posts()
            ->with(['author', 'attachments', 'comments.user', 'assignment.submissions', 'quiz'])
            ->paginate(10);

        $students = $classroom->students()->get();
        $members  = $classroom->members()->get();

        return view('teacher.classroom.show', compact('classroom', 'posts', 'students', 'members'));
    }

    /** Form edit kelas */
    public function edit(Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);
        return view('teacher.classroom.edit', compact('classroom'));
    }

    /** Update kelas */
    public function update(Request $request, Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        $validated = $request->validate([
            'name'         => 'required|string|max:120',
            'subject'      => 'nullable|string|max:80',
            'description'  => 'nullable|string',
            'banner_color' => 'required|string|max:7',
            'banner_icon'  => 'required|string|max:60',
            'status'       => 'required|in:active,archived',
        ]);

        $classroom->update($validated);

        return back()->with('success', 'Kelas berhasil diperbarui!');
    }

    /** Hapus kelas */
    public function destroy(Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);
        $classroom->delete();

        return redirect()->route('teacher.classroom.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    /** Hapus anggota dari kelas (Catat out_at) */
    public function removeMember(Classroom $classroom, User $user)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        $member = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->first();

        if ($member) {
            $member->update(['out_at' => now()]);
        }

        return back()->with('success', 'Anggota berhasil dikeluarkan dari kelas.');
    }

    /** Nilai submission siswa */
    public function gradeSubmission(Request $request, \App\Models\ClassroomSubmission $submission)
    {
        $validated = $request->validate([
            'score'            => 'required|integer|min:0|max:' . ($submission->assignment->max_score ?? 100),
            'teacher_feedback' => 'nullable|string',
        ]);

        $submission->update([...$validated, 'status' => 'graded']);

        return back()->with('success', 'Nilai berhasil disimpan!');
    }
}
