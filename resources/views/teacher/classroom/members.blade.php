@extends('layouts.app')

@section('title', 'Anggota Kelas: ' . $classroom->name . ' – Kelola Anggota')

@section('content')
<div class="py-3 px-2 px-md-4">
    {{-- HERO BANNER KELAS --}}
    <div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" 
         style="border-radius:24px; background: linear-gradient(135deg, {{ $classroom->banner_color ?? 'var(--primary)' }} 0%, color-mix(in srgb, {{ $classroom->banner_color ?? '#16382a' }} 70%, #000) 100%);">
        <div class="p-4 p-md-5 position-relative text-white" style="min-height:190px;">
            <i class="fa-solid fa-{{ $classroom->banner_icon ?? 'users' }} position-absolute opacity-10"
               style="font-size:15rem; right:-20px; bottom:-40px; color:#ffffff;"></i>
            
            <div class="position-relative" style="z-index:2;">
                @if($classroom->subject)
                <span class="badge rounded-pill px-3 py-1.5 mb-2.5 fw-bold bg-dark bg-opacity-40 text-white shadow-sm border border-white border-opacity-20"
                      style="letter-spacing:.5px; font-size:.72rem;">
                    <i class="fa-solid fa-book-journal-whills me-1 text-accent"></i> {{ strtoupper($classroom->subject) }}
                </span>
                @endif

                <div class="d-flex align-items-center gap-3 flex-wrap justify-content-between mb-3">
                    <div>
                        <h1 class="fw-bold display-6 mb-1 text-white" style="text-shadow:0 2px 10px rgba(0,0,0,.25);">
                            {{ $classroom->name }}
                        </h1>
                        <p class="text-white text-opacity-75 mb-0 small">
                            <i class="fa-solid fa-user-tie me-1.5"></i>Pengajar: <strong>{{ $classroom->teacher->name ?? auth()->user()->name }}</strong>
                            @if($classroom->room) &bull; Ruang: {{ $classroom->room }} @endif
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm btn-bouncy">
                            <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali ke Materi
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2.5 mt-2 flex-wrap">
                    <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3.5 py-1.5 shadow-sm">
                        <span class="small fw-bold text-white"><i class="fa-solid fa-users me-1 text-accent"></i> {{ $students->count() }} Pelajar Aktif</span>
                    </div>
                    @if(isset($formerStudents) && $formerStudents->count() > 0)
                    <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3.5 py-1.5 shadow-sm">
                        <span class="small fw-semibold text-white-50"><i class="fa-solid fa-user-slash me-1 text-warning"></i> {{ $formerStudents->count() }} Dikeluarkan</span>
                    </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3.5 py-1.5 shadow-sm">
                        <span class="small fw-semibold text-white-50"><i class="fa-solid fa-key me-1 text-accent"></i> Kode: <strong class="text-white font-monospace">{{ $classroom->code }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 p-3.5">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 p-3.5">
        <i class="fa-solid fa-circle-info me-2"></i>{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- NAVIGASI TAB UTAMA KELAS --}}
    <style>
    .classroom-nav-pill {
        background-color: #F8FAFC;
        color: #475569;
        border: 1.5px solid #E2E8F0;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }
    .classroom-nav-pill:hover {
        background-color: #F1F5F9;
        color: #1E293B;
        border-color: #CBD5E1;
    }
    .classroom-nav-pill.active {
        background-color: var(--primary, #059669) !important;
        color: #FFFFFF !important;
        border-color: var(--primary, #059669) !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }
    .hover-elevate-subtle {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-elevate-subtle:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06) !important;
    }
    </style>

    <ul class="nav nav-pills gap-2.5 mb-4 animate__animated animate__fadeInUp">
        <li class="nav-item">
            <a href="{{ route('teacher.classroom.show', $classroom) }}" class="nav-link classroom-nav-pill rounded-pill px-4 py-2.5 fw-semibold">
                <i class="fa-solid fa-layer-group me-2"></i>Kurikulum & Minggu (Week)
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('teacher.classroom.show', $classroom) }}#stream" class="nav-link classroom-nav-pill rounded-pill px-4 py-2.5 fw-semibold">
                <i class="fa-solid fa-comment-dots me-2"></i>Stream Feed
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('teacher.classroom.members', $classroom) }}" class="nav-link classroom-nav-pill active rounded-pill px-4 py-2.5 fw-semibold">
                <i class="fa-solid fa-users me-2"></i>Anggota Kelas
            </a>
        </li>
    </ul>

    {{-- STATISTIK RINGKAS ANGGOTA KELAS --}}
    <div class="row g-3 mb-4 animate__animated animate__fadeInUp">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100" style="border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                         style="width: 50px; height: 50px; background: #DCFCE7; color: #15803D; border-radius: 14px;">
                        <i class="fa-solid fa-user-graduate fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block" style="font-size: 0.76rem;">Pelajar Aktif</small>
                        <h4 class="fw-bold text-dark mb-0">{{ $students->count() }} <span class="fs-6 text-muted fw-normal">Siswa</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100" style="border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                         style="width: 50px; height: 50px; background: #E0F2FE; color: #0284C7; border-radius: 14px;">
                        <i class="fa-solid fa-chalkboard-user fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block" style="font-size: 0.76rem;">Pengajar</small>
                        <h4 class="fw-bold text-dark mb-0">1 <span class="fs-6 text-muted fw-normal">Guru</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100" style="border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                         style="width: 50px; height: 50px; background: #FEE2E2; color: #DC2626; border-radius: 14px;">
                        <i class="fa-solid fa-user-xmark fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block" style="font-size: 0.76rem;">Dikeluarkan</small>
                        <h4 class="fw-bold text-dark mb-0">{{ isset($formerStudents) ? $formerStudents->count() : 0 }} <span class="fs-6 text-muted fw-normal">Histori</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100" style="border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                             style="width: 50px; height: 50px; background: #FEF3C7; color: #D97706; border-radius: 14px;">
                            <i class="fa-solid fa-key fs-5"></i>
                        </div>
                        <div class="overflow-hidden">
                            <small class="text-muted fw-semibold d-block text-truncate" style="font-size: 0.76rem;">Kode Kelas</small>
                            <h5 class="fw-bold text-primary font-monospace mb-0 text-truncate" style="letter-spacing: 1px;">{{ $classroom->code }}</h5>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 flex-shrink-0 shadow-xs" onclick="copyClassCode('{{ $classroom->code }}')" title="Salin Kode Kelas">
                        <i class="fa-regular fa-copy"></i>
                        <span class="d-none d-lg-inline">Salin</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: PENGAJAR KELAS --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 animate__animated animate__fadeInUp overflow-hidden" style="border: 1px solid #E2E8F0 !important;">
        <div class="card-header bg-white border-bottom p-4 px-md-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(5,150,105,0.12); color: var(--primary);">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Pengajar Kelas</h5>
                    <small class="text-muted">Guru pengampu yang memfasilitasi dan mengelola kelas ini</small>
                </div>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.75rem;">
                <i class="fa-solid fa-circle-check me-1"></i> 1 Pengajar Utama
            </span>
        </div>
        <div class="card-body p-4 px-md-4">
            <div class="p-3.5 p-md-4 rounded-4 bg-light border d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3.5">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($classroom->teacher->name ?? auth()->user()->name) }}&size=60&background=059669&color=fff&bold=true" 
                         class="rounded-circle shadow-xs flex-shrink-0" width="56" height="56" alt="Avatar Pengajar" style="border: 3px solid #FFFFFF;">
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $classroom->teacher->name ?? auth()->user()->name }}</h6>
                            <span class="badge bg-primary text-white rounded-pill px-2.5 py-0.5" style="font-size: 0.7rem;">Pengajar Utama</span>
                        </div>
                        <span class="text-muted small d-block">
                            <i class="fa-regular fa-envelope me-1.5 opacity-75"></i>{{ $classroom->teacher->email ?? auth()->user()->email }}
                        </span>
                    </div>
                </div>
                <div class="text-start text-md-end px-2">
                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.75rem;">Mata Pelajaran</small>
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 fw-bold shadow-xs" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-book-bookmark me-1 text-primary"></i> {{ $classroom->subject ?: 'Umum' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: DAFTAR SISWA & MANAJEMEN ANGGOTA --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white animate__animated animate__fadeInUp overflow-hidden mb-4" style="border: 1px solid #E2E8F0 !important;">
        {{-- Header & Toolbar --}}
        <div class="card-header bg-white border-bottom p-4 px-md-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3.5">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(5,150,105,0.12); color: var(--primary);">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="fw-bold text-dark mb-0">Daftar Pelajar</h5>
                            <span class="badge bg-primary rounded-pill px-3 py-1 fw-semibold" id="studentCounterBadge">{{ $students->count() }} Siswa</span>
                        </div>
                        <small class="text-muted">Kelola seluruh peserta didik yang tergabung di dalam kelas</small>
                    </div>
                </div>

                @can('manageMembers', $classroom)
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2.5 fw-semibold shadow-xs btn-bouncy d-inline-flex align-items-center gap-2"
                            data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Tambah Pelajar ke Kelas</span>
                    </button>
                </div>
                @endcan
            </div>

            {{-- Filter & Search Bar Toolbar --}}
            <div class="p-3 bg-light rounded-4 border d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="flex-grow-1" style="min-width: 260px; max-width: 480px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="memberSearchInput" class="form-control bg-white border-start-0 rounded-end-pill py-2 pe-3 shadow-none"
                               placeholder="Cari pelajar berdasarkan nama, email, atau NIS..." onkeyup="filterMemberCards()">
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-semibold shadow-xs" id="filterAllBtn" onclick="applyFilter('all')">
                        Semua ({{ $students->count() + (isset($formerStudents) ? $formerStudents->count() : 0) }})
                    </button>
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3.5 py-1.5 fw-semibold" id="filterActiveBtn" onclick="applyFilter('active')">
                        Aktif ({{ $students->count() }})
                    </button>
                    @if(isset($formerStudents) && $formerStudents->count() > 0)
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3.5 py-1.5 fw-semibold" id="filterKickedBtn" onclick="applyFilter('kicked')">
                        Dikeluarkan ({{ $formerStudents->count() }})
                    </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Daftar Kartu Siswa Aktif --}}
        <div class="card-body p-4 px-md-4">
            <div class="row g-3.5" id="activeStudentsContainer">
                @forelse($students as $student)
                <div class="col-md-6 member-card-col" 
                     data-member-type="active"
                     data-member-search="{{ strtolower($student->name . ' ' . $student->email . ' ' . ($student->user_code ?? '')) }}">
                    <div class="card border rounded-4 p-3.5 p-md-4 h-100 bg-white shadow-xs hover-elevate-subtle transition" style="border: 1px solid #E2E8F0 !important;">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=52&background=E2E8F0&color=1E293B&bold=true" 
                                     class="rounded-circle flex-shrink-0 shadow-xs" width="48" height="48" alt="{{ $student->name }}" style="border: 2px solid #F1F5F9;">
                                <div class="overflow-hidden">
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.96rem;">{{ $student->name }}</h6>
                                        @if(!empty($student->user_code))
                                        <span class="badge bg-light text-secondary font-monospace border rounded-pill px-2.5 py-0.5" style="font-size: 0.68rem;">
                                            {{ $student->user_code }}
                                        </span>
                                        @endif
                                    </div>
                                    <small class="text-muted text-truncate d-block" style="font-size: 0.8rem;">
                                        <i class="fa-regular fa-envelope me-1 opacity-75"></i>{{ $student->email }}
                                    </small>
                                    <div class="d-flex align-items-center gap-2.5 mt-2 flex-wrap">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-0.5" style="font-size: 0.68rem;">
                                            <i class="fa-solid fa-circle me-1" style="font-size: 0.45rem;"></i>Aktif
                                        </span>
                                        <small class="text-muted" style="font-size: 0.74rem;">
                                            <i class="fa-regular fa-calendar-check me-1 text-success"></i>Bergabung: {{ \Carbon\Carbon::parse($student->pivot->joined_at)->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            @can('manageMembers', $classroom)
                            <div class="flex-shrink-0 ms-2">
                                <form action="{{ route('teacher.classroom.member.remove', [$classroom, $student]) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan (kick) {{ $student->name }} dari kelas? Sesuai sistem soft-delete, seluruh histori nilai dan pengumpulan tugasnya tetap tersimpan aman di database.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs hover-bg-danger" 
                                            style="font-size: 0.78rem;" title="Keluarkan / Kick Pelajar dari Kelas">
                                        <i class="fa-solid fa-user-xmark"></i>
                                        <span>Kick Pelajar</span>
                                    </button>
                                </form>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12" id="noActiveStudentsAlert">
                    <div class="text-center py-5 bg-light rounded-4 border border-dashed text-muted">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-white shadow-xs mb-3" style="width: 64px; height: 64px;">
                            <i class="fa-solid fa-user-graduate fs-3 text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Belum Ada Pelajar yang Bergabung</h6>
                        <p class="small text-muted mb-3" style="max-width: 420px; margin: 0 auto;">
                            Bagikan kode kelas <strong>{{ $classroom->code }}</strong> kepada siswa, atau klik tombol di bawah untuk menambahkan siswa secara langsung.
                        </p>
                        @can('manageMembers', $classroom)
                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-xs btn-bouncy" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fa-solid fa-user-plus me-1.5"></i>Tambah Pelajar Sekarang
                        </button>
                        @endcan
                    </div>
                </div>
                @endforelse
            </div>

            {{-- RIWAYAT PELAJAR YANG TELAH DIKELUARKAN (SOFT DELETE / OUT_AT) --}}
            @if(isset($formerStudents) && $formerStudents->count() > 0)
            <div class="mt-5 pt-4 border-top" id="formerStudentsSection">
                <div class="d-flex align-items-center justify-content-between mb-3.5 flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-clock text-secondary"></i>
                            <span>Riwayat Pelajar yang Telah Dikeluarkan</span>
                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-2.5 py-0.5">{{ $formerStudents->count() }}</span>
                        </h6>
                        <small class="text-muted">Data nilai, pengerjaan kuis, dan pengumpulan tugas tetap aman tersimpan sesuai prinsip <strong>Soft Delete</strong> (stempel waktu <code>out_at</code>).</small>
                    </div>
                </div>

                <div class="row g-3.5">
                    @foreach($formerStudents as $fStudent)
                    <div class="col-md-6 member-card-col"
                         data-member-type="kicked"
                         data-member-search="{{ strtolower($fStudent->name . ' ' . $fStudent->email . ' ' . ($fStudent->user_code ?? '')) }}">
                        <div class="card border rounded-4 p-3.5 p-md-4 h-100 bg-light border-secondary-subtle opacity-90 shadow-xs">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($fStudent->name) }}&size=52&background=94A3B8&color=fff" 
                                         class="rounded-circle flex-shrink-0" width="48" height="48" style="filter: grayscale(100%);">
                                    <div class="overflow-hidden">
                                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                            <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.96rem;">{{ $fStudent->name }}</h6>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-0.5" style="font-size: 0.65rem;">
                                                <i class="fa-solid fa-right-from-bracket me-1"></i>Keluar (Kicked)
                                            </span>
                                        </div>
                                        <small class="text-muted text-truncate d-block" style="font-size: 0.8rem;">
                                            <i class="fa-regular fa-envelope me-1 opacity-75"></i>{{ $fStudent->email }}
                                        </small>
                                        <small class="text-danger fw-semibold d-block mt-1.5" style="font-size: 0.72rem;">
                                            <i class="fa-regular fa-clock me-1"></i>Waktu Keluar: {{ \Carbon\Carbon::parse($fStudent->pivot->out_at)->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>

                                @can('manageMembers', $classroom)
                                <div class="flex-shrink-0 ms-2">
                                    <form action="{{ route('teacher.classroom.member.add', $classroom) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $fStudent->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs" 
                                                style="font-size: 0.78rem;" title="Masukkan kembali pelajar ini ke dalam kelas">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            <span>Gabungkan Lagi</span>
                                        </button>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Pesan Ketika Tidak Ada Hasil Pencarian --}}
            <div id="noMemberSearchResult" class="text-center py-5 text-muted small d-none">
                <i class="fa-solid fa-user-slash fs-3 d-block mb-2 text-secondary opacity-50"></i>
                <p class="mb-0 fw-semibold">Tidak ditemukan pelajar yang sesuai dengan filter pencarian.</p>
            </div>
        </div>
    </div>
