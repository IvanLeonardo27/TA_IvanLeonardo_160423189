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
                $q->where('user_id', Auth::id())
                  ->whereNull('out_at');
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
            ->first();

        if (!$classroom) {
            return back()->withErrors(['code' => 'Kode kelas tidak ditemukan atau tidak aktif.']);
        }

        // Cek apakah sudah menjadi anggota pengajar atau aktif
        if ($classroom->teacher_id === Auth::id()) {
            return back()->withErrors(['code' => 'Anda adalah pengajar kelas ini.']);
        }

        $activeMember = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', Auth::id())
            ->whereNull('out_at')
            ->first();

        if ($activeMember) {
            return back()->withErrors(['code' => 'Anda sudah bergabung di kelas ini.']);
        }

        // Jika pernah keluar dan gabung kembali, buat record baru dengan joined_at terbaru
        ClassroomMember::create([
            'classroom_id' => $classroom->id,
            'user_id'      => Auth::id(),
            'role'         => 'student',
            'joined_at'    => now(),
            'out_at'       => null,
        ]);

        return redirect()->route('student.classroom.show', $classroom)
            ->with('success', "Berhasil bergabung ke kelas: {$classroom->name}!");
    }

    /** Lihat detail kelas beserta stream/feed */
    public function show(Classroom $classroom)
    {
        // Pastikan pelajar adalah anggota aktif kelas ini
        abort_unless(
            ClassroomMember::where('classroom_id', $classroom->id)
                ->where('user_id', Auth::id())
                ->whereNull('out_at')
                ->exists(),
            403
        );

        $posts = $classroom->posts()
            ->with([
                'author',
                'attachments',
                'comments' => fn($q) => $q->with('user')->latest(),
                'assignment.mySubmission',
                'quiz.quizSet',
            ])
            ->paginate(10);

        $teacher  = $classroom->teacher;
        $members  = $classroom->students()->take(10)->get();
        $totalMembers = $classroom->students()->count();

        return view('student.classroom.show', compact('classroom', 'posts', 'teacher', 'members', 'totalMembers'));
    }

    /** Halaman khusus membaca materi presentasi / PDF (Coursera style) */
    public function showMaterial(Classroom $classroom, \App\Models\ClassroomPost $post)
    {
        // Pastikan pelajar adalah anggota aktif kelas
        abort_unless(
            ClassroomMember::where('classroom_id', $classroom->id)
                ->where('user_id', Auth::id())
                ->whereNull('out_at')
                ->exists(),
            403
        );

        abort_if($post->classroom_id !== $classroom->id, 404);
        abort_if($post->type !== 'material', 404);

        $post->load(['author', 'attachments', 'comments.user']);

        return view('student.classroom.material.show', compact('classroom', 'post'));
    }
}
