<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminVocabCsvController;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\CustomerQuizAttemptController;
use App\Http\Controllers\CustomerTranslateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomCommentController;
use App\Http\Controllers\Teacher\ClassroomController as TeacherClassroomController;
use App\Http\Controllers\Teacher\ClassroomPostController as TeacherClassroomPostController;
use App\Http\Controllers\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Student\ClassroomSubmissionController as StudentClassroomSubmissionController;
use Illuminate\Support\Facades\Route;

// Redirect root to student dashboard view/route for testing
Route::get('/', function() { return view('student.dashboard'); });

// --- Rute Test UI Baru ---
Route::get('/ui/login', function() { return view('auth.login'); });
Route::get('/ui/register', function() { return view('auth.register'); });
Route::get('/ui/student', function() { return view('student.dashboard'); });
Route::get('/ui/teacher', function() { return view('teacher.dashboard'); });
Route::get('/ui/materi', function() { return view('student.materi.index'); });
Route::get('/ui/materi/show', function() { return view('student.materi.show'); });
Route::get('/ui/kosakata', function() { return view('student.kosakata.index'); });
Route::get('/ui/kosakata/show', function() { return view('student.kosakata.show'); });
Route::get('/ui/translator', function() { return view('student.translator.index'); });
Route::get('/ui/quiz', function() { return view('student.quiz.index'); });
Route::get('/ui/quiz/show', function() { return view('student.quiz.show'); });
Route::get('/ui/teacher/kelas', function() { return view('teacher.classroom.index', ['classrooms' => collect()]); });
Route::get('/ui/teacher/kelas/create', function() { return view('teacher.classroom.create'); });
Route::get('/ui/teacher/kelas/show', function() { return view('teacher.classroom.show', ['classroom' => new \App\Models\Classroom(['name' => 'Bahasa Jawa - Kelas 5A', 'code' => 'JW5A-26', 'banner_color' => '#1F4D3A', 'banner_icon' => 'graduation-cap']), 'posts' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10), 'students' => collect(), 'members' => collect()]); });
Route::get('/ui/student/kelas', function() { return view('student.classroom.index', ['classrooms' => collect()]); });
Route::get('/ui/student/kelas/show', function() { return view('student.classroom.show', ['classroom' => new \App\Models\Classroom(['name' => 'Bahasa Jawa - Kelas 5A', 'banner_color' => '#1F4D3A', 'banner_icon' => 'graduation-cap']), 'posts' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10), 'teacher' => new \App\Models\User(['name' => 'Pak Guru']), 'members' => collect(), 'totalMembers' => 0]); });
Route::get('/ui/student/kelas/submission', function() { return view('student.classroom.submission.show', ['classroom' => new \App\Models\Classroom(['name' => 'Bahasa Jawa - Kelas 5A']), 'assignment' => new \App\Models\ClassroomAssignment(['post' => new \App\Models\ClassroomPost(['title' => 'Tugas: Mengarang Bebas']), 'max_score' => 100]), 'submission' => null]); });
// -------------------------

// Rute Komentar Kelas
Route::middleware('auth')->group(function () {
    Route::post('/classroom/posts/{post}/comments', [ClassroomCommentController::class, 'store'])->name('classroom.comment.store');
    Route::delete('/classroom/comments/{comment}', [ClassroomCommentController::class, 'destroy'])->name('classroom.comment.destroy');
});

// Rute Kelas untuk Pengajar (Teacher)
Route::middleware(['auth'])->prefix('teacher/classroom')->name('teacher.classroom.')->group(function () {
    Route::get('/', [TeacherClassroomController::class, 'index'])->name('index');
    Route::get('/create', [TeacherClassroomController::class, 'create'])->name('create');
    Route::post('/', [TeacherClassroomController::class, 'store'])->name('store');
    Route::get('/{classroom}', [TeacherClassroomController::class, 'show'])->name('show');
    Route::get('/{classroom}/edit', [TeacherClassroomController::class, 'edit'])->name('edit');
    Route::put('/{classroom}', [TeacherClassroomController::class, 'update'])->name('update');
    Route::delete('/{classroom}', [TeacherClassroomController::class, 'destroy'])->name('destroy');
    Route::delete('/{classroom}/members/{user}', [TeacherClassroomController::class, 'removeMember'])->name('member.remove');
    Route::post('/submissions/{submission}/grade', [TeacherClassroomController::class, 'gradeSubmission'])->name('submission.grade');

    // Post & Assignments
    Route::get('/{classroom}/posts/create', [TeacherClassroomPostController::class, 'create'])->name('post.create');
    Route::post('/{classroom}/posts', [TeacherClassroomPostController::class, 'store'])->name('post.store');
    Route::delete('/{classroom}/posts/{post}', [TeacherClassroomPostController::class, 'destroy'])->name('post.destroy');
});

// Rute Kelas untuk Pelajar (Student)
Route::middleware(['auth'])->prefix('student/classroom')->name('student.classroom.')->group(function () {
    Route::get('/', [StudentClassroomController::class, 'index'])->name('index');
    Route::post('/join', [StudentClassroomController::class, 'join'])->name('join');
    Route::get('/{classroom}', [StudentClassroomController::class, 'show'])->name('show');

    // Submissions / Upload Tugas
    Route::get('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'show'])->name('submission.show');
    Route::post('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'store'])->name('submission.store');
    Route::delete('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'destroy'])->name('submission.destroy');
});

Route::post('/translate', CustomerTranslateController::class)->name('customer.translate');
Route::post('/quiz/attempt', CustomerQuizAttemptController::class)->name('customer.quiz.attempt');

// Optional: keep Laravel welcome page accessible.
Route::view('/welcome', 'welcome')->name('welcome');

Route::get('/dashboard', function () {
    return redirect('/ui/student');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminPageController::class, 'index'])->name('admin.home');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('/kosakata', [AdminPageController::class, 'storeVocab'])->name('vocab.store');
        Route::put('/kosakata/{vocabWord}', [AdminPageController::class, 'updateVocab'])->name('vocab.update');
        Route::delete('/kosakata/{vocabWord}', [AdminPageController::class, 'destroyVocab'])->name('vocab.destroy');

        Route::get('/kosakata/export', [AdminVocabCsvController::class, 'export'])->name('vocab.export');
        Route::post('/kosakata/import', [AdminVocabCsvController::class, 'import'])->name('vocab.import');
    });
});

require __DIR__ . '/auth.php';