</div>

@include('teacher.classroom.partials._add_student_modal')

@push('scripts')
<script>
let currentMemberFilter = 'all';

function applyFilter(type) {
    currentMemberFilter = type;
    
    // Update button styles
    document.querySelectorAll('#filterAllBtn, #filterActiveBtn, #filterKickedBtn').forEach(btn => {
        btn.classList.remove('btn-primary', 'text-white', 'shadow-xs');
        btn.classList.add('btn-light', 'text-dark');
    });

    if (type === 'all') {
        const btn = document.getElementById('filterAllBtn');
        if (btn) { btn.classList.remove('btn-light', 'text-dark'); btn.classList.add('btn-primary', 'text-white', 'shadow-xs'); }
    } else if (type === 'active') {
        const btn = document.getElementById('filterActiveBtn');
        if (btn) { btn.classList.remove('btn-light', 'text-dark'); btn.classList.add('btn-primary', 'text-white', 'shadow-xs'); }
    } else if (type === 'kicked') {
        const btn = document.getElementById('filterKickedBtn');
        if (btn) { btn.classList.remove('btn-light', 'text-dark'); btn.classList.add('btn-primary', 'text-white', 'shadow-xs'); }
    }

    filterMemberCards();
}

function filterMemberCards() {
    const query = (document.getElementById('memberSearchInput').value || '').toLowerCase().trim();
    const cards = document.querySelectorAll('.member-card-col');
    let visibleCount = 0;

    cards.forEach(card => {
        const type = card.getAttribute('data-member-type');
        const text = card.getAttribute('data-member-search') || '';

        const matchesQuery = !query || text.includes(query);
        const matchesType = (currentMemberFilter === 'all') || (currentMemberFilter === type);

        if (matchesQuery && matchesType) {
            card.classList.remove('d-none');
            visibleCount++;
        } else {
            card.classList.add('d-none');
        }
    });

    // Check if former section should be hidden
    const formerSection = document.getElementById('formerStudentsSection');
    if (formerSection) {
        if (currentMemberFilter === 'active') {
            formerSection.classList.add('d-none');
        } else {
            formerSection.classList.remove('d-none');
        }
    }

    // No search result feedback
    const noResultMsg = document.getElementById('noMemberSearchResult');
    if (noResultMsg) {
        if (visibleCount === 0) {
            noResultMsg.classList.remove('d-none');
        } else {
            noResultMsg.classList.add('d-none');
        }
    }
}

function copyClassCode(code) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Kode kelas ' + code + ' berhasil disalin ke clipboard!');
        });
    } else {
        alert('Kode kelas: ' + code);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    applyFilter('all');
});
</script>
@endpush
@endsection
