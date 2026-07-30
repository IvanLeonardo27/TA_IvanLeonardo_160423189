@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div class="col-md-5 d-none d-md-flex auth-img flex-column text-center">
    <!-- Placeholder for Mascot/Illustration -->
    <i class="fa-solid fa-book-open-reader mb-4" style="font-size: 5rem; color: var(--accent);"></i>
    <h3 class="fw-bold">Sugeng Rawuh!</h3>
    <p class="text-white-50">Ayo sinau basa Jawa supaya luwih pinter lan ngerti kabudayan.</p>
</div>
<div class="col-md-7 p-5 d-flex flex-column justify-content-center">
    <h3 class="fw-bold mb-1 text-main">Masuk Akun</h3>
    <p class="text-muted mb-4">Silakan masuk menggunakan email dan password yang terdaftar.</p>

    @if($errors->any())
    <div class="alert alert-danger rounded-4 border-0 mb-3 small">
        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-main">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0">
                    <i class="fa-regular fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0 ps-0" id="email" value="{{ old('email') }}" placeholder="contoh@sekolah.com" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label fw-semibold text-main mb-0">Password</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-accent text-decoration-none small fw-semibold">Lupa Password?</a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0 border-end-0 ps-0" id="password" placeholder="••••••••" required>
                <button type="button" class="input-group-text bg-white text-muted border-start-0 toggle-password-btn" data-target="#password" style="cursor: pointer;">
                    <i class="fa-solid fa-eye text-muted"></i>
                </button>
            </div>
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-4 rounded-4 btn-bouncy">Masuk <i class="fa-solid fa-arrow-right ms-2"></i></button>

        <p class="text-center text-muted m-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a></p>
    </form>
</div>
@endsection
