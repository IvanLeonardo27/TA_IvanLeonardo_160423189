@extends('layouts.app')

@section('title', 'Kalender Pembelajaran - BasaKula')

@section('content')
<div class="container-fluid py-3" style="max-width: 1240px;">
    {{-- Sleek Banner Hero Kalender Pembelajaran & GCal Export --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden text-white position-relative" 
         style="background: var(--grad-hero); border: 1px solid rgba(255,255,255,0.1) !important;">
        
        <i class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2 d-none d-md-block pointer-events-none user-select-none" 
           style="font-size: 9.5rem; line-height: 0.8; z-index: 1;" aria-hidden="true"></i>

        <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" 
                         style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="fa-solid fa-calendar-check text-warning me-1.5"></i>
                        <span class="small fw-semibold">Manajemen Agenda Akademik & Google Calendar</span>
                    </div>
                    
                    <h2 class="fw-bold text-white mb-2 d-flex align-items-center gap-2 flex-wrap" style="letter-spacing: -0.02em;">
                        <span>Kalender Pembelajaran BasaKula</span>
                        <i class="fa-solid fa-calendar-days text-warning fs-3 ms-1" aria-hidden="true"></i>
                    </h2>
                    <p class="text-white-50 mb-0 fs-6" style="max-width: 620px;">
                        Pantau tenggat waktu tugas, batas kuis, dan jadwal materi. Otomatis terhubung dan dapat disinkronkan ke Google Calendar Anda.
                    </p>
                </div>
                
                <div class="col-lg-4 text-lg-end d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                    <button type="button" 
                            class="btn btn-warning rounded-pill px-4 py-2.5 shadow-sm fw-bold btn-bouncy d-inline-flex align-items-center justify-content-center gap-2 text-dark"
                            data-bs-toggle="modal" data-bs-target="#createEventModal"
                            onclick="prepareCreateEvent()">
                        <i class="fa-solid fa-calendar-plus me-1.5" aria-hidden="true"></i>
                        <span>+ Buat Jadwal Acara</span>
                    </button>
                    <a href="{{ route('calendar.export_pdf', ['month' => $month, 'year' => $year]) }}" 
                       class="btn btn-accent rounded-pill px-4 py-2.5 shadow-sm fw-bold btn-bouncy d-inline-flex align-items-center justify-content-center gap-2 text-white">
                        <i class="fa-solid fa-file-pdf me-1.5" aria-hidden="true"></i>
                        <span>Ekspor Kalender (PDF)</span>
                    </a>
                    <div class="d-inline-flex align-items-center justify-content-center px-3 py-1.5 rounded-pill" 
                         style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.15); color: #e2e8f0; font-size: 0.78rem;">
                        <i class="fa-brands fa-google text-danger me-1.5"></i>
                        <span>Sinkron Resmi Google Calendar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Notifikasi Status --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4 d-flex align-items-center gap-2" role="alert">
        <i class="fa-solid fa-circle-check fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error') || (isset($errors) && $errors->any()))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4" role="alert">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="fa-solid fa-circle-exclamation fs-5"></i>
            <strong>Terjadi kendala pada jadwal acara:</strong>
        </div>
        <ul class="mb-0 small ps-4">
            @if(isset($errors))
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


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
                <div class="card-header border-0 bg-white p-3 p-md-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                             style="width:48px;height:48px; background: rgba(31, 77, 58, 0.12); color: #1F4D3A;">
                            <i class="fa-solid fa-calendar-days fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-main mb-0">{{ $monthName }}</h4>
                            <small class="text-muted">{{ $events->count() }} Agenda Terdata di Sistem</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('calendar.index', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}" 
                           class="btn btn-outline-secondary rounded-pill px-3 py-1.5 btn-sm fw-semibold shadow-xs d-inline-flex align-items-center" title="Bulan Sebelumnya">
                            <i class="fa-solid fa-chevron-left me-1.5"></i> <span>Sebelumnya</span>
                        </a>
                        <a href="{{ route('calendar.index', ['month' => now()->month, 'year' => now()->year]) }}" 
                           class="btn btn-light border rounded-pill px-3 py-1.5 btn-sm fw-bold {{ $currentDate->isCurrentMonth() && $currentDate->isCurrentYear() ? 'bg-primary-subtle text-primary border-primary' : 'text-main' }}">
                            Hari Ini
                        </a>
                        <a href="{{ route('calendar.index', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}" 
                           class="btn btn-outline-secondary rounded-pill px-3 py-1.5 btn-sm fw-semibold shadow-xs d-inline-flex align-items-center" title="Bulan Berikutnya">
                            <span>Berikutnya</span> <i class="fa-solid fa-chevron-right ms-1.5"></i>
                        </a>
                    </div>
                </div>

                {{-- Indikator Legenda --}}
                <div class="px-2 px-sm-3 px-md-4 py-2 bg-light border-top border-bottom d-flex align-items-center gap-1.5 gap-sm-2 flex-wrap" style="font-size:0.82rem;">
                    <span class="fw-bold text-muted me-1 d-inline-flex align-items-center">
                        <i class="fa-solid fa-circle-info text-secondary me-1.5"></i> Legenda:
                    </span>
                    <span class="d-inline-flex align-items-center px-2.5 py-1 rounded-pill bg-white border shadow-xs me-1">
                        <span class="rounded-circle me-1.5 flex-shrink-0" style="width:10px;height:10px;background:#DC2626;"></span>
                        <span class="fw-semibold text-danger">Tanggal Merah</span>
                    </span>
                    <span class="d-inline-flex align-items-center px-2.5 py-1 rounded-pill bg-white border shadow-xs me-1">
                        <span class="rounded-circle me-1.5 flex-shrink-0" style="width:10px;height:10px;background:#10B981;"></span>
                        <span class="fw-semibold text-success">Jadwal Pribadi</span>
                    </span>
                    <span class="d-inline-flex align-items-center px-2.5 py-1 rounded-pill bg-white border shadow-xs me-1">
                        <span class="rounded-circle me-1.5 flex-shrink-0" style="width:10px;height:10px;background:#EF4444;"></span>
                        <span class="fw-semibold text-dark">Tenggat Tugas</span>
                    </span>
                    <span class="d-inline-flex align-items-center px-2.5 py-1 rounded-pill bg-white border shadow-xs me-1">
                        <span class="rounded-circle me-1.5 flex-shrink-0" style="width:10px;height:10px;background:#8B5CF6;"></span>
                        <span class="fw-semibold text-dark">Batas Kuis</span>
                    </span>
                    <span class="d-inline-flex align-items-center px-2.5 py-1 rounded-pill bg-white border shadow-xs">
                        <span class="rounded-circle me-1.5 flex-shrink-0" style="width:10px;height:10px;background:#3B82F6;"></span>
                        <span class="fw-semibold text-dark">Materi Slide</span>
                    </span>
                </div>

                {{-- Grid Kalender --}}
                <div class="card-body p-2 p-sm-3 p-md-4 pt-1">
                    {{-- Header Nama Hari --}}
                    <div class="row g-1 g-sm-2 text-center fw-bold text-muted mb-2" style="font-size:0.82rem;">
                        <div class="col">SEN</div>
                        <div class="col">SEL</div>
                        <div class="col">RAB</div>
                        <div class="col">KAM</div>
                        <div class="col">JUM</div>
                        <div class="col">SAB</div>
                        <div class="col text-danger">MIN</div>
                    </div>

                    {{-- Cell Tanggal --}}
                    <div class="row g-1 g-sm-2">
                        {{-- Offset Hari Kosong Sebelum Tanggal 1 --}}
                        @for ($i = 1; $i < $startDayOfWeek; $i++)
                            <div class="col" style="min-width: 14.28%; flex: 0 0 14.28%;">
                                <div class="calendar-day-cell bg-light border opacity-25"></div>
                            </div>
                        @endfor

                        {{-- Tanggal dalam Bulan Ini --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateObj   = Carbon\Carbon::createFromDate($year, $month, $day);
                                $dateStr   = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $isToday   = ($dateStr === now()->format('Y-m-d'));
                                $isSunday  = $dateObj->isSunday();
                                $holiday   = $holidays[$dateStr] ?? null;
                                $isHoliday = !empty($holiday);
                                $isRedDate = $isSunday || $isHoliday;
                                $dayEvents = $eventsByDate->get($dateStr, collect());
                                $hasEvents = $dayEvents->isNotEmpty();
                                $hasPersonalEvents = $dayEvents->where('type', 'personal')->isNotEmpty();
                            @endphp
                            <div class="col" style="min-width: 14.28%; flex: 0 0 14.28%;">
                                <div class="border position-relative d-flex flex-column justify-content-between calendar-day-cell {{ $isToday ? 'border-2 border-primary bg-primary-subtle shadow-sm' : ($isHoliday ? 'border-danger-subtle bg-danger-subtle bg-opacity-25' : ($hasPersonalEvents ? 'border-success-subtle bg-success-subtle bg-opacity-15' : ($hasEvents ? 'bg-white shadow-xs' : ($isSunday ? 'bg-light bg-opacity-75' : 'bg-white shadow-xs')))) }}" 
                                     onclick="openDayDetailModal('{{ $dateObj->translatedFormat('l, d F Y') }}', '{{ $dateStr }}', {{ json_encode($holiday) }}, {{ json_encode($dayEvents->values()) }})"
                                     title="Klik untuk melihat agenda atau menambah jadwal pribadi pada {{ $dateObj->translatedFormat('d F Y') }}">

                                    <div class="d-flex align-items-center justify-content-between mb-0 mb-sm-1">
                                        <span class="fw-bold {{ $isToday ? 'badge bg-primary text-white rounded-circle p-1' : ($isRedDate ? 'text-danger fw-bold' : 'text-main') }}" 
                                              style="{{ $isToday ? 'width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;' : 'font-size:clamp(0.78rem, 2.4vw, 0.95rem);' }}">
                                            {{ $day }}
                                        </span>
                                        @if($isHoliday)
                                            <span class="badge bg-danger rounded-pill p-1 text-white shadow-xs" style="font-size: 0.52rem; line-height: 1;" title="{{ $holiday['name'] }}">
                                                <i class="fa-solid fa-flag" style="font-size: 0.48rem;"></i>
                                            </span>
                                        @elseif($hasPersonalEvents)
                                            <span class="badge bg-success rounded-pill p-1 text-white shadow-xs" style="font-size: 0.52rem; line-height: 1;" title="Ada Jadwal Pribadi">
                                                <i class="fa-solid fa-calendar-check" style="font-size: 0.48rem;"></i>
                                            </span>
                                        @elseif($hasEvents)
                                            <span class="badge bg-primary rounded-pill p-1 text-white" style="font-size: 0.58rem; min-width: 16px; text-align: center;" title="{{ $dayEvents->count() }} Agenda">
                                                {{ $dayEvents->count() }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Event Pills & Tanggal Merah di Layar Desktop (md+) --}}
                                    <div class="d-none d-md-flex flex-column gap-1 overflow-hidden">
                                        @if($isHoliday)
                                            <div class="badge rounded-pill text-truncate text-start px-2 py-0.5 shadow-xs d-block text-white" 
                                                 style="background: #DC2626; font-size: 0.64rem;"
                                                 title="Tanggal Merah: {{ $holiday['name'] }}">
                                                <i class="fa-solid fa-flag me-0.5"></i> {{ $holiday['name'] }}
                                            </div>
                                        @endif

                                        @foreach($dayEvents->take(2) as $ev)
                                            @if($ev['type'] === 'personal')
                                                <div class="badge rounded-pill text-truncate text-start px-2 py-0.5 shadow-xs d-block text-white" 
                                                     style="background: {{ $ev['bg_color'] }}; font-size: 0.64rem; cursor: pointer;"
                                                     title="Jadwal Pribadi: {{ $ev['title'] }}"
                                                     onclick="event.stopPropagation(); openEditEventModal({{ json_encode($ev['personal_model']) }})">
                                                    <i class="fa-solid fa-calendar-check me-0.5"></i> {{ $ev['title'] }}
                                                </div>
                                            @else
                                                <a href="{{ $ev['url'] }}" 
                                                   class="badge rounded-pill text-truncate text-start px-2 py-0.5 text-decoration-none shadow-xs d-block" 
                                                   style="background: {{ $ev['bg_color'] }}; color: #ffffff; font-size: 0.65rem;"
                                                   title="{{ $ev['type_label'] }}: {{ $ev['title'] }} ({{ $ev['classroom'] }})"
                                                   onclick="event.stopPropagation();">
                                                    <i class="{{ $ev['icon'] }} me-0.5"></i> {{ $ev['title'] }}
                                                </a>
                                            @endif
                                        @endforeach
                                        @if($dayEvents->count() > 2)
                                            <span class="badge bg-secondary bg-opacity-25 text-dark rounded-pill py-0.5" style="font-size: 0.6rem;">
                                                +{{ $dayEvents->count() - 2 }} lainnya
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Indikator Titik Warna di Mobile Layar Kecil (mencegah teks keluar batas border) --}}
                                    <div class="d-flex d-md-none align-items-center justify-content-center gap-1 mt-auto">
                                        @if($isHoliday)
                                            <span class="rounded-circle" style="width: 5px; height: 5px; background: #DC2626;" title="{{ $holiday['name'] }}"></span>
                                        @endif
                                        @foreach($dayEvents->take(3) as $ev)
                                            <span class="rounded-circle" style="width: 5px; height: 5px; background: {{ $ev['bg_color'] }};" title="{{ $ev['title'] }}"></span>
                                        @endforeach
                                    </div>

                                    {{-- Info Hari di Desktop --}}
                                    <div class="d-none d-md-flex align-items-center justify-content-between mt-auto">
                                        <small class="text-muted" style="font-size: 0.68rem;">
                                            {{ $dateObj->translatedFormat('D') }}
                                        </small>
                                        @if($isToday)
                                            <span class="rounded-circle bg-success ms-auto" style="width: 5px; height: 5px;" title="Hari Ini"></span>
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
            {{-- Kartu Jadwal Acara Pribadi Pengguna (Sesuai Konsep Screenshot) --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="d-flex align-items-center gap-2 fw-bold text-main" style="font-size: 1.05rem;">
                        <i class="fa-solid fa-calendar-check text-success"></i> Jadwal Acara Pribadi
                    </span>
                    <button type="button" 
                            class="btn btn-sm btn-success rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-xs" 
                            data-bs-toggle="modal" data-bs-target="#createEventModal" 
                            onclick="prepareCreateEvent()">
                        <i class="fa-solid fa-plus"></i> <span>Buat Jadwal</span>
                    </button>
                </div>

                {{-- Banner Privasi --}}
                <div class="p-2.5 rounded-3 bg-light border mb-3 d-flex align-items-center justify-content-between text-muted" style="font-size: 0.74rem;">
                    <span class="d-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-lock text-success"></i> Hanya Anda yang dapat melihat jadwal ini
                    </span>
                    <span class="badge bg-success rounded-pill px-2 py-0.5 text-white">
                        {{ $personalEvents->count() }} Acara
                    </span>
                </div>

                <div class="d-flex flex-column gap-2.5">
                    @forelse($personalEvents as $pe)
                    @php
                        $dtPe = $pe->event_date->copy();
                        if ($pe->event_time) {
                            $t = explode(':', $pe->event_time);
                            $dtPe->setTime((int)$t[0], (int)($t[1] ?? 0));
                        }
                    @endphp
                    <div class="p-3 rounded-4 border position-relative" 
                         style="background: #F0FDF4; border-left: 4px solid {{ $pe->color ?: '#10B981' }} !important;">
                        <div class="d-flex align-items-center justify-content-between mb-1.5 flex-wrap gap-1">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="badge text-white rounded-pill px-2.5 py-0.5" style="background: {{ $pe->color ?: '#10B981' }}; font-size: 0.7rem;">
                                    {{ $pe->event_date->translatedFormat('d F Y') }}
                                </span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                    <i class="fa-solid fa-user-lock me-0.5"></i> Pribadi
                                </span>
                            </div>
                            @if($pe->event_time)
                            <small class="text-muted fw-semibold" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-clock me-1"></i> {{ Carbon\Carbon::parse($pe->event_time)->format('H:i') }} WIB
                            </small>
                            @else
                            <small class="text-muted fw-semibold" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-sun me-1"></i> Sepanjang Hari
                            </small>
                            @endif
                        </div>

                        <strong class="text-dark d-block mb-1" style="font-size: 0.92rem;">{{ $pe->title }}</strong>

                        @if($pe->description)
                        <p class="text-muted mb-2" style="line-height: 1.45; font-size: 0.78rem;">
                            {{ $pe->description }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between pt-2 border-top gap-1 flex-wrap">
                            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode('[Jadwal Pribadi] ' . $pe->title) }}&dates={{ $dtPe->copy()->utc()->format('Ymd\THis\Z') }}/{{ $dtPe->copy()->addHour()->utc()->format('Ymd\THis\Z') }}&details={{ urlencode($pe->description ?: 'Jadwal Acara Pribadi BasaKula') }}" 
                               target="_blank" class="btn btn-light border rounded-pill px-2.5 py-1 btn-sm fw-semibold text-muted shadow-xs d-flex align-items-center gap-1" style="font-size: 0.72rem;" title="Tambahkan ke Google Calendar">
                                <i class="fa-brands fa-google text-danger"></i> <span>+ GCal</span>
                            </a>
                            <div class="d-flex align-items-center gap-1.5 ms-auto">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;"
                                        onclick="openEditEventModal({{ json_encode($pe) }})">
                                    <i class="fa-regular fa-pen-to-square"></i> <span>Ubah</span>
                                </button>
                                <form action="{{ route('calendar.events.destroy', $pe) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal acara ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-trash-can"></i> <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                            <i class="fa-regular fa-calendar-plus fs-4"></i>
                        </div>
                        <p class="text-muted small mb-2">Belum ada jadwal acara pribadi.</p>
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold" 
                                data-bs-toggle="modal" data-bs-target="#createEventModal"
                                onclick="prepareCreateEvent()">
                            <i class="fa-solid fa-plus me-1"></i> Buat Jadwal Pertama
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

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

            {{-- Daftar Tanggal Merah Bulan Ini --}}
            @if(!empty($holidays))
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                <h6 class="fw-bold text-main mb-3 d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-flag text-danger"></i> Tanggal Merah & Libur Nasional
                    </span>
                    <span class="badge bg-danger rounded-pill px-2 py-0.5 text-white" style="font-size: 0.7rem;">
                        {{ count($holidays) }} Hari
                    </span>
                </h6>
                <div class="d-flex flex-column gap-2.5">
                    @foreach($holidays as $h)
                    <div class="p-3 rounded-4 border position-relative" 
                         style="background: #FFF5F5; border-left: 4px solid #DC2626 !important; cursor: pointer;"
                         onclick="showHolidayDetail('{{ addslashes($h['name']) }}', '{{ Carbon\Carbon::parse($h['date'])->translatedFormat('l, d F Y') }}', '{{ addslashes($h['description']) }}', '{{ addslashes($h['source'] ?? 'Google Calendar') }}')">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-danger text-white rounded-pill px-2.5 py-0.5" style="font-size: 0.7rem;">
                                {{ Carbon\Carbon::parse($h['date'])->translatedFormat('d F Y') }}
                            </span>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                Tanggal Merah
                            </span>
                        </div>
                        <strong class="text-dark d-block mb-1" style="font-size: 0.88rem;">{{ $h['name'] }}</strong>
                        <small class="text-muted d-block" style="line-height: 1.45; font-size: 0.78rem;">
                            {{ $h['description'] }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

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

{{-- Modal Keterangan Tanggal Merah / Libur Nasional --}}
<div class="modal fade" id="holidayDetailModal" tabindex="-1" aria-labelledby="holidayDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-flag fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-danger mb-0" id="holidayModalTitle">Keterangan Tanggal Merah</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Hari Libur / Peringatan Nasional</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-4">
                <h5 class="fw-bold text-dark mb-1" id="holidayModalName">-</h5>
                <p class="text-danger fw-semibold small mb-3" id="holidayModalDate">-</p>
                <div class="p-3 bg-light rounded-4 border mb-3">
                    <small class="text-muted fw-bold d-block mb-1">
                        <i class="fa-solid fa-circle-info text-danger me-1"></i> Mengapa Tanggal Ini Merah?
                    </small>
                    <p class="text-dark mb-0 small" id="holidayModalDesc" style="line-height: 1.6;">-</p>
                </div>
                <div class="p-2.5 rounded-3 bg-light d-flex align-items-center justify-content-between text-muted small border">
                    <span class="d-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                        <i class="fa-brands fa-google text-danger"></i> Sumber Verifikasi:
                    </span>
                    <strong class="text-dark" id="holidayModalSource" style="font-size: 0.75rem;">Google Calendar</strong>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Jadwal Acara Pribadi --}}
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-calendar-plus fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-main mb-0" id="createEventModalLabel">Buat Jadwal Acara Pribadi</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Hanya dapat dilihat oleh Anda sendiri</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('calendar.events.store') }}" method="POST">
                @csrf
                <div class="modal-body pt-3 pb-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Judul Acara / Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 border-light-subtle" placeholder="Contoh: Belajar Kelompok Macapat, Persiapan Ujian" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-7">
                            <label class="form-label small fw-bold text-main">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="event_date" id="createEventDate" class="form-control rounded-3 border-light-subtle" required>
                        </div>
                        <div class="col-sm-5">
                            <label class="form-label small fw-bold text-main">Waktu / Jam (WIB)</label>
                            <input type="time" name="event_time" id="createEventTime" class="form-control rounded-3 border-light-subtle">
                            <small class="text-muted" style="font-size:0.7rem;">Opsional (bisa dikosongkan)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Warna Label Kalender</label>
                        <input type="hidden" name="color" id="createEventColorInput" value="#10B981">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn active" style="width:28px;height:28px;background:#10B981;border:3px solid #047857;" onclick="selectColor('#10B981', 'create', this)" title="Emerald Hijau"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" style="width:28px;height:28px;background:#3B82F6;border:2px solid transparent;" onclick="selectColor('#3B82F6', 'create', this)" title="Biru"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" style="width:28px;height:28px;background:#8B5CF6;border:2px solid transparent;" onclick="selectColor('#8B5CF6', 'create', this)" title="Ungu"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" style="width:28px;height:28px;background:#F59E0B;border:2px solid transparent;" onclick="selectColor('#F59E0B', 'create', this)" title="Oranye Amber"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" style="width:28px;height:28px;background:#EF4444;border:2px solid transparent;" onclick="selectColor('#EF4444', 'create', this)" title="Merah"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" style="width:28px;height:28px;background:#EC4899;border:2px solid transparent;" onclick="selectColor('#EC4899', 'create', this)" title="Pink"></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Keterangan / Catatan Tambahan</label>
                        <textarea name="description" class="form-control rounded-3 border-light-subtle" rows="3" placeholder="Tuliskan catatan, tempat/tautan pertemuan, atau hal penting lainnya..."></textarea>
                    </div>

                    <div class="p-2.5 rounded-3 bg-light border d-flex align-items-center gap-2 text-muted" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-lock text-success fs-6"></i>
                        <span><strong>Privasi Terjamin:</strong> Pengajar maupun pelajar lain tidak dapat melihat agenda ini.</span>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3 py-2 btn-sm fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 btn-sm fw-bold shadow-xs">
                        <i class="fa-solid fa-check me-1"></i> Simpan Jadwal Acara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ubah Jadwal Acara Pribadi --}}
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-pen-to-square fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-main mb-0" id="editEventModalLabel">Ubah Jadwal Acara Pribadi</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Perbarui rincian agenda pribadi Anda</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEventForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body pt-3 pb-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Judul Acara / Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="editEventTitle" class="form-control rounded-3 border-light-subtle" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-7">
                            <label class="form-label small fw-bold text-main">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="event_date" id="editEventDate" class="form-control rounded-3 border-light-subtle" required>
                        </div>
                        <div class="col-sm-5">
                            <label class="form-label small fw-bold text-main">Waktu / Jam (WIB)</label>
                            <input type="time" name="event_time" id="editEventTime" class="form-control rounded-3 border-light-subtle">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Warna Label Kalender</label>
                        <input type="hidden" name="color" id="editEventColorInput" value="#10B981">
                        <div class="d-flex align-items-center gap-2 flex-wrap" id="editColorPickers">
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#10B981" style="width:28px;height:28px;background:#10B981;border:2px solid transparent;" onclick="selectColor('#10B981', 'edit', this)" title="Emerald Hijau"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#3B82F6" style="width:28px;height:28px;background:#3B82F6;border:2px solid transparent;" onclick="selectColor('#3B82F6', 'edit', this)" title="Biru"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#8B5CF6" style="width:28px;height:28px;background:#8B5CF6;border:2px solid transparent;" onclick="selectColor('#8B5CF6', 'edit', this)" title="Ungu"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#F59E0B" style="width:28px;height:28px;background:#F59E0B;border:2px solid transparent;" onclick="selectColor('#F59E0B', 'edit', this)" title="Oranye Amber"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#EF4444" style="width:28px;height:28px;background:#EF4444;border:2px solid transparent;" onclick="selectColor('#EF4444', 'edit', this)" title="Merah"></button>
                            <button type="button" class="btn p-0 rounded-circle color-picker-btn" data-color="#EC4899" style="width:28px;height:28px;background:#EC4899;border:2px solid transparent;" onclick="selectColor('#EC4899', 'edit', this)" title="Pink"></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-main">Keterangan / Catatan Tambahan</label>
                        <textarea name="description" id="editEventDesc" class="form-control rounded-3 border-light-subtle" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3 py-2 btn-sm fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 btn-sm fw-bold shadow-xs">
                        <i class="fa-solid fa-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ringkasan Agenda Tanggal & Tambah Cepat --}}
