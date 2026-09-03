<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Cek status akun pengguna
        if ($user && $user->status === 'banned') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan oleh Administrator.');
        }

        // Catat aktivitas login & perbarui last_login
        if ($user) {
            $user->update(['last_login' => now()]);
            $roleLabel = $user->isAdmin() ? 'Super Administrator' : ($user->isTeacher() ? 'Pengajar' : 'Pelajar');
            \App\Models\ActivityLog::log(
                $user,
                'Masuk ke Sistem (Login)',
                'login',
                "Berhasil masuk ke dalam sistem BasaKula LMS sebagai {$roleLabel}.",
                'Portal BasaKula'
            );
        }

        // Pengalihan berdasarkan role
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user && $user->isTeacher()) {
            return redirect()->route('teacher.classroom.index');
        }

        return redirect()->route('student.classroom.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            \App\Models\ActivityLog::log(
                $user,
                'Keluar Sistem (Logout)',
                'logout',
                "Keluar dari sesi sistem BasaKula LMS.",
                'Portal BasaKula'
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
