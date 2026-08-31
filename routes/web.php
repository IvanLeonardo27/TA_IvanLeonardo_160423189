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
use App\Http\Controllers\TtsProxyController;
use Illuminate\Support\Facades\Route;

// Rute Utama: mengarahkan sesuai autentikasi dan peran
Route::get('/', function() {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isTeacher()) {
            return redirect()->route('teacher.classroom.index');
        }
        return redirect()->route('student.classroom.index');
    }
    return redirect()->route('login');
})->name('home');

// --- Rute Test UI Baru ---
Route::get('/ui/login', function() { return view('auth.login'); });
Route::get('/ui/register', function() { return view('auth.register'); });
Route::get('/ui/student', function() { return view('student.dashboard'); });
Route::get('/ui/teacher', function() { return view('teacher.dashboard'); });
Route::get('/ui/materi', function() { return view('student.materi.index'); });
Route::get('/ui/materi/show', function() { return view('student.materi.show'); });
Route::get('/ui/kosakata/kategori', [\App\Http\Controllers\VocabularyController::class, 'categories'])->name('kosakata.categories');
Route::get('/ui/kosakata/kategori/{category}', [\App\Http\Controllers\VocabularyController::class, 'index'])->name('kosakata.category.show');
Route::get('/ui/kosakata', [\App\Http\Controllers\VocabularyController::class, 'index'])->name('kosakata.index');
Route::post('/ui/kosakata', [\App\Http\Controllers\VocabularyController::class, 'store'])->name('kosakata.store');
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
Route::get('/api/tts', [TtsProxyController::class, 'speak'])->name('api.tts');
// -------------------------

