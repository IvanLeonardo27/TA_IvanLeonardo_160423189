<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Classroom;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use App\Models\ClassroomSubmission;
use App\Models\QuizAttempt;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman Profil Pengguna.
     */
    public function edit(Request $request): View
    {
        $user = ($request->user() ?: Auth::user())->load(['role', 'teacherProfile', 'studentProfile']);
        $stats = [];

        if ($user->isTeacher()) {
            $classrooms = Classroom::where('teacher_id', $user->id)->get();
            $classroomIds = $classrooms->pluck('id')->toArray();
            
            $stats = [
                'total_classrooms'   => $classrooms->count(),
                'total_posts'        => ClassroomPost::whereIn('classroom_id', $classroomIds)->count(),
                'total_materials'    => ClassroomPost::whereIn('classroom_id', $classroomIds)->where('type', 'material')->count(),
                'total_assignments'  => ClassroomPost::whereIn('classroom_id', $classroomIds)->where('type', 'assignment')->count(),
                'total_quizzes'      => ClassroomPost::whereIn('classroom_id', $classroomIds)->where('type', 'quiz')->count(),
                'total_students'     => ClassroomMember::whereIn('classroom_id', $classroomIds)->where('role', 'student')->whereNull('out_at')->distinct('user_id')->count('user_id'),
            ];
        } elseif ($user->isAdmin()) {
            $stats = [
                'total_users'        => User::count(),
                'total_teachers'     => User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count(),
                'total_students'     => User::whereHas('role', fn($q) => $q->where('name', 'student'))->count(),
                'total_classrooms'   => Classroom::count(),
            ];
        } else {
            // Student
            $joinedClassrooms = Classroom::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNull('out_at');
            })->get();

            $stats = [
                'total_classrooms'   => $joinedClassrooms->count(),
                'total_submissions'  => ClassroomSubmission::where('student_id', $user->id)->count(),
                'graded_submissions' => ClassroomSubmission::where('student_id', $user->id)->whereNotNull('graded_at')->count(),
                'total_attempts'     => QuizAttempt::where('user_id', $user->id)->count(),
            ];
        }

        return view('profile.edit', compact('user', 'stats'));
    }

    /**
     * Perbarui data profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->fill([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->save();

        // Update profil sesuai role
        if ($user->isTeacher()) {
            TeacherProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip'                    => $validated['nip'] ?? null,
                    'institution_name'       => $validated['institution_name'] ?? null,
                    'subject_specialization' => $validated['subject_specialization'] ?? null,
                    'phone_number'           => $validated['phone_number'] ?? null,
                ]
            );
        } elseif ($user->studentProfile || !$user->isAdmin()) {
            StudentProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nisn'         => $validated['nisn'] ?? null,
                    'school_name'  => $validated['school_name'] ?? null,
                    'grade_level'  => $validated['grade_level'] ?? null,
                    'phone_number' => $validated['phone_number'] ?? null,
                ]
            );
        }

        return Redirect::route('profile.edit')->with('success', 'Informasi profil berhasil diperbarui!');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
