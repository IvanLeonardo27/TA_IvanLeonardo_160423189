@extends('layouts.app')

@section('title', 'Kalender Pembelajaran - BasaKula')

@section('content')
<div class="container-fluid py-3" style="max-width: 1240px;">
    {{-- Sleek Banner Hero Kalender Pembelajaran & GCal Export --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden text-white position-relative" 
         style="background: var(--grad-hero); border: 1px solid rgba(255,255,255,0.1) !important;">
        
        <i class="fa-solid fa-calendar-days position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2 d-none d-md-block pointer-events-none user-select-none" 
           style="font-size: 9.5rem; line-height: 0.8; z-index: 1;" aria-hidden="true"></i>

        <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" 
                         style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="fa-solid fa-calendar-check text-warning"></i>
                        <span class="small fw-semibold">Manajemen Agenda Akademik & Google Calendar</span>
                    </div>
                    
                    <h2 class="fw-bold text-white mb-2" style="letter-spacing: -0.02em;">
                        Kalender Pembelajaran BasaKula 📅
                    </h2>
                    <p class="text-white-50 mb-0 fs-6" style="max-width: 620px;">
                        Pantau tenggat waktu tugas, batas kuis, dan jadwal materi. Otomatis terhubung dan dapat disinkronkan ke Google Calendar Anda.
                    </p>
                </div>
                
                <div class="col-lg-4 text-lg-end d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                    <a href="{{ route('calendar.export_ics') }}" 
                       class="btn btn-accent rounded-pill px-4 py-2.5 shadow-sm fw-bold btn-bouncy d-inline-flex align-items-center justify-content-center gap-2 text-white">
                        <i class="fa-solid fa-cloud-arrow-down" aria-hidden="true"></i>
                        <span>Ekspor Kalender (.ics)</span>
                    </a>
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 px-3 py-1.5 rounded-pill" 
                         style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.15); color: #e2e8f0; font-size: 0.78rem;">
                        <span class="rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                        <span>Sistem Aktif & Terintegrasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @php
        $prevMonthDate = $currentDate->copy()->subMonth();
        $nextMonthDate = $currentDate->copy()->addMonth();

        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth   = $currentDate->copy()->endOfMonth();

        // 1 = Monday, 7 = Sunday
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Mon) .. 7 (Sun)
        $daysInMonth    = $currentDate->daysInMonth;

        $monthName = $currentDate->translatedFormat('F Y');
    @endphp

    <div class="row g-4">
        {{-- Kalender Grid Utama --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                {{-- Header Navigasi Bulan --}}
                <div class="card-header border-0 bg-white p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                            <i class="fa-solid fa-calendar-days fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-main mb-0">{{ $monthName }}</h4>
                            <small class="text-muted">{{ $events->count() }} Agenda Terdata di Sistem</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('calendar.index', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}" 
                           class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm fw-semibold shadow-xs" title="Bulan Sebelumnya">
                            <i class="fa-solid fa-chevron-left me-1"></i> Sebelumnya
                        </a>
                        <a href="{{ route('calendar.index', ['month' => now()->month, 'year' => now()->year]) }}" 
                           class="btn btn-light border rounded-pill px-3 py-2 btn-sm fw-bold {{ $currentDate->isCurrentMonth() && $currentDate->isCurrentYear() ? 'bg-primary-subtle text-primary border-primary' : 'text-main' }}">
                            Hari Ini
                        </a>
                        <a href="{{ route('calendar.index', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}" 
                           class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm fw-semibold shadow-xs" title="Bulan Berikutnya">
                            Berikutnya <i class="fa-solid fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>

                {{-- Indikator Legenda --}}
                <div class="px-4 py-2.5 bg-light border-top border-bottom d-flex align-items-center gap-3 flex-wrap" style="font-size:0.8rem;">
                    <span class="fw-bold text-muted me-1">Legenda Penanda:</span>
                    <span class="d-flex align-items-center gap-1.5">
                        <span class="rounded-circle" style="width:10px;height:10px;background:#EF4444;"></span>
                        <span class="fw-semibold text-main">Tenggat Tugas</span>
                    </span>
                    <span class="d-flex align-items-center gap-1.5">
                        <span class="rounded-circle" style="width:10px;height:10px;background:#8B5CF6;"></span>
                        <span class="fw-semibold text-main">Batas Kuis</span>
                    </span>
                    <span class="d-flex align-items-center gap-1.5">
                        <span class="rounded-circle" style="width:10px;height:10px;background:#3B82F6;"></span>
                        <span class="fw-semibold text-main">Materi Slide</span>
                    </span>
                </div>

                {{-- Grid Kalender --}}
                <div class="card-body p-3 p-md-4">
                    {{-- Header Nama Hari --}}
                    <div class="row g-2 text-center fw-bold text-muted mb-2" style="font-size:0.82rem;">
                        <div class="col">SEN</div>
                        <div class="col">SEL</div>
                        <div class="col">RAB</div>
                        <div class="col">KAM</div>
                        <div class="col">JUM</div>
                        <div class="col">SAB</div>
                        <div class="col text-danger">MIN</div>
                    </div>

                    {{-- Cell Tanggal --}}
                    <div class="row g-2">
                        {{-- Offset Hari Kosong Sebelum Tanggal 1 --}}
                        @for ($i = 1; $i < $startDayOfWeek; $i++)
                            <div class="col" style="min-width: 14.28%; flex: 0 0 14.28%;">
                                <div class="p-2 rounded-4 bg-light border opacity-25" style="min-height: 95px;"></div>
                            </div>
                        @endfor

                        {{-- Tanggal dalam Bulan Ini --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $isToday = ($dateStr === now()->format('Y-m-d'));
                                $dayEvents = $eventsByDate->get($dateStr, collect());
                                $hasEvents = $dayEvents->isNotEmpty();
                            @endphp
                            <div class="col" style="min-width: 14.28%; flex: 0 0 14.28%;">
                                <div class="p-2 rounded-4 border position-relative d-flex flex-column justify-content-between calendar-day-cell {{ $isToday ? 'border-2 border-primary bg-primary-subtle shadow-sm' : ($hasEvents ? 'bg-white shadow-xs' : 'bg-light bg-opacity-50') }}" 
                                     style="min-height: 95px; transition: all .2s ease;">

                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="fw-bold small {{ $isToday ? 'badge bg-primary text-white rounded-circle p-1.5' : 'text-main' }}" 
                                              style="{{ $isToday ? 'width:24px;height:24px;display:inline-flex;align-items:center;justify-content:center;' : 'font-size:0.9rem;' }}">
                                            {{ $day }}
                                        </span>
                                        @if($hasEvents)
                                            <span class="badge bg-danger rounded-pill px-1.5 py-0.5 text-white" style="font-size: 0.65rem;" title="{{ $dayEvents->count() }} Agenda">
                                                {{ $dayEvents->count() }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Event Pills di dalam Tanggal --}}
                                    <div class="d-flex flex-column gap-1 overflow-hidden">
                                        @foreach($dayEvents->take(2) as $ev)
                                            <a href="{{ $ev['url'] }}" 
                                               class="badge rounded-pill text-truncate text-start px-2 py-1 text-decoration-none shadow-xs d-block" 
                                               style="background: {{ $ev['bg_color'] }}; color: #ffffff; font-size: 0.68rem;"
                                               title="{{ $ev['type_label'] }}: {{ $ev['title'] }} ({{ $ev['classroom'] }})">
                                                <i class="{{ $ev['icon'] }} me-0.5"></i> {{ $ev['title'] }}
                                            </a>
                                        @endforeach
                                        @if($dayEvents->count() > 2)
                                            <span class="badge bg-secondary bg-opacity-25 text-dark rounded-pill py-0.5" style="font-size: 0.62rem;">
                                                +{{ $dayEvents->count() - 2 }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Kanan: Daftar Agenda Mendatang & Aktivitas --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-list-check text-primary"></i> Agenda Terdekat & Pengingat
                </h5>

                <div class="d-flex flex-column gap-3">
                    @forelse($upcomingEvents->take(5) as $ue)
                    <div class="p-3 rounded-4 border position-relative" style="background: #F8FAFC; border-left: 4px solid {{ $ue['bg_color'] }} !important;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge {{ $ue['badge_class'] }} rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                <i class="{{ $ue['icon'] }} me-1"></i> {{ $ue['type_label'] }}
                            </span>
                            <small class="text-muted fw-semibold" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-clock me-1"></i> {{ $ue['time'] }} WIB
                            </small>
                        </div>

                        <h6 class="fw-bold text-main mb-1 mt-2" style="font-size: 0.95rem;">{{ $ue['title'] }}</h6>
                        <small class="text-muted d-block mb-2">
                            <i class="fa-solid fa-chalkboard-user me-1 text-primary"></i> {{ $ue['classroom'] }}
                        </small>

                        <div class="d-flex align-items-center justify-content-between pt-2 border-top gap-1 flex-wrap">
                            <a href="{{ $ue['gcal_url'] }}" target="_blank" class="btn btn-light border rounded-pill px-2.5 py-1 btn-sm fw-semibold text-muted shadow-xs d-flex align-items-center gap-1" style="font-size: 0.72rem;" title="Tambahkan Pengingat ke Google Calendar">
                                <i class="fa-brands fa-google text-danger"></i> <span>+ GCal</span>
                            </a>
                            <div class="d-flex align-items-center gap-1">
                                <span class="badge {{ $ue['status'] === 'submitted' ? 'bg-success text-white' : ($ue['status'] === 'overdue' ? 'bg-danger text-white' : 'bg-light text-muted border') }} rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    {{ $ue['status_label'] }}
                                </span>
                                <a href="{{ $ue['url'] }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold btn-bouncy" style="font-size: 0.78rem;">
                                    Buka <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-muted mb-2" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-calendar-check fs-4"></i>
                        </div>
                        <p class="text-muted small mb-0">Tidak ada agenda akademik mendatang yang perlu diselesaikan.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Ringkasan Statistik Siswa --}}
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1px solid #E2E8F0 !important;">
                <h6 class="fw-bold text-main mb-3">
                    <i class="fa-solid fa-chart-pie text-primary me-1"></i> Ringkasan Aktivitas Anda
                </h6>
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-4 border shadow-xs">
                            <div class="fw-bold fs-4 text-danger">{{ $events->where('type', 'assignment')->count() }}</div>
                            <small class="text-muted" style="font-size:0.72rem;">Tugas</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-4 border shadow-xs">
                            <div class="fw-bold fs-4 text-purple" style="color:#8B5CF6;">{{ $events->where('type', 'quiz')->count() }}</div>
                            <small class="text-muted" style="font-size:0.72rem;">Kuis</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-4 border shadow-xs">
                            <div class="fw-bold fs-4 text-primary">{{ $events->where('type', 'material')->count() }}</div>
                            <small class="text-muted" style="font-size:0.72rem;">Materi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
