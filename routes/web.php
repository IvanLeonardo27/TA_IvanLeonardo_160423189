<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminVocabCsvController;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\CustomerQuizAttemptController;
use App\Http\Controllers\CustomerTranslateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerPageController::class, 'index'])->name('customer.home');
Route::post('/translate', CustomerTranslateController::class)->name('customer.translate');
Route::post('/quiz/attempt', CustomerQuizAttemptController::class)->name('customer.quiz.attempt');

// Optional: keep Laravel welcome page accessible.
Route::view('/welcome', 'welcome')->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