<div class="modal fade" id="dayDetailModal" tabindex="-1" aria-labelledby="dayDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-calendar-day fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-main mb-0" id="dayDetailTitle">Agenda Tanggal</h6>
                        <small class="text-danger fw-semibold" id="dayDetailDateText">-</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-3">
                {{-- Tanggal Merah / Libur jika ada --}}
                <div id="dayDetailHolidayBox" class="p-3 rounded-4 border mb-3 d-none" style="background:#FFF5F5; border-left:4px solid #DC2626 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="badge bg-danger text-white rounded-pill px-2.5 py-0.5" style="font-size:0.7rem;">Tanggal Merah</span>
                        <small class="text-muted" id="dayDetailHolidaySource" style="font-size:0.7rem;">Google Calendar</small>
                    </div>
                    <strong class="text-dark d-block mb-1" id="dayDetailHolidayName">-</strong>
                    <p class="text-muted small mb-0" id="dayDetailHolidayDesc" style="line-height:1.45;">-</p>
                </div>

                {{-- Kontainer Daftar Agenda --}}
                <h6 class="fw-bold text-main small mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-list-check text-primary me-1"></i> Agenda & Jadwal Tanggal Ini:</span>
                    <span class="badge bg-light border text-muted rounded-pill" id="dayDetailCountBadge">0 Agenda</span>
                </h6>
                <div id="dayDetailEventsList" class="d-flex flex-column gap-2 mb-2">
                    {{-- Diisi secara dinamis via JS --}}
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 py-1.5 btn-sm fw-semibold" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success rounded-pill px-3 py-1.5 btn-sm fw-bold shadow-xs d-inline-flex align-items-center gap-1.5" id="dayDetailAddBtn" onclick="quickAddFromDayModal()">
                    <i class="fa-solid fa-plus"></i> <span>+ Tambah Jadwal di Tanggal Ini</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentSelectedDateStr = '';

    function showHolidayDetail(name, fullDate, description, source) {
        document.getElementById('holidayModalName').textContent = name;
        document.getElementById('holidayModalDate').textContent = fullDate;
        document.getElementById('holidayModalDesc').textContent = description;
        document.getElementById('holidayModalSource').textContent = source || 'Google Calendar';

        const modalEl = document.getElementById('holidayDetailModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    }

    function prepareCreateEvent(dateStr) {
        const dateInput = document.getElementById('createEventDate');
        if (dateInput) {
            if (dateStr) {
                dateInput.value = dateStr;
            } else if (!dateInput.value) {
                const now = new Date();
                const yr = now.getFullYear();
                const mo = String(now.getMonth() + 1).padStart(2, '0');
                const dy = String(now.getDate()).padStart(2, '0');
                dateInput.value = `${yr}-${mo}-${dy}`;
            }
        }
    }

    function selectColor(colorHex, formType, btnEl) {
        if (formType === 'create') {
            document.getElementById('createEventColorInput').value = colorHex;
            document.querySelectorAll('#createEventModal .color-picker-btn').forEach(b => {
                b.style.borderColor = 'transparent';
            });
            btnEl.style.borderColor = '#000000';
        } else {
            document.getElementById('editEventColorInput').value = colorHex;
            document.querySelectorAll('#editColorPickers .color-picker-btn').forEach(b => {
                b.style.borderColor = 'transparent';
            });
            btnEl.style.borderColor = '#000000';
        }
    }

    function openEditEventModal(eventObj) {
        document.getElementById('editEventForm').action = '/calendar/events/' + eventObj.id;
        document.getElementById('editEventTitle').value = eventObj.title || '';
        document.getElementById('editEventDate').value = (eventObj.event_date || '').substring(0, 10);
        document.getElementById('editEventTime').value = eventObj.event_time ? eventObj.event_time.substring(0, 5) : '';
        document.getElementById('editEventDesc').value = eventObj.description || '';
        document.getElementById('editEventColorInput').value = eventObj.color || '#10B981';

        const activeColor = eventObj.color || '#10B981';
        document.querySelectorAll('#editColorPickers .color-picker-btn').forEach(b => {
            if (b.getAttribute('data-color') === activeColor) {
                b.style.borderColor = '#000000';
            } else {
                b.style.borderColor = 'transparent';
            }
        });

        const dayModalEl = document.getElementById('dayDetailModal');
        const dayModal = bootstrap.Modal.getInstance(dayModalEl);
        if (dayModal) {
            dayModal.hide();
        }

        const bsModal = new bootstrap.Modal(document.getElementById('editEventModal'));
        bsModal.show();
    }

    function openDayDetailModal(fullDate, dateStr, holiday, events) {
        currentSelectedDateStr = dateStr;
        document.getElementById('dayDetailDateText').textContent = fullDate;

        // Holiday card
        const holidayBox = document.getElementById('dayDetailHolidayBox');
        if (holiday && holiday.name) {
            document.getElementById('dayDetailHolidayName').textContent = holiday.name;
            document.getElementById('dayDetailHolidayDesc').textContent = holiday.description || 'Hari libur / peringatan resmi.';
            document.getElementById('dayDetailHolidaySource').textContent = holiday.source || 'Google Calendar';
            holidayBox.classList.remove('d-none');
        } else {
            holidayBox.classList.add('d-none');
        }

        // Events list
        const listEl = document.getElementById('dayDetailEventsList');
        listEl.innerHTML = '';

        const eventCount = events ? events.length : 0;
        document.getElementById('dayDetailCountBadge').textContent = eventCount + ' Agenda';

        if (!events || events.length === 0) {
            listEl.innerHTML = `
                <div class="text-center py-3 bg-light rounded-4 border">
                    <i class="fa-regular fa-calendar text-muted mb-1 fs-5 d-block"></i>
                    <small class="text-muted">Tidak ada agenda pembelajaran maupun jadwal pribadi pada tanggal ini.</small>
                </div>
            `;
        } else {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            events.forEach(ev => {
                const card = document.createElement('div');
                card.className = 'p-3 rounded-4 border bg-white shadow-xs position-relative';
                card.style.borderLeft = '4px solid ' + (ev.bg_color || '#3B82F6') + ' !important';

                let actionHtml = '';
                if (ev.type === 'personal') {
                    actionHtml = `
                        <div class="d-flex align-items-center gap-1.5 ms-auto">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5 fw-semibold d-inline-flex align-items-center gap-1" style="font-size:0.72rem;" onclick="openEditEventModal(${JSON.stringify(ev.personal_model).replace(/"/g, '&quot;')})">
                                <i class="fa-regular fa-pen-to-square"></i> Ubah
                            </button>
                            <form action="/calendar/events/${ev.raw_id}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal acara ini?')">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-0.5 fw-semibold d-inline-flex align-items-center gap-1" style="font-size:0.72rem;">
                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                </button>
                            </form>
                        </div>
                    `;
                } else {
                    actionHtml = `
                        <a href="${ev.url}" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold ms-auto" style="font-size:0.75rem;">
                            Buka <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    `;
                }

                card.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between mb-1.5 flex-wrap gap-1">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge ${ev.badge_class || 'text-white'}" style="${ev.type === 'personal' ? 'background:' + ev.bg_color : ''}; font-size:0.7rem;">
                                <i class="${ev.icon || 'fa-solid fa-calendar'} me-1"></i> ${ev.type_label || 'Agenda'}
                            </span>
                            ${ev.classroom ? `<small class="text-muted" style="font-size:0.72rem;">• ${ev.classroom}</small>` : ''}
                        </div>
                        ${ev.time ? `<small class="text-muted fw-semibold" style="font-size:0.72rem;"><i class="fa-regular fa-clock me-1"></i> ${ev.time} WIB</small>` : ''}
                    </div>
                    <strong class="text-dark d-block mb-1" style="font-size:0.9rem;">${ev.title}</strong>
                    ${ev.description ? `<p class="text-muted mb-2" style="font-size:0.78rem; line-height:1.45;">${ev.description}</p>` : ''}
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-1">
                        ${ev.gcal_url ? `<a href="${ev.gcal_url}" target="_blank" class="btn btn-light border rounded-pill px-2.5 py-0.5 btn-sm text-muted" style="font-size:0.72rem;"><i class="fa-brands fa-google text-danger me-1"></i>+ GCal</a>` : '<span></span>'}
                        ${actionHtml}
                    </div>
                `;
                listEl.appendChild(card);
            });
        }

        const modalEl = document.getElementById('dayDetailModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    }

    function quickAddFromDayModal() {
        const dayModalEl = document.getElementById('dayDetailModal');
        const dayModal = bootstrap.Modal.getInstance(dayModalEl);
        if (dayModal) {
            dayModal.hide();
        }

        prepareCreateEvent(currentSelectedDateStr);
        const createModal = new bootstrap.Modal(document.getElementById('createEventModal'));
        createModal.show();
    }
</script>
@endpush
@endsection
