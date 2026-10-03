@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
<div class="col-12 p-4 p-sm-5 d-flex flex-column justify-content-center bg-white auth-form-col">
    <!-- Header Form & Centered Big BasaKula Brand Title -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center gap-2.5 mb-2">
            <i class="fa-solid fa-graduation-cap" style="color: var(--accent-gold); font-size: 2.35rem;"></i>
            <span class="fw-bold tracking-tight" style="font-size: 2.35rem; color: #16402e; font-weight: 800; line-height: 1;">
                Basa<span style="color: var(--accent-gold);">Kula</span>
            </span>
        </div>
    </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
            <div>{{ $errors->first() }}</div>
        </div>
        @endif

        @if(session('status'))
        <div class="alert alert-success rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-circle-check text-success fs-5"></i>
            <div>{{ session('status') }}</div>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-circle-info text-info fs-5"></i>
            <div>{{ session('info') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-triangle-exclamation text-warning fs-5"></i>
            <div>{{ session('warning') }}</div>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Input Email / User Code -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-dark small mb-1">
                    Email atau Kode Pengguna
                </label>
                <div class="custom-input-group">
                    <i class="fa-solid fa-id-card-clip input-icon-left"></i>
                    <input type="text" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           value="{{ old('email') }}" 
                           placeholder="nama@email.com" 
                           required 
                           autofocus>
                </div>
                <small class="text-muted" style="font-size: 0.75rem;">Gunakan email terdaftar yang diberikan Admin.</small>
                @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label fw-semibold text-dark small mb-0">Kata Sandi / Password</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #b48530;">
                        Lupa Password?
                    </a>
                    @endif
                </div>
                <div class="custom-input-group">
                    <i class="fa-solid fa-lock input-icon-left"></i>
                    <input type="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           placeholder="••••••••" 
                           required>
                    <button type="button" class="input-btn-right toggle-password-btn" data-target="#password" title="Lihat password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember" style="cursor: pointer;">
                    <label class="form-check-label text-muted small user-select-none" for="remember" style="cursor: pointer;">
                        Ingat sesi saya
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mb-4 d-inline-flex align-items-center justify-content-center gap-2">
                <span>Masuk Sekarang</span>
                <i class="fa-solid fa-arrow-right-to-bracket small"></i>
            </button>
        </form>
</div>
@endsection
