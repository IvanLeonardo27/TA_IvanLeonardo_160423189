<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomPost;
use App\Models\ClassroomQuiz;
use App\Models\ClassroomSubmission;
use App\Models\JavaneseScriptDetail;
use App\Models\MacapatDetail;
use App\Models\QuizAttempt;
use App\Models\Role;
use App\Models\User;
use App\Models\Vocabulary;
use App\Models\WayangCharacter;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $roleTeacher = Role::where('name', 'teacher')->first();
        $roleStudent = Role::where('name', 'student')->first();

        $stats = [
            'total_teachers'     => $roleTeacher ? User::where('role_id', $roleTeacher->id)->count() : 0,
            'active_teachers'    => $roleTeacher ? User::where('role_id', $roleTeacher->id)->where('status', 'active')->count() : 0,
            'total_students'     => $roleStudent ? User::where('role_id', $roleStudent->id)->count() : 0,
            'active_students'    => $roleStudent ? User::where('role_id', $roleStudent->id)->where('status', 'active')->count() : 0,
            'total_classrooms'   => Classroom::count(),
            'active_classrooms'  => Classroom::where('status', 'active')->count(),
            'total_materials'    => WayangCharacter::count() + MacapatDetail::count() + JavaneseScriptDetail::count() + ClassroomPost::where('type', 'material')->count(),
            'total_submissions'  => ClassroomSubmission::count(),
            'total_quiz_attempts'=> QuizAttempt::count(),
            'total_vocabularies' => Vocabulary::count(),
        ];


        $latestTeachers = $roleTeacher 
            ? User::where('role_id', $roleTeacher->id)->with('teacherProfile')->latest()->take(5)->get()
            : collect();

        $latestStudents = $roleStudent
            ? User::where('role_id', $roleStudent->id)->with('studentProfile')->latest()->take(5)->get()
            : collect();

        $latestClassrooms = Classroom::with('teacher')->withCount('students')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestTeachers', 'latestStudents', 'latestClassrooms'));
    }
}
