@extends('layouts.app')

@section('title', 'Log Aktivitas Pembelajaran - Admin BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.15); width: 54px; height: 54px;">
                    <i class="fa-solid fa-clock-rotate-left text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-white mb-1">Log Aktivitas Interaksi Pembelajaran</h4>
                    <p class="text-white-50 small mb-0">Pantau seluruh riwayat interaksi akademik antara pengajar dan pelajar secara real-time.</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 rounded-pill px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-bolt text-warning me-1.5"></i> {{ $stats['total_activities'] }} Total Interaksi
                </span>
                <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 rounded-pill px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-chalkboard-user me-1.5"></i> {{ $stats['teacher_activities'] }} Pengajar
                </span>
                <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 rounded-pill px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-user-graduate me-1.5"></i> {{ $stats['student_activities'] }} Pelajar
                </span>
            </div>
        </div>
    </div>

    {{-- Filter & Search Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="card-body p-3.5">
            <form action="{{ route('admin.activities.index') }}" method="GET" class="row g-2.5 align-items-center">
                {{-- Search Input --}}
                <div class="col-lg-5 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control bg-light border-start-0 rounded-end-pill py-2" 
                               placeholder="Cari nama, email, kode (277...), atau aktivitas..." 
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Role Filter --}}
                <div class="col-lg-3 col-md-6">
                    <select name="role" class="form-select rounded-pill bg-light py-2" onchange="this.form.submit()">
                        <option value="all" {{ request('role', 'all') === 'all' ? 'selected' : '' }}>Semua Peran (Pengajar & Pelajar)</option>
                        <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>👨‍🏫 Pengajar (Guru)</option>
                        <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>🎓 Pelajar (Siswa)</option>
                    </select>
                </div>

                {{-- Action Type Filter --}}
                <div class="col-lg-3 col-md-8">
                    <select name="action" class="form-select rounded-pill bg-light py-2" onchange="this.form.submit()">
                        <option value="all" {{ request('action', 'all') === 'all' ? 'selected' : '' }}>Semua Jenis Aktivitas</option>
                        <option value="classroom" {{ request('action') === 'classroom' ? 'selected' : '' }}>🏫 Ruang Kelas (Buat & Gabung)</option>
                        <option value="post" {{ request('action') === 'post' ? 'selected' : '' }}>📢 Materi & Pengumuman</option>
                        <option value="submission" {{ request('action') === 'submission' ? 'selected' : '' }}>📝 Pengumpulan & Nilai Tugas</option>
                        <option value="quiz" {{ request('action') === 'quiz' ? 'selected' : '' }}>🏆 Pengerjaan Evaluasi & Kuis</option>
                        <option value="comment" {{ request('action') === 'comment' ? 'selected' : '' }}>💬 Diskusi Komentar</option>
                    </select>
                </div>

                {{-- Submit & Reset Buttons --}}
                <div class="col-lg-1 col-md-4 text-end">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-dark rounded-pill py-2 px-3 fw-semibold w-100" title="Cari / Terapkan Filter">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        @if(request()->hasAny(['search', 'role', 'action']) && (request('search') || request('role') !== 'all' || request('action') !== 'all'))
                        <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary rounded-pill py-2 px-3" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Activity Feed Stream --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="card-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-main mb-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-stream text-primary"></i> Linimasa Aktivitas Terkini
            </h6>
            <span class="text-muted small">Menampilkan {{ $paginatedLogs->count() }} dari {{ $paginatedLogs->total() }} riwayat</span>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column gap-3">
                @forelse($paginatedLogs as $log)
                @php
                    $isTeacher = ($log['role'] === 'teacher');
                    $borderAccent = $isTeacher ? '#16402E' : '#0284C7';
                    $iconBg = $isTeacher ? 'background: #E8F5E9; color: #16402E;' : 'background: #E0F2FE; color: #0369A1;';
                    $roleBadgeClass = $isTeacher ? 'background: #DCFCE7; color: #166534;' : 'background: #E0F2FE; color: #075985;';
                @endphp
                <div class="p-3 p-md-3.5 rounded-4 border bg-white shadow-xs position-relative transition-all hover-lift" 
                     style="border-left: 4.5px solid {{ $borderAccent }} !important; border-color: #E2E8F0;">
                    <div class="d-flex align-items-start gap-3">
                        {{-- Icon Avatar --}}
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                             style="width: 44px; height: 44px; {{ $iconBg }} font-size: 1.15rem;">
                            <i class="{{ $log['icon'] }}"></i>
                        </div>

                        {{-- Main Body --}}
                        <div class="flex-grow-1 overflow-hidden">
                            {{-- Header Actor Info & Time --}}
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1.5">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    {{-- Role Pill --}}
                                    <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="{{ $roleBadgeClass }} font-size: 0.73rem;">
                                        {{ $log['role_label'] }}
                                    </span>

                                    {{-- User Code --}}
                                    @if(!empty($log['actor_code']) && $log['actor_code'] !== '-')
                                    <span class="d-inline-flex align-items-center font-monospace px-2.5 py-0.5 rounded-pill border" 
                                          style="background: #F8FAFC; color: #475569; font-size: 0.76rem;">
                                        {{ $log['actor_code'] }}
                                    </span>
                                    @endif

                                    {{-- Actor Name --}}
                                    <strong class="text-dark" style="font-size: 0.95rem;">
                                        {{ $log['actor_name'] }}
                                    </strong>
                                </div>

                                {{-- Timestamp --}}
                                <div class="text-muted small fw-medium d-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                                    <i class="fa-regular fa-clock text-secondary"></i>
                                    <span>{{ $log['timestamp'] ? \Carbon\Carbon::parse($log['timestamp'])->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            {{-- Description Text --}}
                            <div class="text-secondary mb-2" style="font-size: 0.92rem; line-height: 1.55;">
                                {{ $log['description'] }}
                            </div>

                            {{-- Meta Badges --}}
                            <div class="d-flex align-items-center gap-2.5 flex-wrap small text-muted" style="font-size: 0.78rem;">
                                <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1">
                                    <i class="fa-solid fa-tag me-1 opacity-75"></i> {{ $log['action'] }}
                                </span>
                                @if(!empty($log['target']))
                                <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">
                                    <i class="fa-solid fa-location-dot text-primary me-1"></i> {{ $log['target'] }}
                                </span>
                                @endif
                                @if(!empty($log['actor_email']) && $log['actor_email'] !== '-')
                                <span class="text-muted d-inline-flex align-items-center gap-1">
                                    <i class="fa-regular fa-envelope"></i> {{ $log['actor_email'] }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-clipboard-list fs-2 text-muted opacity-50"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Belum Ada Aktivitas Terekam</h6>
                    <p class="text-muted small mb-0">Tidak ditemukan data log aktivitas interaksi yang sesuai dengan filter saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        @if($paginatedLogs->hasPages())
        <div class="p-3.5 border-top d-flex justify-content-end bg-light bg-opacity-25">
            {{ $paginatedLogs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
