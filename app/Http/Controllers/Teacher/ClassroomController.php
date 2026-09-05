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
use Illuminate\Support\Facades\Storage;

class ClassroomController extends Controller
{
    /** Daftar kelas milik pengajar */
    public function index()
    {
        Gate::authorize('teacher');

        $query = Classroom::with('teacher')->withCount('students');

        if (!Auth::user()->isAdmin()) {
            $query->where('teacher_id', Auth::id());
        }

        $classrooms = $query->latest()->get();

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

        \App\Models\ActivityLog::log(
            Auth::user(),
            'Membuat Ruang Kelas',
            'classroom',
            "Membuat kelas baru '{$classroom->name}' dengan kode akses {$classroom->code}.",
            $classroom->name
        );

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

        // Ambil seluruh pelajar terdaftar di sistem yang belum bergabung di kelas ini (atau out_at != null)
        $availableStudents = User::where(function ($q) {
                $q->where('role_id', 3)
                  ->orWhereHas('role', fn($r) => $r->where('name', 'student'));
            })
            ->where('status', 'active')
            ->whereDoesntHave('classroomMemberships', function ($q) use ($classroom) {
                $q->where('classroom_id', $classroom->id)
                  ->whereNull('out_at');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'user_code']);

        // Ambil riwayat pelajar yang telah dikeluarkan (soft-deleted dengan status out_at)
        $formerStudents = $classroom->belongsToMany(User::class, 'classroom_members', 'classroom_id', 'user_id')
            ->wherePivot('role', 'student')
            ->wherePivotNotNull('out_at')
            ->withPivot('joined_at', 'out_at')
            ->orderByPivot('out_at', 'desc')
            ->get();

        return view('teacher.classroom.show', compact('classroom', 'posts', 'students', 'members', 'availableStudents', 'formerStudents'));
    }

    /** Halaman terpisah pengelolaan anggota kelas */
    public function members(Classroom $classroom)
    {
        Gate::authorize('view', $classroom);

        $students = $classroom->students()->get();
        $members  = $classroom->members()->get();

        // Ambil seluruh pelajar terdaftar di sistem yang belum bergabung di kelas ini (atau out_at != null)
        $availableStudents = User::where(function ($q) {
                $q->where('role_id', 3)
                  ->orWhereHas('role', fn($r) => $r->where('name', 'student'));
            })
            ->where('status', 'active')
            ->whereDoesntHave('classroomMemberships', function ($q) use ($classroom) {
                $q->where('classroom_id', $classroom->id)
                  ->whereNull('out_at');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'user_code']);

        // Ambil riwayat pelajar yang telah dikeluarkan (soft-deleted dengan status out_at)
        $formerStudents = $classroom->belongsToMany(User::class, 'classroom_members', 'classroom_id', 'user_id')
            ->wherePivot('role', 'student')
            ->wherePivotNotNull('out_at')
            ->withPivot('joined_at', 'out_at')
            ->orderByPivot('out_at', 'desc')
            ->get();

        return view('teacher.classroom.members', compact('classroom', 'students', 'members', 'availableStudents', 'formerStudents'));
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

        return redirect()->route('teacher.classroom.show', $classroom)->with('success', 'Pengaturan kelas berhasil diperbarui!');
    }

