<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * ==========================================
     * MANAJEMEN PENGAJAR (TEACHER MANAGEMENT)
     * ==========================================
     */

    /** Tampilkan daftar seluruh pengajar */
    public function indexTeachers(Request $request)
    {
        Gate::authorize('admin');

        $roleTeacher = Role::where('name', 'teacher')->firstOrFail();

        $query = User::where('role_id', $roleTeacher->id)
            ->with(['teacherProfile'])
            ->withCount(['classrooms']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('user_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->latest()->paginate(10)->withQueryString();
        $totalTeachers = User::where('role_id', $roleTeacher->id)->count();
        $activeTeachers = User::where('role_id', $roleTeacher->id)->where('status', 'active')->count();

        return view('admin.users.teachers.index', compact('teachers', 'totalTeachers', 'activeTeachers'));
    }

    /** Form tambah pengajar baru */
    public function createTeacher()
    {
        Gate::authorize('admin');

        $previewCode = User::generateUserCode('teacher');

        return view('admin.users.teachers.create', compact('previewCode'));
    }

    /** Simpan akun pengajar baru */
    public function storeTeacher(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'name'                   => 'required|string|max:120',
            'email'                  => 'required|string|email|max:150|unique:users,email',
            'password'               => 'required|string|min:6',
            'nip'                    => 'nullable|string|max:50',
            'institution_name'       => 'nullable|string|max:120',
            'subject_specialization' => 'nullable|string|max:100',
            'phone_number'           => 'nullable|string|max:25',
            'status'                 => 'required|in:active,inactive',
        ]);

        $roleTeacher = Role::where('name', 'teacher')->firstOrFail();
        $userCode = User::generateUserCode('teacher');

        $user = User::create([
            'role_id'   => $roleTeacher->id,
            'user_code' => $userCode,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'status'    => $request->status,
        ]);

        // Buat profil pengajar
        TeacherProfile::create([
            'user_id'                => $user->id,
            'nip'                    => $request->nip,
            'institution_name'       => $request->institution_name,
            'subject_specialization' => $request->subject_specialization,
            'phone_number'           => $request->phone_number,
        ]);

        return redirect()->route('admin.users.teachers.index')
            ->with('success', "Akun Pengajar berhasil dibuat dengan Kode: {$userCode}!");
    }

    /** Form edit pengajar */
    public function editTeacher(User $user)
    {
        Gate::authorize('admin');

        $user->load('teacherProfile');

        return view('admin.users.teachers.edit', compact('user'));
    }

    /** Update akun pengajar */
    public function updateTeacher(Request $request, User $user)
    {
        Gate::authorize('admin');

        $request->validate([
            'name'                   => 'required|string|max:120',
            'email'                  => ['required', 'string', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'password'               => 'nullable|string|min:6',
            'nip'                    => 'nullable|string|max:50',
            'institution_name'       => 'nullable|string|max:120',
            'subject_specialization' => 'nullable|string|max:100',
            'phone_number'           => 'nullable|string|max:25',
            'status'                 => 'required|in:active,inactive',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        TeacherProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip'                    => $request->nip,
                'institution_name'       => $request->institution_name,
                'subject_specialization' => $request->subject_specialization,
                'phone_number'           => $request->phone_number,
            ]
        );

        return redirect()->route('admin.users.teachers.index')
            ->with('success', "Data Pengajar {$user->name} ({$user->user_code}) berhasil diperbarui!");
    }

    /** Hapus pengajar */
    public function destroyTeacher(User $user)
    {
        Gate::authorize('admin');

        $name = $user->name;
        $code = $user->user_code;
        $user->delete();

        return back()->with('success', "Akun Pengajar {$name} ({$code}) berhasil dihapus.");
    }


    /**
     * ==========================================
     * MANAJEMEN PELAJAR (STUDENT MANAGEMENT)
     * ==========================================
     */

    /** Tampilkan daftar seluruh pelajar */
    public function indexStudents(Request $request)
    {
        Gate::authorize('admin');

        $roleStudent = Role::where('name', 'student')->firstOrFail();

        $query = User::where('role_id', $roleStudent->id)
            ->with(['studentProfile'])
            ->withCount(['classroomMemberships as joined_classes_count' => fn($q) => $q->whereNull('out_at')]);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('user_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $totalStudents = User::where('role_id', $roleStudent->id)->count();
        $activeStudents = User::where('role_id', $roleStudent->id)->where('status', 'active')->count();

        return view('admin.users.students.index', compact('students', 'totalStudents', 'activeStudents'));
    }

    /** Form tambah pelajar baru */
    public function createStudent()
    {
        Gate::authorize('admin');

        $previewCode = User::generateUserCode('student');

        return view('admin.users.students.create', compact('previewCode'));
    }

    /** Simpan akun pelajar baru */
    public function storeStudent(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'name'         => 'required|string|max:120',
            'email'        => 'required|string|email|max:150|unique:users,email',
            'password'     => 'required|string|min:6',
            'nisn'         => 'nullable|string|max:50',
            'school_name'  => 'nullable|string|max:120',
            'grade_level'  => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:25',
            'status'       => 'required|in:active,inactive',
        ]);

        $roleStudent = Role::where('name', 'student')->firstOrFail();
        $userCode = User::generateUserCode('student');

        $user = User::create([
            'role_id'   => $roleStudent->id,
            'user_code' => $userCode,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'status'    => $request->status,
        ]);

        // Buat profil pelajar
        StudentProfile::create([
            'user_id'      => $user->id,
            'nisn'         => $request->nisn,
            'school_name'  => $request->school_name,
            'grade_level'  => $request->grade_level,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.users.students.index')
            ->with('success', "Akun Pelajar berhasil dibuat dengan Kode: {$userCode}!");
    }

    /** Form edit pelajar */
    public function editStudent(User $user)
    {
        Gate::authorize('admin');

        $user->load('studentProfile');

        return view('admin.users.students.edit', compact('user'));
    }

    /** Update akun pelajar */
    public function updateStudent(Request $request, User $user)
    {
        Gate::authorize('admin');

        $request->validate([
            'name'         => 'required|string|max:120',
            'email'        => ['required', 'string', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'password'     => 'nullable|string|min:6',
            'nisn'         => 'nullable|string|max:50',
            'school_name'  => 'nullable|string|max:120',
            'grade_level'  => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:25',
            'status'       => 'required|in:active,inactive',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nisn'         => $request->nisn,
                'school_name'  => $request->school_name,
                'grade_level'  => $request->grade_level,
                'phone_number' => $request->phone_number,
            ]
        );

        return redirect()->route('admin.users.students.index')
            ->with('success', "Data Pelajar {$user->name} ({$user->user_code}) berhasil diperbarui!");
    }

    /** Hapus pelajar */
    public function destroyStudent(User $user)
    {
        Gate::authorize('admin');

        $name = $user->name;
        $code = $user->user_code;
        $user->delete();

        return back()->with('success', "Akun Pelajar {$name} ({$code}) berhasil dihapus.");
    }

    /** Toggle status aktif / nonaktif */
    public function toggleStatus(User $user)
    {
        Gate::authorize('admin');

        $newStatus = ($user->status === 'active') ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $label = ($newStatus === 'active') ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Status akun {$user->name} ({$user->user_code}) berhasil {$label}.");
    }
}
