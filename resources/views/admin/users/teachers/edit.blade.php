@extends('layouts.app')

@section('title', 'Edit Pengajar - Admin BasaKula')

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
                        <i class="fa-solid fa-user-pen text-primary me-2"></i> Edit Akun Pengajar
                    </h4>
                    <p class="text-muted small mb-0">Perbarui data profil, email, password, atau status akun pengajar.</p>
                </div>
                <div class="text-end">
                    <span class="small text-muted d-block">Kode Pengajar Terdaftar:</span>
                    <span class="badge bg-primary font-monospace fs-6 px-3 py-1.5 rounded-pill shadow-xs">
                        {{ $user->user_code ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.users.teachers.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nama Lengkap Pengajar <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Ganti Password (Opsional)</label>
                        <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                               placeholder="Biarkan kosong jika tidak diubah">
                        <small class="text-muted" style="font-size:0.75rem;">Isi hanya jika ingin mereset password akun.</small>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nomor Induk Pegawai (NIP)</label>
                        <input type="text" name="nip" class="form-control rounded-3" 
                               value="{{ old('nip', $user->teacherProfile->nip ?? '') }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nama Lembaga / Sekolah</label>
                        <input type="text" name="institution_name" class="form-control rounded-3" 
                               value="{{ old('institution_name', $user->teacherProfile->institution_name ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Bidang Keahlian / Mapel</label>
                        <input type="text" name="subject_specialization" class="form-control rounded-3" 
                               value="{{ old('subject_specialization', $user->teacherProfile->subject_specialization ?? '') }}">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone_number" class="form-control rounded-3" 
                               value="{{ old('phone_number', $user->teacherProfile->phone_number ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-main small">Status Akun</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Aktif (Dapat Login)</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Nonaktif (Ditangguhkan)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.users.teachers.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold btn-bouncy shadow-sm">
                        <i class="fa-solid fa-save me-1.5"></i> Perbarui Data Pengajar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
