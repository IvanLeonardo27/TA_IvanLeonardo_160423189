@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
<div class="col-md-5 d-none d-md-flex auth-img flex-column text-center order-md-2" style="background-color: var(--accent);">
    <i class="fa-solid fa-user-plus mb-4" style="font-size: 5rem; color: var(--primary);"></i>
    <h3 class="fw-bold" style="color: var(--primary);">Gabung Saiki!</h3>
    <p class="text-white-50" style="color: rgba(31, 77, 58, 0.7) !important;">Daftar akun baru untuk mulai belajar bahasa Jawa dengan seru.</p>
</div>
<div class="col-md-7 p-5 d-flex flex-column justify-content-center order-md-1">
    <h3 class="fw-bold mb-1 text-main">Daftar Akun Baru</h3>
    <p class="text-muted mb-4">Lengkapi data diri kamu di bawah ini.</p>

    @if($errors->any())
    <div class="alert alert-danger rounded-4 border-0 mb-3 small">
        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label fw-semibold text-main">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Budi Santoso" required autofocus>
            </div>
            <div class="col-md-6 mb-3">
                <label for="role" class="form-label fw-semibold text-main">Daftar Sebagai</label>
                <select name="role" class="form-select" id="role" required>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Pelajar / Siswa</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Pengajar / Guru</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-main">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0">
                    <i class="fa-regular fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0 ps-0" id="email" value="{{ old('email') }}" placeholder="contoh@sekolah.com" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-main mb-1">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0 ps-0" id="password" placeholder="Minimal 8 karakter" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold text-main mb-1">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" id="password_confirmation" placeholder="Ulangi password" required>
            </div>
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="terms" required>
            <label class="form-check-label text-muted" for="terms" style="font-size: 0.9rem;">
                Saya setuju dengan <a href="#" class="text-primary fw-semibold">Syarat & Ketentuan</a> yang berlaku.
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-4 rounded-4 btn-bouncy">Daftar Sekarang <i class="fa-solid fa-arrow-right ms-2"></i></button>

        <p class="text-center text-muted m-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></p>
    </form>
</div>
@endsection
