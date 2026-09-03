@extends('layouts.app')

@section('title', 'Log Aktivitas Pembelajaran - Admin BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Flash Notifications --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
                <span class="badge rounded-pill px-3 py-2 fw-bold shadow-xs" style="background: #ffffff; color: #0d3b2e !important; font-size: 0.84rem; border: none;">
                    <i class="text-warning me-1.5"></i> {{ number_format($stats['total_activities']) }} Total Interaksi
                </span>
                <span class="badge rounded-pill px-3 py-2 fw-bold shadow-xs" style="background: #ffffff; color: #0d3b2e !important; font-size: 0.84rem; border: none;">
                    <i class="text-success me-1.5"></i> {{ number_format($stats['teacher_activities']) }} Pengajar
                </span>
                <span class="badge rounded-pill px-3 py-2 fw-bold shadow-xs" style="background: #ffffff; color: #0d3b2e !important; font-size: 0.84rem; border: none;">
                    <i class="text-primary me-1.5"></i> {{ number_format($stats['student_activities']) }} Pelajar
                </span>
                @if(isset($stats['admin_activities']) && $stats['admin_activities'] > 0)
                <span class="badge rounded-pill px-3 py-2 fw-bold shadow-xs" style="background: #ffffff; color: #0d3b2e !important; font-size: 0.84rem; border: none;">
                    <i class="text-danger me-1.5"></i> {{ number_format($stats['admin_activities']) }} Admin
                </span>
                @endif
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
                        <option value="all" {{ request('role', 'all') === 'all' ? 'selected' : '' }}>Semua Peran</option>
                        <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>👨‍🏫 Pengajar (Guru)</option>
                        <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>🎓 Pelajar (Siswa)</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>🛡️ Administrator</option>
                    </select>
                </div>

                {{-- Action Type Filter --}}
                <div class="col-lg-3 col-md-8">
                    <select name="action" class="form-select rounded-pill bg-light py-2" onchange="this.form.submit()">
                        <option value="all" {{ request('action', 'all') === 'all' ? 'selected' : '' }}>Semua Jenis Aktivitas</option>
                        <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>🔑 Masuk ke Sistem (Login)</option>
                        <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>🚪 Keluar Sistem (Logout)</option>
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
        <div class="card-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="fw-bold text-main mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-stream text-primary"></i> Linimasa Aktivitas Terkini
                </h6>
                <span class="text-muted small">Menampilkan {{ $paginatedLogs->count() }} dari {{ $paginatedLogs->total() }} riwayat</span>
            </div>

            {{-- Tombol Aksi Log Aktivitas (Reset & Restore) --}}
            <div class="d-flex align-items-center gap-2">
                @if(isset($retention['trashed_logs']) && $retention['trashed_logs'] > 0)
                {{-- Tombol Pulihkan Log yang diarsipkan via Soft Delete --}}
                <form action="{{ route('admin.activities.restore') }}" method="POST" class="d-inline" onsubmit="return confirm('Pulihkan data log aktivitas yang sebelumnya direset?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs" title="Pulihkan log terarsip">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Pulihkan Log ({{ number_format($retention['trashed_logs']) }})</span>
                    </button>
                </form>
                @endif

                @if(!$retention['can_reset'])
                    {{-- Tombol Nonaktif (Masa Pencatatan < 90 Hari): Menampilkan Modal Informasi Kebijakan --}}
                    <button type="button" 
                            class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs opacity-75"
                            data-bs-toggle="modal" 
                            data-bs-target="#resetLogRestrictionModal"
                            title="Reset log belum dapat dilakukan (Masa pencatatan < 90 hari)">
                        <i class="fa-solid fa-lock text-warning"></i>
                        <span>Reset Log Aktivitas</span>
                        <span class="badge bg-secondary-subtle text-secondary border rounded-pill" style="font-size: 0.7rem;">
                            &lt; 90 Hari
                        </span>
                    </button>
                @else
                    {{-- Tombol Aktif (Masa Pencatatan >= 90 Hari) --}}
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs"
                            data-bs-toggle="modal" 
                            data-bs-target="#resetLogConfirmationModal"
                            title="Buka konfirmasi reset log aktivitas (Soft Deletes)">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Reset Log Aktivitas</span>
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column gap-3">
                @forelse($paginatedLogs as $log)
                @php
                    $role = $log->role ?? $log['role'];
                    $isAdmin = ($role === 'admin');
                    $isTeacher = ($role === 'teacher');
                    $borderAccent = $isAdmin ? '#D97706' : ($isTeacher ? '#16402E' : '#0284C7');
                    $iconBg = $isAdmin ? 'background: #FEF3C7; color: #B45309;' : ($isTeacher ? 'background: #E8F5E9; color: #16402E;' : 'background: #E0F2FE; color: #0369A1;');
                    $roleBadgeClass = $isAdmin ? 'background: #FEF3C7; color: #92400E;' : ($isTeacher ? 'background: #DCFCE7; color: #166534;' : 'background: #E0F2FE; color: #075985;');
                @endphp
                <div class="p-3 p-md-3.5 rounded-4 border bg-white shadow-xs position-relative transition-all hover-lift" 
                     style="border-left: 4.5px solid {{ $borderAccent }} !important; border-color: #E2E8F0;">
                    <div class="d-flex align-items-start gap-3">
                        {{-- Icon Avatar (Diambil dinamis dari Accessor Model) --}}
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                             style="width: 44px; height: 44px; {{ $iconBg }} font-size: 1.15rem;">
                            <i class="{{ $log->icon }}"></i>
                        </div>

                        {{-- Main Body --}}
                        <div class="flex-grow-1 overflow-hidden">
                            {{-- Header Actor Info & Time --}}
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1.5">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    {{-- Role Pill --}}
                                    <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="{{ $roleBadgeClass }} font-size: 0.73rem;">
                                        {{ $log->role_label }}
                                    </span>

                                    {{-- User Code --}}
                                    @php $code = $log->code ?? ($log['code'] ?? '-'); @endphp
                                    @if(!empty($code) && $code !== '-')
                                    <span class="d-inline-flex align-items-center font-monospace px-2.5 py-0.5 rounded-pill border" 
                                          style="background: #F8FAFC; color: #475569; font-size: 0.76rem;">
                                        {{ $code }}
                                    </span>
                                    @endif

                                    {{-- User Name --}}
                                    <strong class="text-dark" style="font-size: 0.95rem;">
                                        {{ $log->name ?? ($log['name'] ?? '-') }}
                                    </strong>
                                </div>

                                {{-- Timestamp --}}
                                <div class="text-muted small fw-medium d-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                                    <i class="fa-regular fa-clock text-secondary"></i>
                                    <span>{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            {{-- Description Text --}}
                            <div class="text-secondary mb-2" style="font-size: 0.92rem; line-height: 1.55;">
                                {{ $log->description ?? ($log['description'] ?? '') }}
                            </div>

                            {{-- Meta Badges --}}
                            <div class="d-flex align-items-center gap-2.5 flex-wrap small text-muted" style="font-size: 0.78rem;">
                                <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1">
                                    <i class="fa-solid fa-tag me-1 opacity-75"></i> {{ $log->action }}
                                </span>
                                @if(!empty($log->target))
                                <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">
                                    <i class="fa-solid fa-location-dot text-primary me-1"></i> {{ $log->target }}
                                </span>
                                @endif
                                @php $email = $log->email ?? ($log['email'] ?? '-'); @endphp
                                @if(!empty($email) && $email !== '-')
                                <span class="text-muted d-inline-flex align-items-center gap-1">
                                    <i class="fa-regular fa-envelope"></i> {{ $email }}
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

{{-- MODAL PERINGATAN / LARANGAN RESET LOG (< 90 HARI) --}}
<div class="modal fade" id="resetLogRestrictionModal" tabindex="-1" aria-labelledby="resetLogRestrictionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 text-warning">
                    <div class="rounded-3 bg-warning-subtle text-warning p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-6" id="resetLogRestrictionModalLabel">Kebijakan Retensi Log Aktivitas</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="alert alert-warning border-0 rounded-3 mb-3 small d-flex align-items-start gap-2.5">
                    <i class="fa-solid fa-shield-halved fs-5 mt-0.5 text-warning flex-shrink-0"></i>
                    <div>
                        <strong class="d-block mb-1 text-dark">Tombol Reset Log Dinonaktifkan</strong>
                        Sesuai standar audit akademik, log interaksi dilarang dihapus jika masa pencatatan masih <strong>di bawah 3 bulan (kurang dari 90 hari)</strong> untuk menjamin keamanan rekam jejak pembelajaran.
                    </div>
                </div>

                <div class="bg-light p-3 rounded-3 border mb-3 small space-y-2">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted"><i class="fa-regular fa-calendar me-1.5"></i> Awal Pencatatan Log:</span>
                        <strong class="text-dark">{{ $retention['start_date']->translatedFormat('d F Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted"><i class="fa-regular fa-clock me-1.5"></i> Masa Aktif Berjalan:</span>
                        <span class="badge bg-secondary-subtle text-secondary fw-bold px-2 py-1">{{ $retention['days_active'] }} Hari</span>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted"><i class="fa-solid fa-hourglass-half me-1.5"></i> Sisa Masa Tunggu:</span>
                        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-2 py-1">{{ $retention['days_remaining'] }} Hari Lagi</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span class="text-muted"><i class="fa-solid fa-database me-1.5"></i> Total Riwayat Saat Ini:</span>
                        <strong class="text-dark">{{ number_format($retention['total_logs']) }} data</strong>
                    </div>
                </div>

                <div class="p-3 rounded-3 border text-center" style="background: #FFFBEB; border-color: #FDE68A !important;">
                    <div class="text-muted small mb-1">Pemberitahuan Jadwal Reset:</div>
                    <div class="fw-black fs-6" style="color: #92400E;">
                        Reset log baru dapat dilakukan pada tanggal:
                    </div>
                    <div class="fs-5 fw-bold text-success mt-1">
                        {{ $retention['eligible_date']->translatedFormat('d F Y') }}
                    </div>
                    <div class="text-muted" style="font-size: 0.75rem; margin-top: 4px;">
                        (Tepat 3 bulan + 1 hari terhitung dari tanggal pencatatan sistem)
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold" data-bs-dismiss="modal">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI RESET LOG (>= 90 HARI) --}}
@if($retention['can_reset'])
<div class="modal fade" id="resetLogConfirmationModal" tabindex="-1" aria-labelledby="resetLogConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <div class="rounded-3 bg-danger-subtle text-danger p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-trash-can fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-6" id="resetLogConfirmationModalLabel">Konfirmasi Reset Seluruh Log</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.activities.reset') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <p class="text-secondary small mb-3">
                        Masa pencatatan log telah melampaui masa retensi wajib <strong>90 hari (3 bulan)</strong>. Anda diperbolehkan melakukan pembersihan riwayat log pada antarmuka sistem.
                    </p>
                    <div class="alert alert-info border-0 rounded-3 mb-0 small text-dark" style="background: #F0FDF4; border: 1px solid #BBF7D0 !important;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-shield-check text-success fs-5 mt-0.5"></i>
                            <div>
                                <strong class="text-success-emphasis">Sistem Arsip Aman (Soft Deletes):</strong><br>
                                Seluruh <strong>{{ number_format($retention['total_logs']) }} data riwayat</strong> akan dibersihkan dari tampilan antarmuka, namun <strong>tetap tersimpan utuh di basis data MySQL</strong> dan dapat diakses sewaktu-waktu oleh administrator database untuk kebutuhan pelaporan & audit.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 px-4 fw-semibold flex-grow-1" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill py-2 px-4 fw-semibold flex-grow-1">
                        Ya, Reset Seluruh Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
