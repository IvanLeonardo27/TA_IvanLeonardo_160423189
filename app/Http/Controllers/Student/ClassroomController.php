<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /** Daftar kelas yang diikuti pelajar */
    public function index()
    {
        $classrooms = Classroom::whereHas('members', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with('teacher')
            ->withCount('students')
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('student.classroom.index', compact('classrooms'));
    }

    /** Gabung kelas menggunakan kode */
    public function join(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $classroom = Classroom::where('code', strtoupper(trim($request->code)))
            ->where('status', 'active')
            ->firstOrFail();

        // Cek apakah sudah menjadi anggota atau pengajar
        if ($classroom->teacher_id === Auth::id()) {
            return back()->withErrors(['code' => 'Anda adalah pengajar kelas ini.']);
        }

        $alreadyJoined = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyJoined) {
            return back()->withErrors(['code' => 'Anda sudah bergabung di kelas ini.']);
        }

        ClassroomMember::create([
            'classroom_id' => $classroom->id,
            'user_id'      => Auth::id(),
            'role'         => 'student',
        ]);

        return redirect()->route('student.classroom.show', $classroom)
            ->with('success', "Berhasil bergabung ke kelas: {$classroom->name}!");
    }

    /** Lihat detail kelas beserta stream/feed */
    public function show(Classroom $classroom)
    {
        // Pastikan pelajar adalah anggota kelas ini
        abort_unless(
            ClassroomMember::where('classroom_id', $classroom->id)
                ->where('user_id', Auth::id())
                ->exists(),
            403
        );

        $posts = $classroom->posts()
            ->with([
                'author',
                'attachments',
                'comments' => fn($q) => $q->with('user')->latest(),
                'assignment.mySubmission',
            ])
            ->paginate(10);

        $teacher  = $classroom->teacher;
        $members  = $classroom->students()->take(10)->get();
        $totalMembers = $classroom->students()->count();

        return view('student.classroom.show', compact('classroom', 'posts', 'teacher', 'members', 'totalMembers'));
    }
}
