<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomController extends Controller
{
    /** Daftar kelas yang diikuti pelajar beserta statistik dashboard */
    public function index()
    {
        Gate::authorize('student');

        $classrooms = Classroom::whereHas('members', function ($q) {
                $q->where('user_id', Auth::id())
                  ->whereNull('out_at');
            })
            ->with('teacher')
            ->withCount('students')
            ->where('status', 'active')
            ->latest()
            ->get();

        $classroomIds = $classrooms->pluck('id');

        // Statistik Cepat untuk Dashboard Terpadu Pelajar
        $totalClassrooms = $classrooms->count();
        $totalBookmarks = \App\Models\Bookmark::where('user_id', Auth::id())->count();
        
        // Tugas aktif yang belum dikumpulkan
        $activeAssignmentsCount = \App\Models\ClassroomAssignment::whereHas('post', function($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds)->where('is_published', true);
            })
            ->where(function($q) {
                $q->whereNull('due_date')->orWhere('due_date', '>=', now());
            })
            ->whereDoesntHave('submissions', function($q) {
                $q->where('student_id', Auth::id());
            })
            ->count();

        // Kuis aktif yang belum dikerjakan
        $activeQuizzesCount = \App\Models\ClassroomQuiz::whereHas('post', function($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds)->where('is_published', true);
            })
            ->where(function($q) {
                $q->whereNull('due_date')->orWhere('due_date', '>=', now());
            })
            ->whereDoesntHave('attempts', function($q) {
                $q->where(function($sub) {
                    $sub->where('student_id', Auth::id())
                        ->orWhere('user_id', Auth::id());
                });
            })
            ->count();


        return view('student.classroom.index', compact(
            'classrooms',
            'totalClassrooms',
            'totalBookmarks',
            'activeAssignmentsCount',
            'activeQuizzesCount'
        ));
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

        Gate::authorize('join', $classroom);

        ClassroomMember::create([
            'classroom_id' => $classroom->id,
            'user_id'      => Auth::id(),
            'role'         => 'student',
            'joined_at'    => now(),
            'out_at'       => null,
        ]);

        \App\Models\ActivityLog::log(
            Auth::user(),
            'Bergabung ke Kelas',
            'classroom',
            "Bergabung ke ruang kelas '{$classroom->name}'.",
            $classroom->name,
            'fa-solid fa-right-to-bracket',
            'bg-info'
        );

        return redirect()->route('student.classroom.show', $classroom)
            ->with('success', "Berhasil bergabung ke kelas: {$classroom->name}!");
    }

    /** Lihat detail kelas beserta stream/feed */
    public function show(Classroom $classroom)
    {
        Gate::authorize('view', $classroom);

        $posts = $classroom->posts()
            ->published()
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
    public function showMaterial(Classroom $classroom, ClassroomPost $post)
    {
        Gate::authorize('view', $classroom);

        abort_if($post->classroom_id !== $classroom->id, 404);
        abort_if($post->type !== 'material', 404);

        $post->load(['author', 'attachments', 'comments.user']);

        return view('student.classroom.material.show', compact('classroom', 'post'));
    }
}
