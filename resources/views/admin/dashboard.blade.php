@extends('layouts.app')

@section('title', 'Dashboard Administrator - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1280px;">
    {{-- Banner Selamat Datang Admin --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5 d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div>
                {{-- Badge Super Admin with spacious padding --}}
                <div class="d-inline-flex align-items-center gap-2 mb-3 shadow-xs" 
                     style="background: rgba(255, 255, 255, 0.16); color: #ffffff !important; font-size: 0.84rem; padding: 6px 18px; border-radius: 50px; border: 1px solid rgba(255, 255, 255, 0.3);">
                    <i class="fa-solid fa-shield-halved text-white" style="font-size: 0.9rem;"></i>
                    <span class="fw-semibold">Hak Akses Super Administrator</span>
                </div>

                <h2 class="fw-bold text-white mb-2" style="letter-spacing: -0.5px;">Pusat Kendali Sistem BasaKula</h2>
                <p class="text-white-50 mb-0" style="max-width: 650px; font-size: 0.95rem; line-height: 1.6;">
                    Kelola data seluruh akun pengajar, pelajar dengan kode terpadu, pantau interaksi aktivitas pembelajaran secara real-time, dan monitor performa sistem secara menyeluruh.
                </p>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('admin.users.teachers.create') }}" class="btn btn-primary rounded-pill fw-bold btn-bouncy shadow-sm" style="padding: 10px 22px; font-size: 0.9rem;">
                    <i class="fa-solid fa-user-plus me-1.5"></i> Tambah Pengajar
                </a>
                <a href="{{ route('admin.users.students.create') }}" class="btn btn-light rounded-pill fw-bold btn-bouncy shadow-sm" style="color: #0F172A !important; padding: 10px 22px; font-size: 0.9rem;">
                    <i class="fa-solid fa-graduation-cap me-1.5 text-primary"></i> Tambah Pelajar
                </a>
            </div>
        </div>
    </div>

    {{-- Kartu Metrik Statistik Utama --}}
    <div class="row g-3 mb-4">
        {{-- Pengajar --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small">Total Pengajar</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:44px;height:44px;background:#E8F5E9;color:#16402E;">
                        <i class="fa-solid fa-chalkboard-user fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $stats['total_teachers'] }}</h3>
                <small class="text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i> {{ $stats['active_teachers'] }} Aktif</small>
            </div>
        </div>

        {{-- Pelajar --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small">Total Pelajar</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:44px;height:44px;background:#E0F2FE;color:#0284C7;">
                        <i class="fa-solid fa-user-graduate fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $stats['total_students'] }}</h3>
                <small class="text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i> {{ $stats['active_students'] }} Aktif</small>
            </div>
        </div>

        {{-- Ruang Kelas --}}
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('teacher.classroom.index') }}" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 transition-all hover-lift" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small">Ruang Kelas</span>
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:44px;height:44px;background:#DCFCE7;color:#166534;">
                            <i class="fa-solid fa-school fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $stats['total_classrooms'] }}</h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted"><i class="fa-solid fa-layer-group me-1"></i> {{ $stats['active_classrooms'] }} Kelas Berjalan</small>
                        <small class="text-primary fw-bold">Kelola <i class="fa-solid fa-arrow-right small"></i></small>
                    </div>
                </div>
            </a>
        </div>

        {{-- Interaksi Tugas & Kuis --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small">Evaluasi & Tugas</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:44px;height:44px;background:#EDE9FE;color:#7C3AED;">
                        <i class="fa-solid fa-chart-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $stats['total_submissions'] + $stats['total_quiz_attempts'] }}</h3>
                <small class="text-muted">{{ $stats['total_submissions'] }} Tugas &bull; {{ $stats['total_quiz_attempts'] }} Kuis</small>
            </div>
        </div>
    </div>

    {{-- Quick Access Modul Manajemen & Log --}}
    <div class="row g-4 mb-4">
        {{-- Pengajar Terkini --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-chalkboard-user text-primary"></i> Data Pengajar Terkini
                    </h5>
                    <a href="{{ route('admin.users.teachers.index') }}" class="btn btn-light border rounded-pill px-3 py-1.5 btn-sm fw-semibold">
                        Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.9rem;">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="fw-bold text-dark py-3 ps-3">Kode</th>
                                <th class="fw-bold text-dark py-3">Nama Pengajar</th>
                                <th class="fw-bold text-dark py-3">Lembaga</th>
                                <th class="fw-bold text-dark py-3 pe-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTeachers as $lt)
                            <tr>
                                <td class="py-3 ps-3">
                                    <div class="d-inline-flex align-items-center justify-content-center font-monospace fw-bold rounded-pill shadow-xs" 
                                         style="background: #16402E; color: #ffffff !important; font-size: 0.84rem; padding: 6px 14px; min-width: 95px;">
                                        {{ $lt->user_code ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark">{{ $lt->name }}</div>
                                    <small class="text-muted">{{ $lt->email }}</small>
                                </td>
                                <td class="text-muted py-3">{{ $lt->teacherProfile->institution_name ?? '-' }}</td>
                                <td class="py-3 pe-3">
                                    <span class="d-inline-flex align-items-center rounded-pill fw-bold shadow-xs" 
                                          style="{{ $lt->status === 'active' ? 'background: #DCFCE7; color: #166534 !important; border: 1px solid #86EFAC;' : 'background: #FEE2E2; color: #991B1B !important; border: 1px solid #FCA5A5;' }}; font-size: 0.76rem; padding: 5px 12px;">
                                        ● {{ $lt->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada akun pengajar terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pelajar Terkini --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-graduate text-info"></i> Data Pelajar Terkini
                    </h5>
                    <a href="{{ route('admin.users.students.index') }}" class="btn btn-light border rounded-pill px-3 py-1.5 btn-sm fw-semibold">
                        Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.9rem;">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="fw-bold text-dark py-3 ps-3">Kode</th>
                                <th class="fw-bold text-dark py-3">Nama Pelajar</th>
                                <th class="fw-bold text-dark py-3">Sekolah / Kelas</th>
                                <th class="fw-bold text-dark py-3 pe-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestStudents as $ls)
                            <tr>
                                <td class="py-3 ps-3">
                                    <div class="d-inline-flex align-items-center justify-content-center font-monospace fw-bold rounded-pill shadow-xs" 
                                         style="background: #0284C7; color: #ffffff !important; font-size: 0.84rem; padding: 6px 14px; min-width: 105px;">
                                        {{ $ls->user_code ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark">{{ $ls->name }}</div>
                                    <small class="text-muted">{{ $ls->email }}</small>
                                </td>
                                <td class="text-muted py-3">{{ $ls->studentProfile->school_name ?? ($ls->studentProfile->grade_level ?? '-') }}</td>
                                <td class="py-3 pe-3">
                                    <span class="d-inline-flex align-items-center rounded-pill fw-bold shadow-xs" 
                                          style="{{ $ls->status === 'active' ? 'background: #DCFCE7; color: #166534 !important; border: 1px solid #86EFAC;' : 'background: #FEE2E2; color: #991B1B !important; border: 1px solid #FCA5A5;' }}; font-size: 0.76rem; padding: 5px 12px;">
                                        ● {{ $ls->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada akun pelajar terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
