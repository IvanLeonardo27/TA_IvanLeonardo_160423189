@extends('layouts.app')

@section('title', 'Kalender Pembelajaran - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Banner Penjelasan Fitur Kalender Pembelajaran & Integrasi Google Calendar --}}
    <div class="row g-4 mb-4">
        {{-- Card 1: Fitur Kalender Pembelajaran --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #1E4D3B 0%, #153B2D 100%); color: #ffffff;">
                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1.5 fw-bold" style="font-size:0.8rem;">
                                <i class="fa-solid fa-calendar-days me-1 text-accent"></i> Manajemen Agenda Akademik
                            </span>
                        </div>
                        <h3 class="fw-bold mb-3 text-white">Fitur Kalender Pembelajaran</h3>
                        <p class="text-white-50 mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                            Fitur ini digunakan untuk membantu siswa mengelola aktivitas pembelajaran dan mengingat berbagai agenda akademik yang akan datang. Sistem menyediakan kalender pembelajaran yang menampilkan jadwal tugas, kuis, maupun kegiatan pembelajaran berdasarkan tanggal pelaksanaannya. Apabila pengajar menambahkan tugas atau kuis dengan batas waktu tertentu, sistem akan secara otomatis menampilkan penanda pada tanggal yang bersangkutan di dalam kalender sehingga siswa dapat mengetahui agenda yang harus diselesaikan.
                        </p>
                    </div>
                    <div class="pt-4 border-top border-white border-opacity-10 mt-3 d-flex align-items-center justify-content-between">
                        <span class="small text-white-50"><i class="fa-solid fa-clock-rotate-left me-1"></i> Penanda tanggal diperbarui otomatis</span>
                        <span class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            ● Sistem Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Integrasi Google Calendar --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); color: #ffffff;">
                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary bg-opacity-20 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1.5 fw-bold" style="font-size:0.8rem;">
                                <i class="fa-brands fa-google me-1 text-primary"></i> Google Calendar API
                            </span>
                        </div>
                        <h3 class="fw-bold mb-3 text-white">Integrasi Google Calendar</h3>
                        <p class="text-white-50 mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                            Untuk meningkatkan efektivitas pengelolaan aktivitas pembelajaran, sistem akan terintegrasi dengan layanan Google Calendar melalui Google Calendar API. Integrasi ini memungkinkan jadwal tugas, kuis, maupun kegiatan pembelajaran yang ditambahkan oleh pengajar untuk disinkronkan secara otomatis ke kalender pengguna. Dengan demikian, siswa dapat menerima pengingat (reminder) melalui Google Calendar dan lebih mudah memantau seluruh aktivitas pembelajaran dari berbagai perangkat yang digunakan. Fitur ini diharapkan dapat membantu mengurangi kemungkinan siswa lupa terhadap jadwal tugas maupun kegiatan pembelajaran yang akan datang.
                        </p>
                    </div>
                    <div class="pt-4 border-top border-white border-opacity-10 mt-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <a href="{{ route('calendar.export_ics') }}" class="btn btn-primary rounded-pill px-4 py-2 btn-sm fw-bold btn-bouncy shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-down me-1.5"></i> Ekspor Kalender (.ics)
                        </a>
                        <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            <i class="fa-solid fa-sync fa-spin me-1"></i> Siap Disinkronkan
                        </span>
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
                                <div class="p-2 rounded-4 border position-relative d-flex flex-column justify-content-between {{ $isToday ? 'border-2 border-primary bg-primary-subtle shadow-sm' : ($hasEvents ? 'bg-white shadow-xs' : 'bg-light bg-opacity-50') }}" 
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
