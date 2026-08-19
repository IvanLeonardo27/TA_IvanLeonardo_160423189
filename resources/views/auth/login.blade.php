@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
<!-- Left Branding Panel -->
<div class="col-lg-5 d-none d-lg-flex glass-left-panel">
    <!-- Javanese Watermark Glyph in Background -->
    <div class="javanese-watermark">ꦲꦤꦕꦫꦏ</div>

    <!-- Top Logo & Tagline -->
    <div>
        <div class="brand-badge mb-4">
            <i class="fa-solid fa-graduation-cap" style="color: var(--accent-gold); font-size: 1.2rem;"></i>
            <span class="fw-bold tracking-wide" style="font-size: 0.95rem;">Basa<span style="color: var(--accent-gold);">Kula</span></span>
        </div>

        <h2 class="fw-bold text-white mb-2" style="font-size: 1.85rem; line-height: 1.3;">
            Sugeng Rawuh ing BasaKula
        </h2>
        <p class="text-white-50 small mb-4">
            Platform sinau basa Jawa interaktif kanthi materi lengkap, Aksara Jawa, Tembang Macapat, lan evaluasi modern.
        </p>
    </div>

    <!-- Mid Highlights -->
    <div class="my-4">
        <div class="feature-pill">
            <i class="fa-solid fa-font"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Aksara Jawa Visual</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Kartu aksara komprehensif & contoh kalimat</small>
            </div>
        </div>
        <div class="feature-pill">
            <i class="fa-solid fa-music"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Tembang Macapat</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Kaidah guru lagu, wilangan & makna bait</small>
            </div>
        </div>
        <div class="feature-pill">
            <i class="fa-solid fa-chalkboard-user"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Ruang Kelas Terintegrasi</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Kolaborasi belajar siswa lan guru</small>
            </div>
        </div>
    </div>

    <!-- Bottom Quote -->
    <div class="pt-3 border-top border-white border-opacity-10">
        <p class="mb-0 text-white-50 fst-italic" style="font-size: 0.8rem;">
            "Mikul dhuwur mendhem jero — Nguri-uri kabudayan Jawa lumantar teknologi modern."
        </p>
    </div>
</div>

<!-- Right Login Form Panel -->
<div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center bg-white">
    <div class="px-md-3">
        <!-- Header Form -->
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center p-2 rounded-3 mb-3 d-lg-none" style="background: rgba(22, 64, 46, 0.1); color: #16402e;">
                <i class="fa-solid fa-graduation-cap fs-4"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Masuk Akun</h3>
            <p class="text-muted small mb-0">Mlebet akun nggunakake email utawa kode pangguna panjenengan.</p>
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
                           placeholder="nama@email.com atau Kode (27705... / 277...)" 
                           required 
                           autofocus>
                </div>
                <small class="text-muted" style="font-size: 0.75rem;">Gunakan email terdaftar atau kode unik yang diberikan Admin.</small>
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

            <!-- Admin Notice Info -->
            <div class="text-center pt-3 border-top">
                <p class="text-muted small mb-0">
                    <i class="fa-solid fa-shield-halved text-primary me-1"></i>
                    Pendaftaran akun Pengajar & Pelajar dikelola terpusat oleh <strong>Administrator</strong>.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
