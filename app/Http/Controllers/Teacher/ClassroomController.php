<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomController extends Controller
{
    /** Daftar kelas milik pengajar */
    public function index()
    {
        Gate::authorize('teacher');

        $classrooms = Classroom::where('teacher_id', Auth::id())
            ->withCount('students')
            ->latest()
            ->get();

        return view('teacher.classroom.index', compact('classrooms'));
    }

    /** Form buat kelas baru */
    public function create()
    {
        Gate::authorize('create', Classroom::class);
        return view('teacher.classroom.create');
    }

    /** Simpan kelas baru */
    public function store(Request $request)
    {
        Gate::authorize('create', Classroom::class);

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
        Gate::authorize('view', $classroom);

        $posts = $classroom->posts()
            ->with(['author', 'attachments', 'comments.user', 'assignment.submissions.student', 'quiz'])
            ->paginate(10);

        $students = $classroom->students()->get();
        $members  = $classroom->members()->get();

        return view('teacher.classroom.show', compact('classroom', 'posts', 'students', 'members'));
    }

    /** Form edit kelas */
    public function edit(Classroom $classroom)
    {
        Gate::authorize('update', $classroom);
        return view('teacher.classroom.edit', compact('classroom'));
    }

    /** Update kelas */
    public function update(Request $request, Classroom $classroom)
    {
        Gate::authorize('update', $classroom);

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
        Gate::authorize('delete', $classroom);
        $classroom->delete();

        return redirect()->route('teacher.classroom.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    /** Hapus anggota dari kelas (Catat out_at) */
    public function removeMember(Classroom $classroom, User $user)
    {
        Gate::authorize('manageMembers', $classroom);

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
    public function gradeSubmission(Request $request, ClassroomSubmission $submission)
    {
        Gate::authorize('grade', $submission->assignment);

        $validated = $request->validate([
            'score'            => 'required|integer|min:0|max:' . ($submission->assignment->max_score ?? 100),
            'teacher_feedback' => 'nullable|string',
        ]);

        $submission->update([...$validated, 'status' => 'graded']);

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    /** Halaman khusus membaca/pratinjau materi presentasi PDF untuk guru */
    public function showMaterial(Classroom $classroom, ClassroomPost $post)
    {
        Gate::authorize('view', $classroom);
        abort_if($post->classroom_id !== $classroom->id, 404);
        abort_if($post->type !== 'material', 404);

        $post->load(['author', 'attachments', 'comments.user']);

        return view('teacher.classroom.material.show', compact('classroom', 'post'));
    }

    /** Update judul header minggu/section */
    public function updateWeekTitle(Request $request, Classroom $classroom)
    {
        Gate::authorize('update', $classroom);

        $request->validate([
            'week_number' => 'required|integer|min:0|max:52',
            'title'       => 'nullable|string|max:150',
        ]);

        $weekNumber = (int) $request->week_number;
        $title = trim($request->title);

        $weekTitles = $classroom->week_titles ?? [];
        if (empty($title)) {
            unset($weekTitles[$weekNumber]);
        } else {
            $weekTitles[$weekNumber] = $title;
        }

        $classroom->update(['week_titles' => $weekTitles]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'week_number' => $weekNumber,
                'title' => $classroom->getWeekTitle($weekNumber),
            ]);
        }

        return back()->with('success', 'Judul minggu berhasil diperbarui!');
    }
}