// Rute Komentar, Kalender Pembelajaran, & Bookmark
Route::middleware('auth')->group(function () {
    Route::post('/classroom/posts/{post}/comments', [ClassroomCommentController::class, 'store'])->name('classroom.comment.store');
    Route::delete('/classroom/comments/{comment}', [ClassroomCommentController::class, 'destroy'])->name('classroom.comment.destroy');
    Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/export-ics', [\App\Http\Controllers\CalendarController::class, 'exportIcs'])->name('calendar.export_ics');
    
    // Bookmark Materi
    Route::post('/student/bookmarks/toggle', [\App\Http\Controllers\Student\BookmarkController::class, 'toggle'])->name('student.bookmarks.toggle');
    Route::get('/student/bookmarks', [\App\Http\Controllers\Student\BookmarkController::class, 'index'])->name('student.bookmarks.index');
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
    Route::post('/{classroom}/weeks/title', [TeacherClassroomController::class, 'updateWeekTitle'])->name('week.title.update');
    Route::delete('/{classroom}/members/{user}', [TeacherClassroomController::class, 'removeMember'])->name('member.remove');
    Route::post('/submissions/{submission}/grade', [TeacherClassroomController::class, 'gradeSubmission'])->name('submission.grade');

    // Post & Assignments & Quiz Export / Preview
    Route::get('/{classroom}/posts/create', [TeacherClassroomPostController::class, 'create'])->name('post.create');
    Route::post('/{classroom}/posts', [TeacherClassroomPostController::class, 'store'])->name('post.store');
    Route::delete('/{classroom}/posts/{post}', [TeacherClassroomPostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/{post}/toggle-visibility', [TeacherClassroomPostController::class, 'toggleVisibility'])->name('post.toggle_visibility');
    Route::get('/{classroom}/material/{post}', [TeacherClassroomController::class, 'showMaterial'])->name('material.show');
    Route::get('/quizzes/{quiz}/export-excel', [TeacherClassroomPostController::class, 'exportQuizAnswersExcel'])->name('quiz.export_excel');
    Route::get('/quizzes/{quiz}/preview', [TeacherClassroomPostController::class, 'previewQuizSubmissions'])->name('quiz.preview_submissions');
});

// Rute Kelas untuk Pelajar (Student)
Route::middleware(['auth'])->prefix('student/classroom')->name('student.classroom.')->group(function () {
    Route::get('/', [StudentClassroomController::class, 'index'])->name('index');
    Route::post('/join', [StudentClassroomController::class, 'join'])->name('join');
    Route::get('/{classroom}', [StudentClassroomController::class, 'show'])->name('show');
    Route::get('/{classroom}/material/{post}', [StudentClassroomController::class, 'showMaterial'])->name('material.show');

    // Submissions / Upload Tugas
    Route::get('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'show'])->name('submission.show');
    Route::post('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'store'])->name('submission.store');
    Route::delete('/assignments/{assignment}', [StudentClassroomSubmissionController::class, 'destroy'])->name('submission.destroy');

    // Evaluasi / Quiz Kelas
    Route::get('/quizzes/{quiz}', [\App\Http\Controllers\Student\ClassroomQuizController::class, 'show'])->name('quiz.show');
    Route::post('/quizzes/{quiz}', [\App\Http\Controllers\Student\ClassroomQuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quizzes/{quiz}/result/{attempt?}', [\App\Http\Controllers\Student\ClassroomQuizController::class, 'result'])->name('quiz.result');
});

// Rute Materi Pembelajaran untuk Pengajar (Teacher)
Route::middleware(['auth'])->prefix('teacher/materials')->name('teacher.materials.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\MaterialController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Teacher\MaterialController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Teacher\MaterialController::class, 'store'])->name('store');
    Route::get('/{material}', [\App\Http\Controllers\Teacher\MaterialController::class, 'show'])->name('show');
    Route::get('/{material}/edit', [\App\Http\Controllers\Teacher\MaterialController::class, 'edit'])->name('edit');
    Route::put('/{material}', [\App\Http\Controllers\Teacher\MaterialController::class, 'update'])->name('update');
    Route::delete('/{material}', [\App\Http\Controllers\Teacher\MaterialController::class, 'destroy'])->name('destroy');
});

// Rute Materi Pembelajaran untuk Pelajar (Student)
Route::middleware(['auth'])->prefix('student/materials')->name('student.materials.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\MaterialController::class, 'index'])->name('index');
    Route::get('/{material}', [\App\Http\Controllers\Student\MaterialController::class, 'show'])->name('show');
});

// Rute Tembang Macapat untuk Pengajar (Teacher)
Route::middleware(['auth'])->prefix('teacher/macapat')->name('teacher.macapat.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\MacapatController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Teacher\MacapatController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Teacher\MacapatController::class, 'store'])->name('store');
    Route::get('/{macapat}', [\App\Http\Controllers\Teacher\MacapatController::class, 'show'])->name('show');
    Route::get('/{macapat}/edit', [\App\Http\Controllers\Teacher\MacapatController::class, 'edit'])->name('edit');
    Route::put('/{macapat}', [\App\Http\Controllers\Teacher\MacapatController::class, 'update'])->name('update');
    Route::delete('/{macapat}', [\App\Http\Controllers\Teacher\MacapatController::class, 'destroy'])->name('destroy');
    Route::post('/{macapat}/details', [\App\Http\Controllers\Teacher\MacapatController::class, 'storeDetail'])->name('details.store');
    Route::delete('/details/{detail}', [\App\Http\Controllers\Teacher\MacapatController::class, 'destroyDetail'])->name('details.destroy');
});

// Kelola Aksara Jawa untuk Pengajar (Teacher CRUD)
Route::middleware(['auth'])->prefix('teacher/javanese-script')->name('teacher.javanese-script.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\Teacher\JavaneseScriptController::class, 'destroy'])->name('destroy');
});

// Rute Tembang Macapat untuk Pelajar (Student)
Route::middleware(['auth'])->prefix('student/macapat')->name('student.macapat.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\MacapatController::class, 'index'])->name('index');
    Route::get('/{macapat}', [\App\Http\Controllers\Student\MacapatController::class, 'show'])->name('show');
});

// Halaman Pembelajaran Tembang Macapat (Utama & Detail)
Route::get('/macapat', [\App\Http\Controllers\MacapatController::class, 'index'])->name('macapat.index');
Route::get('/macapat/{id}', [\App\Http\Controllers\MacapatController::class, 'show'])->name('macapat.show');

// Halaman Pembelajaran Aksara Jawa (Utama & Detail)
Route::get('/aksara-jawa', [\App\Http\Controllers\JavaneseScriptController::class, 'index'])->name('javanese-script.index');
Route::get('/aksara-jawa/{id}', [\App\Http\Controllers\JavaneseScriptController::class, 'show'])->name('javanese-script.show');

// Halaman Pembelajaran Pewayangan (Katalog & Detail Tokoh)
Route::get('/wayang', [\App\Http\Controllers\WayangController::class, 'index'])->name('wayang.index');
Route::get('/wayang/{character}', [\App\Http\Controllers\WayangController::class, 'show'])->name('wayang.show');

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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    // Manajemen Akun Pengajar (Teachers)
    Route::get('/users/teachers', [\App\Http\Controllers\Admin\UserController::class, 'indexTeachers'])->name('users.teachers.index');
    Route::get('/users/teachers/create', [\App\Http\Controllers\Admin\UserController::class, 'createTeacher'])->name('users.teachers.create');
    Route::post('/users/teachers', [\App\Http\Controllers\Admin\UserController::class, 'storeTeacher'])->name('users.teachers.store');
    Route::get('/users/teachers/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'editTeacher'])->name('users.teachers.edit');
    Route::put('/users/teachers/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateTeacher'])->name('users.teachers.update');
    Route::delete('/users/teachers/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroyTeacher'])->name('users.teachers.destroy');

    // Manajemen Akun Pelajar (Students)
    Route::get('/users/students', [\App\Http\Controllers\Admin\UserController::class, 'indexStudents'])->name('users.students.index');
    Route::get('/users/students/create', [\App\Http\Controllers\Admin\UserController::class, 'createStudent'])->name('users.students.create');
    Route::post('/users/students', [\App\Http\Controllers\Admin\UserController::class, 'storeStudent'])->name('users.students.store');
    Route::get('/users/students/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'editStudent'])->name('users.students.edit');
    Route::put('/users/students/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateStudent'])->name('users.students.update');
    Route::delete('/users/students/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroyStudent'])->name('users.students.destroy');

    // Toggle Status Akun (Aktif / Nonaktif)
    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle_status');

    // Log Aktivitas Interaksi Pembelajaran
    Route::get('/activities', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activities.index');

    // Kosakata Management Legacy
    Route::post('/kosakata', [AdminPageController::class, 'storeVocab'])->name('vocab.store');
    Route::put('/kosakata/{vocabWord}', [AdminPageController::class, 'updateVocab'])->name('vocab.update');
    Route::delete('/kosakata/{vocabWord}', [AdminPageController::class, 'destroyVocab'])->name('vocab.destroy');
    Route::get('/kosakata/export', [AdminVocabCsvController::class, 'export'])->name('vocab.export');
    Route::post('/kosakata/import', [AdminVocabCsvController::class, 'import'])->name('vocab.import');
});

// Download attachment dengan nama asli file
Route::get('/attachments/{attachment}/download', function (\App\Models\ClassroomPostAttachment $attachment) {
    $path = storage_path('app/public/' . $attachment->file_path);
    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }
    return response()->download($path, $attachment->original_name);
})->name('attachment.download');

require __DIR__ . '/auth.php';