    /** Hapus kelas */
    public function destroy(Classroom $classroom)
    {
        Gate::authorize('delete', $classroom);
        $classroom->delete();

        return redirect()->route('teacher.classroom.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    /** Tambah pelajar terdaftar ke kelas */
    public function addMember(Request $request, Classroom $classroom)
    {
        Gate::authorize('manageMembers', $classroom);

        $request->validate([
            'student_ids'   => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
            'student_id'    => 'nullable|exists:users,id',
        ]);

        $studentIds = $request->input('student_ids', []);
        if ($request->filled('student_id')) {
            $studentIds[] = $request->student_id;
        }
        $studentIds = array_unique(array_filter($studentIds));

        if (empty($studentIds)) {
            return back()->with('error', 'Silakan centang/pilih setidaknya satu pelajar untuk ditambahkan.');
        }

        $addedCount = 0;
        $addedNames = [];

        foreach ($studentIds as $id) {
            $student = User::find($id);
            if (!$student) continue;

            $member = ClassroomMember::where('classroom_id', $classroom->id)
                ->where('user_id', $student->id)
                ->first();

            if ($member) {
                if ($member->out_at !== null) {
                    $member->update([
                        'out_at'    => null,
                        'joined_at' => now(),
                    ]);
                    $addedCount++;
                    $addedNames[] = $student->name;
                }
            } else {
                ClassroomMember::create([
                    'classroom_id' => $classroom->id,
                    'user_id'      => $student->id,
                    'role'         => 'student',
                    'joined_at'    => now(),
                ]);
                $addedCount++;
                $addedNames[] = $student->name;
            }
        }

        if ($addedCount > 0) {
            $namesStr = implode(', ', array_slice($addedNames, 0, 3));
            if (count($addedNames) > 3) {
                $namesStr .= ' lan ' . (count($addedNames) - 3) . ' liyane';
            }

            \App\Models\ActivityLog::log(
                Auth::user(),
                'Menambahkan Siswa ke Kelas',
                'classroom',
                "Menambahkan {$addedCount} siswa ({$namesStr}) ke kelas '{$classroom->name}'.",
                $classroom->name
            );

            return back()->with('success', "Berhasil menambahkan {$addedCount} pelajar ke dalam kelas!");
        }

        return back()->with('info', 'Semua pelajar yang dipilih sudah terdaftar di kelas ini.');
    }

    /** Hapus anggota / Kick pelajar dari kelas (Catat out_at sebagai Soft Delete) */
    public function removeMember(Classroom $classroom, User $user)
    {
        Gate::authorize('manageMembers', $classroom);

        $member = ClassroomMember::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->whereNull('out_at')
            ->first();

        if ($member) {
            $member->update(['out_at' => now()]);

            \App\Models\ActivityLog::log(
                Auth::user(),
                'Mengeluarkan Pelajar dari Kelas',
                'classroom',
                "Mengeluarkan (kick) pelajar '{$user->name}' dari kelas '{$classroom->name}'. Data histori nilai & tugas tetap tersimpan aman (out_at).",
                $classroom->name,
                'fa-solid fa-user-xmark',
                'bg-danger'
            );
        }

        return back()->with('success', "Pelajar {$user->name} berhasil dikeluarkan (di-kick) dari kelas. Seluruh histori nilai dan pengerjaan tetap tersimpan di database (out_at).");
    }

    /** Nilai submission siswa */
    public function gradeSubmission(Request $request, ClassroomSubmission $submission)
    {
        Gate::authorize('grade', $submission->assignment);

        $validated = $request->validate([
            'score'            => 'required|integer|min:0|max:' . ($submission->assignment->max_score ?? 100),
            'teacher_feedback' => 'nullable|string',
        ]);

        $submission->update([
            ...$validated,
            'status'    => 'graded',
            'graded_at' => now(),
        ]);

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

    /** Tambah Minggu (Week) Baru Secara Manual */
    public function addWeek(Request $request, Classroom $classroom)
    {
        Gate::authorize('update', $classroom);

        $customTitles = $classroom->week_titles ?? [];
        $maxCustomWeek = count($customTitles) > 0 ? max(array_keys($customTitles)) : 0;
        $maxPostWeek = $classroom->posts()->max('week_number') ?? 0;
        $currentMax = max(4, $maxCustomWeek, $maxPostWeek);
        $nextWeek = $currentMax + 1;

        $title = $request->input('title');
        $customTitles[$nextWeek] = $title ? trim($title) : "Week {$nextWeek}";

        $classroom->update(['week_titles' => $customTitles]);

        return back()->with('success', "Minggu baru (Week {$nextWeek}) berhasil ditambahkan!");
    }

    /** Hapus Minggu (Week) Beserta Seluruh Isinya Secara Permanen (Tanpa Soft Deletes) */
    public function destroyWeek(Request $request, Classroom $classroom, int $week)
    {
        Gate::authorize('update', $classroom);

        $weekNumber = (int) $week;

        // Ambil seluruh postingan di minggu ini (materi, tugas, kuis, tautan)
        // Termasuk yang mungkin ter-soft-delete jika ada, kita forceDelete
        $postsInWeek = $classroom->posts()->where('week_number', $weekNumber)->withTrashed()->get();

        foreach ($postsInWeek as $post) {
            // Hapus file attachments dari storage public
            foreach ($post->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            // Hapus secara langsung permanen tanpa soft deletes
            $post->forceDelete();
        }

        // Susun ulang week_titles dan shift minggu-minggu berikutnya
        $customTitles = $classroom->week_titles ?? [];
        $newTitles = [];

        foreach ($customTitles as $k => $title) {
            $k = (int) $k;
            if ($k < $weekNumber) {
                $newTitles[$k] = $title;
            } elseif ($k > $weekNumber) {
                // Geser nomor minggu ke bawah
                $newTitles[$k - 1] = $title;
            }
            // $k === $weekNumber dilewati (terhapus)
        }

        // Perbarui nomor minggu postingan yang lebih besar dari $weekNumber agar tetap konsisten
        $classroom->posts()
            ->where('week_number', '>', $weekNumber)
            ->decrement('week_number');

        $classroom->update(['week_titles' => $newTitles]);

        return back()->with('success', "Week {$weekNumber} beserta seluruh materi dan postingan di dalamnya berhasil dihapus secara langsung.");
    }
}
