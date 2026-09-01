@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
<!-- Left Branding Panel (Consistent with Login) -->
<div class="col-lg-5 d-none d-lg-flex glass-left-panel">
    <!-- Javanese Watermark Glyph in Background -->
    <div class="javanese-watermark">ꦱꦶꦤꦻꦴ</div>

    <!-- Top Logo & Tagline -->
    <div>
        <div class="brand-badge mb-4">
            <i class="fa-solid fa-graduation-cap" style="color: var(--accent-gold); font-size: 1.2rem;"></i>
            <span class="fw-bold tracking-wide" style="font-size: 0.95rem;">Basa<span style="color: var(--accent-gold);">Kula</span></span>
        </div>

        <h2 class="fw-bold text-white mb-2" style="font-size: 1.85rem; line-height: 1.3;">
            Gabung Saiki!
        </h2>
        <p class="text-white-50 small mb-4">
            Daftar akun anyar lan wiwiti lelampahan sinau basa Jawa kanthi cara interaktif, seru, lan gampang.
        </p>
    </div>

    <!-- Mid Highlights -->
    <div class="my-4">
        <div class="feature-pill">
            <i class="fa-solid fa-user-graduate"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Pilihan Akun Fleksibel</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Akses minangka Siswa utawa Guru/Pengajar</small>
            </div>
        </div>
        <div class="feature-pill">
            <i class="fa-solid fa-book-bookmark"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Akses Pembelajaran Lengkap</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Aksara Jawa, Macapat, Kamus & Kuis</small>
            </div>
        </div>
        <div class="feature-pill">
            <i class="fa-solid fa-award"></i>
            <div>
                <strong class="d-block text-white" style="font-size: 0.85rem;">Evaluasi & Umpan Balik</strong>
                <small class="text-white-50" style="font-size: 0.75rem;">Pantau kemajuan sinau kanthi langsung</small>
            </div>
        </div>
    </div>

    <!-- Bottom Quote -->
    <div class="pt-3 border-top border-white border-opacity-10">
        <p class="mb-0 text-white-50 fst-italic" style="font-size: 0.8rem;">
            "Ngluruk tanpa bala, menang tanpa ngasorake — Sinau kanthi tulusing ati."
        </p>
    </div>
</div>

<!-- Right Register Form Panel -->
<div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center bg-white auth-form-col">
    <div class="px-md-3">
        <!-- Header Form -->
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center p-2 rounded-3 mb-3 d-lg-none" style="background: rgba(22, 64, 46, 0.1); color: #16402e;">
                <i class="fa-solid fa-user-plus fs-4"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Daftar Akun Baru</h3>
            <p class="text-muted small mb-0">Lengkapi data diri kamu di bawah ini untuk membuat akun baru.</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 mb-4 p-3 d-flex align-items-center gap-2 small shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
            <div>{{ $errors->first() }}</div>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="row g-3 mb-3">
                <!-- Nama Lengkap -->
                <div class="col-md-7">
                    <label for="name" class="form-label fw-semibold text-dark small mb-1">Nama Lengkap</label>
                    <div class="custom-input-group">
                        <i class="fa-regular fa-user input-icon-left"></i>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               value="{{ old('name') }}" 
                               placeholder="Budi Santoso" 
                               required 
                               autofocus>
                    </div>
                    @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role / Daftar Sebagai -->
                <div class="col-md-5">
                    <label for="role" class="form-label fw-semibold text-dark small mb-1">Daftar Sebagai</label>
                    <div class="custom-input-group">
                        <select name="role" class="form-select" id="role" style="border-radius: 14px; padding: 0.85rem 1rem; border: 1.5px solid #e2e8f0; font-size: 0.95rem; background: #f8fafc;" required>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Pelajar / Siswa</option>
                            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Pengajar / Guru</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-dark small mb-1">Alamat Email</label>
                <div class="custom-input-group">
                    <i class="fa-regular fa-envelope input-icon-left"></i>
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           value="{{ old('email') }}" 
                           placeholder="nama@sekolah.com" 
                           required>
                </div>
                @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password & Confirm Password (2 Cols) -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold text-dark small mb-1">Kata Sandi</label>
                    <div class="custom-input-group">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               placeholder="Min. 8 karakter" 
                               required>
                        <button type="button" class="input-btn-right toggle-password-btn" data-target="#password" title="Lihat password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-semibold text-dark small mb-1">Ulangi Kata Sandi</label>
                    <div class="custom-input-group">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               id="password_confirmation" 
                               placeholder="Ulangi sandi" 
                               required>
                        <button type="button" class="input-btn-right toggle-password-btn" data-target="#password_confirmation" title="Lihat password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="terms" required style="cursor: pointer;">
                <label class="form-check-label text-muted small user-select-none" for="terms" style="cursor: pointer;">
                    Saya setuju dengan <a href="#" class="fw-semibold text-decoration-none" style="color: #16402e;">Syarat & Ketentuan</a> yang berlaku.
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mb-4 d-inline-flex align-items-center justify-content-center gap-2">
                <span>Daftar Sekarang</span>
                <i class="fa-solid fa-arrow-right small"></i>
            </button>

            <!-- Login Link -->
            <div class="text-center pt-2 border-top">
                <p class="text-muted small mb-0">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #16402e;">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
