@extends('layouts.app')

@section('title', 'Profil Pengguna - ' . $user->name . ' - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Alerts --}}
    @if(session('success') || session('status') === 'profile-updated' || session('status') === 'password-updated')
    <div class="alert alert-success rounded-4 border-0 mb-4 p-3.5 d-flex align-items-center gap-2.5 shadow-sm">
        <i class="fa-solid fa-circle-check fs-5 text-success"></i>
        <div class="fw-medium text-dark">
            @if(session('status') === 'password-updated')
                Password akun Anda berhasil diperbarui!
            @elseif(session('status') === 'profile-updated')
                Perubahan data profil berhasil disimpan!
            @else
                {{ session('success') ?? 'Perubahan profil berhasil disimpan!' }}
            @endif
        </div>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="alert alert-danger rounded-4 border-0 mb-4 p-3.5 shadow-sm">
        <div class="d-flex align-items-center gap-2 mb-1 fw-bold text-danger">
            <i class="fa-solid fa-circle-exclamation fs-5"></i> Terdapat kesalahan pengisian data:
        </div>
        <ul class="mb-0 ps-4 small text-dark">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Hero Profile Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    {{-- Avatar Ring --}}
                    <div class="position-relative">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-lg text-white fw-bold" 
                             style="width: 86px; height: 86px; font-size: 2rem; background: linear-gradient(135deg, #C9A66B 0%, #A68449 100%); border: 3.5px solid rgba(255,255,255,0.4);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white rounded-circle" title="Akun Aktif" style="width:16px;height:16px;"></span>
                    </div>

                    {{-- User Details Header --}}
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1.5">
                            <h3 class="fw-bold text-white mb-0" style="letter-spacing: -0.5px;">{{ $user->name }}</h3>
                            
                            {{-- Role Badge --}}
                            @if($user->isAdmin())
                                <span class="d-inline-flex align-items-center gap-1.5 px-3 py-1 rounded-pill fw-bold" 
                                      style="background: rgba(255,255,255,0.2); color: #ffffff !important; font-size: 0.76rem; border: 1px solid rgba(255,255,255,0.35);">
                                    <i class="fa-solid fa-shield-halved"></i> Super Administrator
                                </span>
                            @elseif($user->isTeacher())
                                <span class="d-inline-flex align-items-center gap-1.5 px-3 py-1 rounded-pill fw-bold" 
                                      style="background: rgba(255,255,255,0.2); color: #ffffff !important; font-size: 0.76rem; border: 1px solid rgba(255,255,255,0.35);">
                                    <i class="fa-solid fa-chalkboard-user"></i> Pengajar / Guru
                                </span>
                            @else
                                <span class="d-inline-flex align-items-center gap-1.5 px-3 py-1 rounded-pill fw-bold" 
                                      style="background: rgba(255,255,255,0.2); color: #ffffff !important; font-size: 0.76rem; border: 1px solid rgba(255,255,255,0.35);">
                                    <i class="fa-solid fa-user-graduate"></i> Pelajar / Siswa
                                </span>
                            @endif

                            {{-- Code Pill --}}
                            @if($user->user_code)
                                <span class="d-inline-flex align-items-center font-monospace fw-bold px-3 py-1 rounded-pill shadow-xs" 
                                      style="background: #ffffff; color: #16402E !important; font-size: 0.8rem; letter-spacing: 0.5px;">
                                    {{ $user->user_code }}
                                </span>
                            @endif
                        </div>

                        <p class="text-white-50 small mb-2 d-flex align-items-center gap-3 flex-wrap">
                            <span><i class="fa-regular fa-envelope me-1 text-white"></i> {{ $user->email }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-calendar-check me-1 text-white"></i> Terdaftar: {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                            @if($user->last_login)
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-clock me-1 text-white"></i> Login Terakhir: {{ $user->last_login->translatedFormat('d M Y, H:i') }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Action Fast Tab Switch --}}
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold btn-bouncy shadow-sm" 
                            type="button" onclick="document.getElementById('edit-tab').click();" style="color: #16402E !important; font-size: 0.9rem;">
                        <i class="fa-solid fa-pen-to-square me-1.5"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    @php
        $activeTab = 'overview';
        if ($errors->updatePassword->isNotEmpty() || session('status') === 'password-updated') {
            $activeTab = 'security';
        } elseif ($errors->isNotEmpty() || session('status') === 'profile-updated') {
            $activeTab = 'edit';
        } elseif (request('tab') === 'security' || request('tab') === 'edit') {
            $activeTab = request('tab');
        }
    @endphp

    {{-- Nav Tabs Navigation --}}
    <ul class="nav nav-pills custom-profile-tabs mb-4 p-1.5 rounded-4 shadow-sm bg-white border" id="profileTabs" role="tablist" style="border: 1px solid #E2E8F0 !important;">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'overview' ? 'active' : '' }} rounded-pill fw-bold px-4 py-2.5 d-flex align-items-center gap-2" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="{{ $activeTab === 'overview' ? 'true' : 'false' }}">
                <i class="fa-solid fa-id-card"></i>
                <span>Ringkasan Akun</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'edit' ? 'active' : '' }} rounded-pill fw-bold px-4 py-2.5 d-flex align-items-center gap-2" id="edit-tab" data-bs-toggle="pill" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="{{ $activeTab === 'edit' ? 'true' : 'false' }}">
                <i class="fa-solid fa-user-pen"></i>
                <span>Perbarui Data Profil</span>
                @if($errors->isNotEmpty() && $errors->updatePassword->isEmpty())
                    <span class="badge rounded-pill bg-danger text-white px-2 py-0.5 small" style="font-size: 0.7rem;">Error</span>
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'security' ? 'active' : '' }} rounded-pill fw-bold px-4 py-2.5 d-flex align-items-center gap-2" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="{{ $activeTab === 'security' ? 'true' : 'false' }}">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Keamanan & Password</span>
                @if($errors->updatePassword->isNotEmpty())
                    <span class="badge rounded-pill bg-danger text-white px-2 py-0.5 small" style="font-size: 0.7rem;">Error</span>
                @endif
            </button>
        </li>
    </ul>

    {{-- Tab Content Panes --}}
    <div class="tab-content" id="profileTabsContent">
        
        {{-- ======================== TAB 1: OVERVIEW ======================== --}}
        <div class="tab-pane fade {{ $activeTab === 'overview' ? 'show active' : '' }}" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row g-4">
                {{-- Kolom Kiri: Detail Informasi Akun --}}
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-user text-primary"></i> Detail Informasi Pengguna
                            </h5>
                            <span class="badge bg-light text-muted border rounded-pill px-3 py-1.5 font-monospace">
                                ID Akun: #{{ $user->id }}
                            </span>
                        </div>

                        <div class="row g-3.5">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                    <small class="text-muted fw-semibold d-block mb-1">Nama Lengkap</small>
                                    <div class="fw-bold text-dark" style="font-size:0.95rem;">{{ $user->name }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                    <small class="text-muted fw-semibold d-block mb-1">Alamat Email</small>
                                    <div class="fw-bold text-dark" style="font-size:0.95rem;">{{ $user->email }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                    <small class="text-muted fw-semibold d-block mb-1">Kode Identitas Pengguna</small>
                                    <div class="d-inline-flex align-items-center font-monospace fw-bold px-3 py-1 rounded-pill shadow-xs mt-1" 
                                         style="background: #16402E; color: #ffffff !important; font-size: 0.86rem; letter-spacing: 0.5px;">
                                        {{ $user->user_code ?? 'Belum ada kode' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                    <small class="text-muted fw-semibold d-block mb-1">Status Keaktifan Akun</small>
                                    <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill fw-bold shadow-xs mt-1" 
                                          style="{{ $user->status === 'active' ? 'background: #DCFCE7; color: #166534 !important; border: 1px solid #86EFAC;' : 'background: #FEE2E2; color: #991B1B !important; border: 1px solid #FCA5A5;' }}; font-size: 0.78rem;">
                                        ● {{ $user->status === 'active' ? 'Aktif (Dapat Mengakses Sistem)' : 'Nonaktif (Ditangguhkan)' }}
                                    </span>
                                </div>
                            </div>

                            @if($user->isTeacher())
                                {{-- Data Khusus Guru --}}
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Nomor Induk Pegawai (NIP)</small>
                                        <div class="fw-bold text-dark font-monospace">{{ $user->teacherProfile->nip ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Nama Lembaga / Sekolah</small>
                                        <div class="fw-bold text-dark">{{ $user->teacherProfile->institution_name ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Bidang Keahlian / Mapel</small>
                                        <div class="fw-bold text-dark">{{ $user->teacherProfile->subject_specialization ?? 'Bahasa & Sastra Jawa' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Nomor Telepon / WhatsApp</small>
                                        <div class="fw-bold text-dark">{{ $user->teacherProfile->phone_number ?? '-' }}</div>
                                    </div>
                                </div>
                            @elseif($user->studentProfile || !$user->isAdmin())
                                {{-- Data Khusus Siswa --}}
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">NISN (Nomor Induk Siswa Nasional)</small>
                                        <div class="fw-bold text-dark font-monospace">{{ $user->studentProfile->nisn ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Asal Sekolah</small>
                                        <div class="fw-bold text-dark">{{ $user->studentProfile->school_name ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Kelas / Tingkat</small>
                                        <div class="fw-bold text-dark">{{ $user->studentProfile->grade_level ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-3 bg-light bg-opacity-50 rounded-4 border">
                                        <small class="text-muted fw-semibold d-block mb-1">Nomor Telepon / WhatsApp</small>
                                        <div class="fw-bold text-dark">{{ $user->studentProfile->phone_number ?? '-' }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Statistik Pembelajaran & Aktivitas --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-chart-pie text-primary"></i> Ringkasan Aktivitas Anda
                            </h5>
                        </div>

                        @if($user->isTeacher())
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-primary">{{ $stats['total_classrooms'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Kelas Dikelola</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-success">{{ $stats['total_students'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Siswa Terdaftar</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-info">{{ $stats['total_materials'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Materi Dipublikasikan</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-danger">{{ $stats['total_assignments'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Tugas Dibuat</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-purple" style="color:#8B5CF6;">{{ $stats['total_quizzes'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Kuis & Evaluasi Aktif</small>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->isAdmin())
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-primary">{{ $stats['total_teachers'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Total Pengajar</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-info">{{ $stats['total_students'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Total Pelajar</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-success">{{ $stats['total_classrooms'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Total Ruang Kelas Sistem</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-primary">{{ $stats['total_classrooms'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Kelas Diikuti</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-success">{{ $stats['total_submissions'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Tugas Dikumpulkan</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-danger">{{ $stats['graded_submissions'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Tugas Dinilai</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 border shadow-xs bg-light bg-opacity-50 text-center">
                                        <div class="fw-bold fs-3 text-purple" style="color:#8B5CF6;">{{ $stats['total_attempts'] ?? 0 }}</div>
                                        <small class="text-muted fw-semibold">Percobaan Kuis</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 pt-3 border-top text-center">
                            <a href="{{ route('calendar.index') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-2 btn-sm fw-semibold">
                                <i class="fa-solid fa-calendar-days me-1.5"></i> Buka Kalender Pembelajaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================== TAB 2: EDIT PROFILE ======================== --}}
        <div class="tab-pane fade {{ $activeTab === 'edit' ? 'show active' : '' }}" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-pen text-primary"></i> Perbarui Data Profil & Kontak
                        </h5>
                        <p class="text-muted small mb-0">Pastikan data nama, email, dan rincian lembaga terisi dengan benar.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-0 py-2.5 text-dark fw-semibold" 
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0 py-2.5 text-dark fw-semibold" 
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        @if($user->isTeacher())
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Nomor Induk Pegawai (NIP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                                    <input type="text" name="nip" class="form-control bg-light border-0 py-2.5 text-dark font-monospace" 
                                           value="{{ old('nip', $user->teacherProfile->nip ?? '') }}" placeholder="Contoh: 198501012010011001">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Nama Lembaga / Sekolah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-school text-muted"></i></span>
                                    <input type="text" name="institution_name" class="form-control bg-light border-0 py-2.5 text-dark" 
                                           value="{{ old('institution_name', $user->teacherProfile->institution_name ?? '') }}" placeholder="Contoh: SMA Negeri 1 Surabaya">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Bidang Keahlian / Mapel</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book text-muted"></i></span>
                                    <input type="text" name="subject_specialization" class="form-control bg-light border-0 py-2.5 text-dark" 
                                           value="{{ old('subject_specialization', $user->teacherProfile->subject_specialization ?? '') }}" placeholder="Contoh: Bahasa & Sastra Jawa">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Nomor Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-brands fa-whatsapp text-muted"></i></span>
                                    <input type="text" name="phone_number" class="form-control bg-light border-0 py-2.5 text-dark font-monospace" 
                                           value="{{ old('phone_number', $user->teacherProfile->phone_number ?? '') }}" placeholder="Contoh: 08123456789">
                                </div>
                            </div>
                        @elseif($user->studentProfile || !$user->isAdmin())
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">NISN</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                                    <input type="text" name="nisn" class="form-control bg-light border-0 py-2.5 text-dark font-monospace" 
                                           value="{{ old('nisn', $user->studentProfile->nisn ?? '') }}" placeholder="Contoh: 0081234567">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Nama Asal Sekolah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-school text-muted"></i></span>
                                    <input type="text" name="school_name" class="form-control bg-light border-0 py-2.5 text-dark" 
                                           value="{{ old('school_name', $user->studentProfile->school_name ?? '') }}" placeholder="Contoh: SMP Negeri 7 Surabaya">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Kelas / Tingkat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-graduation-cap text-muted"></i></span>
                                    <input type="text" name="grade_level" class="form-control bg-light border-0 py-2.5 text-dark" 
                                           value="{{ old('grade_level', $user->studentProfile->grade_level ?? '') }}" placeholder="Contoh: Kelas 7A">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Nomor Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-brands fa-whatsapp text-muted"></i></span>
                                    <input type="text" name="phone_number" class="form-control bg-light border-0 py-2.5 text-dark font-monospace" 
                                           value="{{ old('phone_number', $user->studentProfile->phone_number ?? '') }}" placeholder="Contoh: 08123456789">
                                </div>
                            </div>
                        @endif

                        <div class="col-12 text-end pt-3 border-top">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold btn-bouncy shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1.5"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======================== TAB 3: SECURITY & PASSWORD ======================== --}}
        <div class="tab-pane fade {{ $activeTab === 'security' ? 'show active' : '' }}" id="security" role="tabpanel" aria-labelledby="security-tab">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-lock text-primary"></i> Ganti Password Akun
                        </h5>
                        <p class="text-muted small mb-0">Pastikan akun Anda menggunakan password yang aman dengan minimal 8 karakter.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="max-w-xl">
                    @csrf
                    @method('PUT')

                    <div class="row g-3.5" style="max-width: 600px;">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-key text-muted"></i></span>
                                <input type="password" name="current_password" class="form-control bg-light border-0 py-2.5 text-dark" required autocomplete="current-password" placeholder="Masukkan password lama Anda">
                            </div>
                            @error('current_password', 'updatePassword')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2.5 text-dark" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            </div>
                            @error('password', 'updatePassword')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-shield-check text-muted"></i></span>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2.5 text-dark" required autocomplete="new-password" placeholder="Ulangi password baru">
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 pt-3">
                            <button type="submit" class="btn btn-dark rounded-pill px-4 py-2.5 fw-bold btn-bouncy shadow-sm">
                                <i class="fa-solid fa-shield-halved me-1.5"></i> Perbarui Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.custom-profile-tabs .nav-link {
    color: #475569;
    border: none;
    transition: all 0.2s ease;
}
.custom-profile-tabs .nav-link:hover {
    color: #16402E;
    background: #F1F5F9;
}
.custom-profile-tabs .nav-link.active {
    background: #16402E !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(22, 64, 46, 0.2);
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. If URL has a hash matching a tab, open that tab
    const hash = window.location.hash;
    if (hash && (hash === '#overview' || hash === '#edit' || hash === '#security')) {
        const triggerBtn = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (triggerBtn) {
            const tab = bootstrap.Tab.getOrCreateInstance(triggerBtn);
            tab.show();
        }
    }

    // 2. Sync URL hash on tab switch so reload keeps the same tab
    const tabButtons = document.querySelectorAll('#profileTabs button[data-bs-toggle="pill"]');
    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function (e) {
            const target = e.target.getAttribute('data-bs-target');
            if (target && history.replaceState) {
                history.replaceState(null, null, target);
            }
        });
    });
});
</script>
@endpush
