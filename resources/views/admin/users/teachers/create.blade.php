@extends('layouts.app')

@section('title', 'Tambah Pengajar Baru - Admin BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 860px;">
    <div class="mb-4">
        <a href="{{ route('admin.users.teachers.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 btn-sm fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Pengajar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="card-header bg-white p-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold text-main mb-1">
                        <i class="fa-solid fa-user-plus text-primary me-2"></i> Tambah Akun Pengajar
                    </h4>
                    <p class="text-muted small mb-0">Kode pengajar akan digenerate otomatis secara berurutan oleh sistem.</p>
                </div>
                <div class="text-end">
                    <span class="small text-muted d-block">Kode Pengajar Tergenerate:</span>
                    <span class="badge bg-primary font-monospace fs-6 px-3 py-1.5 rounded-pill shadow-xs">
                        {{ $previewCode }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.users.teachers.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nama Lengkap Pengajar <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Contoh: Budi Santoso, S.Pd." required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="pengajar@sekolah.sch.id" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Kata Sandi / Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                               placeholder="Minimal 6 karakter" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nomor Induk Pegawai (NIP)</label>
                        <input type="text" name="nip" class="form-control rounded-3" 
                               value="{{ old('nip') }}" placeholder="Contoh: 198503122010011005">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nama Lembaga / Sekolah</label>
                        <input type="text" name="institution_name" class="form-control rounded-3" 
                               value="{{ old('institution_name') }}" placeholder="Contoh: SMP Negeri 1 Surabaya">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Bidang Keahlian / Mata Pelajaran</label>
                        <input type="text" name="subject_specialization" class="form-control rounded-3" 
                               value="{{ old('subject_specialization', 'Bahasa & Sastra Jawa') }}" placeholder="Bahasa Jawa">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone_number" class="form-control rounded-3" 
                               value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Status Akun</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="active" selected>Aktif (Dapat Login)</option>
                            <option value="inactive">Nonaktif (Ditangguhkan)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.users.teachers.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold btn-bouncy shadow-sm">
                        <i class="fa-solid fa-save me-1.5"></i> Simpan Akun Pengajar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
