@extends('layouts.app')

@section('title', 'Kalender Sistem - Administrator BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Header Banner Admin Calendar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden text-white" 
         style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" 
                         style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="fa-solid fa-shield-halved text-warning me-1"></i>
                        <span class="small fw-semibold">Panel Administrator • Penanggalan Sistem</span>
                    </div>
                    
                    <h2 class="fw-bold text-white mb-2 d-flex align-items-center gap-2 flex-wrap" style="letter-spacing: -0.02em;">
                        <span>Kalender Sistem BasaKula</span>
                        <i class="fa-solid fa-calendar-days text-warning fs-3 ms-1" aria-hidden="true"></i>
                    </h2>
                    <p class="text-white-50 mb-0 fs-6" style="max-width: 620px;">
                        Kalender penanggalan masehi terpadu untuk administrator. Tampilan bersih dan fokus pada penanggalan sistem tanpa pencatatan tugas maupun materi pembelajaran.
                    </p>
                </div>
                
                <div class="col-lg-4 text-lg-end d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                    <a href="{{ route('calendar.export_pdf', ['month' => $month, 'year' => $year]) }}" 
                       class="btn btn-accent rounded-pill px-4 py-2 shadow-sm fw-bold btn-bouncy d-inline-flex align-items-center justify-content-center gap-2 text-white">
                        <i class="fa-solid fa-file-pdf me-1.5" aria-hidden="true"></i>
                        <span>Ekspor Kalender (PDF)</span>
                    </a>
                    <div class="p-3 rounded-4" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);">
                        <div class="small text-white-50 mb-1">
                            <i class="fa-regular fa-clock me-1 text-warning"></i> Waktu Sistem Real-Time
                        </div>
                        <div class="fw-bold fs-4 text-white font-monospace" id="adminLiveClock">
                            {{ now()->format('H:i:s') }} WIB
                        </div>
                        <div class="small text-white-50 mt-1">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </div>
                        <div class="small fw-semibold text-white-50 mt-1 pt-1 border-top border-white border-opacity-10 d-flex align-items-center justify-content-center justify-content-lg-end gap-1" style="font-size: 0.74rem;">
                            <i class="fa-brands fa-google text-danger"></i> Terintegrasi Google Calendar
                        </div>
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

        // 1 = Senin, 7 = Minggu
        $startDayOfWeek = $startOfMonth->dayOfWeekIso;
        $daysInMonth    = $currentDate->daysInMonth;
        $monthName      = $currentDate->translatedFormat('F Y');

        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <div class="row g-4">
        {{-- Kalender Grid Utama --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white" style="border: 1px solid #E2E8F0 !important;">
                {{-- Header Navigasi Bulan & Lompat Tanggal --}}
                <div class="card-header border-0 bg-white p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-4 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                                 style="width:48px;height:48px; background: rgba(22, 64, 46, 0.12); color: #16402E;">
                                <i class="fa-solid fa-calendar-days fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-main mb-0">{{ $monthName }}</h4>
                                <small class="text-muted">{{ $daysInMonth }} Hari dalam Bulan Ini</small>
                            </div>
                        </div>

                        {{-- Tombol Navigasi Cepat --}}
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <a href="{{ route('admin.calendar', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}" 
                               class="btn btn-outline-secondary rounded-pill px-3 py-1.5 btn-sm fw-semibold shadow-xs d-inline-flex align-items-center" 
                               title="Bulan Sebelumnya">
                                <i class="fa-solid fa-chevron-left me-1.5"></i> <span>Sebelumnya</span>
                            </a>
                            <a href="{{ route('admin.calendar', ['month' => now()->month, 'year' => now()->year]) }}" 
                               class="btn btn-light border rounded-pill px-3 py-1.5 btn-sm fw-bold {{ $currentDate->isCurrentMonth() && $currentDate->isCurrentYear() ? 'bg-primary-subtle text-primary border-primary' : 'text-main' }}">
                                Hari Ini
                            </a>
                            <a href="{{ route('admin.calendar', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}" 
                               class="btn btn-outline-secondary rounded-pill px-3 py-1.5 btn-sm fw-semibold shadow-xs d-inline-flex align-items-center" 
                               title="Bulan Berikutnya">
                                <span>Berikutnya</span> <i class="fa-solid fa-chevron-right ms-1.5"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Form Pilih Bulan & Tahun Cepat --}}
                    <form method="GET" action="{{ route('admin.calendar') }}" class="row g-2 align-items-center pt-2 border-top">
                        <div class="col-auto">
                            <span class="small fw-semibold text-muted"><i class="fa-solid fa-filter me-1"></i> Lompat ke:</span>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <select name="month" class="form-select form-select-sm rounded-pill border-light-subtle shadow-xs" onchange="this.form.submit()">
                                @foreach($indonesianMonths as $mNum => $mName)
                                    <option value="{{ $mNum }}" {{ $month == $mNum ? 'selected' : '' }}>
                                        {{ $mName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <select name="year" class="form-select form-select-sm rounded-pill border-light-subtle shadow-xs" onchange="this.form.submit()">
                                @for($y = now()->year - 5; $y <= now()->year + 5; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </form>
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
                                $dateObj    = Carbon\Carbon::createFromDate($year, $month, $day);
                                $dateStr    = $dateObj->format('Y-m-d');
                                $isToday    = ($dateStr === now()->format('Y-m-d'));
                                $isSunday   = ($dateObj->isSunday());
                                $isSaturday = ($dateObj->isSaturday());
                                $holiday    = $holidays[$dateStr] ?? null;
                                $isHoliday  = !empty($holiday);
                                $isRedDate  = $isSunday || $isHoliday;
                                $dayType    = $isHoliday ? 'Tanggal Merah: ' . $holiday['name'] : ($isSunday ? 'Akhir Pekan (Minggu)' : ($isSaturday ? 'Akhir Pekan (Sabtu)' : 'Hari Kerja'));
                                $dayDesc    = $isHoliday ? addslashes($holiday['description']) : ($isSunday || $isSaturday ? 'Hari libur akhir pekan sistem.' : 'Hari kerja operasional sistem.');
                            @endphp
                            <div class="col" style="min-width: 14.28%; flex: 0 0 14.28%;">
                                <div class="border position-relative d-flex flex-column justify-content-between calendar-day-cell {{ $isToday ? 'border-2 border-primary bg-primary-subtle shadow-sm' : ($isHoliday ? 'border-danger-subtle bg-danger-subtle bg-opacity-25' : ($isSunday ? 'bg-light bg-opacity-75' : 'bg-white shadow-xs')) }}" 
                                     onclick="showDateDetail('{{ $dateObj->translatedFormat('l, d F Y') }}', '{{ $day }}', '{{ $dateObj->dayOfYear }}', '{{ $dateObj->weekOfYear }}', '{{ addslashes($dayType) }}', '{{ $dayDesc }}', '{{ addslashes($holiday['source'] ?? ($isRedDate ? 'Kalender Sistem' : 'Hari Kerja')) }}')">

                                    <div class="d-flex align-items-center justify-content-between mb-0 mb-sm-1">
                                        <span class="fw-bold {{ $isToday ? 'badge bg-primary text-white rounded-circle p-1' : ($isRedDate ? 'text-danger fw-bold' : 'text-main') }}" 
                                              style="{{ $isToday ? 'width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;' : 'font-size:clamp(0.78rem, 2.4vw, 0.95rem);' }}">
                                            {{ $day }}
                                        </span>
                                        @if($isHoliday)
                                            <span class="badge bg-danger rounded-pill p-1 text-white shadow-xs" style="font-size: 0.52rem; line-height: 1;" title="{{ $holiday['name'] }}">
                                                <i class="fa-solid fa-flag" style="font-size: 0.48rem;"></i>
                                            </span>
                                        @elseif($isToday)
                                            <span class="badge bg-primary text-white rounded-pill px-1.5 py-0.5 d-none d-md-inline-block" style="font-size: 0.6rem;">
                                                Hari Ini
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Desktop badge text --}}
                                    @if($isHoliday)
                                        <div class="d-none d-md-block badge rounded-pill text-truncate text-start px-2 py-0.5 shadow-xs text-white mb-1" 
                                             style="background: #DC2626; font-size: 0.64rem;"
                                             title="Tanggal Merah: {{ $holiday['name'] }}">
                                            <i class="fa-solid fa-flag me-0.5"></i> {{ $holiday['name'] }}
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                        <small class="text-muted d-none d-md-block" style="font-size: 0.68rem;">
                                            {{ $dateObj->translatedFormat('D') }}
                                        </small>
                                        @if($isToday)
                                            <span class="rounded-circle bg-success ms-auto d-none d-sm-inline-block" style="width: 5px; height: 5px;" title="Hari Ini"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Kanan: Detail & Info Hari Ini --}}
        <div class="col-lg-4">
            {{-- Kartu Hari Ini --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-center text-white" 
                 style="background: linear-gradient(135deg, #1F4D3A 0%, #16382A 100%); border: 1px solid rgba(255,255,255,0.1) !important;">
                <span class="badge bg-white bg-opacity-20 rounded-pill px-3 py-1 mb-2 d-inline-block" style="font-size: 0.78rem;">
                    <i class="fa-regular fa-sun text-warning me-1"></i> Hari Ini
                </span>
                <div class="fw-bold text-white mb-0" style="font-size: 4rem; line-height: 1;">
                    {{ now()->format('d') }}
                </div>
                <h5 class="fw-bold text-white mb-1 mt-1">{{ now()->translatedFormat('l') }}</h5>
                <p class="text-white-50 small mb-0">{{ now()->translatedFormat('F Y') }}</p>
            </div>

            {{-- Kartu Ringkasan Penanggalan Bulan Ini --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                <h6 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-info text-primary"></i> Info Bulan {{ $monthName }}
                </h6>
                <div class="d-flex flex-column gap-2.5">
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <span class="small text-muted">Jumlah Hari:</span>
                        <strong class="text-main small">{{ $daysInMonth }} Hari</strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <span class="small text-muted">Awal Bulan:</span>
                        <strong class="text-main small">{{ $startOfMonth->translatedFormat('l, j F') }}</strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <span class="small text-muted">Akhir Bulan:</span>
                        <strong class="text-main small">{{ $endOfMonth->translatedFormat('l, j F') }}</strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <span class="small text-muted">Minggu Berjalan:</span>
                        <strong class="text-main small">Minggu ke-{{ $currentDate->weekOfYear }}</strong>
                    </div>
                </div>
            </div>

            {{-- Kartu Tanggal Merah & Libur Nasional Bulan Ini --}}
            @if(!empty($holidays))
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                <h6 class="fw-bold text-main mb-3 d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-flag text-danger"></i> Tanggal Merah & Libur
                    </span>
                    <span class="badge bg-danger rounded-pill px-2 py-0.5 text-white" style="font-size: 0.7rem;">
                        {{ count($holidays) }} Hari
                    </span>
                </h6>
                <div class="d-flex flex-column gap-2.5">
                    @foreach($holidays as $h)
                    <div class="p-3 rounded-4 border position-relative" 
                         style="background: #FFF5F5; border-left: 4px solid #DC2626 !important; cursor: pointer;"
                         onclick="showDateDetail('{{ Carbon\Carbon::parse($h['date'])->translatedFormat('l, d F Y') }}', '{{ $h['day'] }}', '{{ Carbon\Carbon::parse($h['date'])->dayOfYear }}', '{{ Carbon\Carbon::parse($h['date'])->weekOfYear }}', 'Tanggal Merah: {{ addslashes($h['name']) }}', '{{ addslashes($h['description']) }}', '{{ addslashes($h['source'] ?? 'Google Calendar') }}')">
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

            {{-- Kartu Catatan Administrator --}}
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-primary" 
                         style="width: 36px; height: 36px; background: rgba(31, 77, 58, 0.1);">
                        <i class="fa-solid fa-calendar-check fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-main mb-1">Mode Kalender Administrator</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.5;">
                            Panel kalender admin berfokus murni pada penanggalan sistem. Tidak ada data tugas, batas kuis, maupun materi kelas yang dicatat di sini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail Tanggal --}}
<div class="modal fade" id="dateDetailModal" tabindex="-1" aria-labelledby="dateDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-main" id="dateDetailModalLabel">
                    <i class="fa-solid fa-calendar-day text-primary me-1.5"></i> Detail Tanggal
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-2 pb-4">
                <div class="display-4 fw-bold text-primary mb-1" id="modalDayNumber">1</div>
                <h5 class="fw-bold text-dark mb-1" id="modalDateFull">-</h5>
                <span class="badge bg-light text-muted border rounded-pill px-3 py-1 mb-3" id="modalDayType">-</span>
                
                <div class="p-3 bg-light rounded-4 text-start small mb-3 border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Hari ke:</span>
                        <strong class="text-dark" id="modalDayOfYear">-</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Minggu ke:</span>
                        <strong class="text-dark" id="modalWeekOfYear">-</strong>
                    </div>
                </div>

                <div class="p-3 rounded-4 text-start small border mb-3" id="modalDescBox" style="background: #FFF5F5; border-color: #FECACA !important;">
                    <div class="fw-bold text-danger mb-1 d-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-circle-info"></i> Keterangan Tanggal:
                    </div>
                    <p class="text-dark mb-0" id="modalDescText" style="line-height: 1.5;">-</p>
                </div>

                <div class="p-2.5 rounded-3 bg-light d-flex align-items-center justify-content-between text-muted small border">
                    <span class="d-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                        <i class="fa-brands fa-google text-danger"></i> Sumber Verifikasi:
                    </span>
                    <strong class="text-dark" id="adminModalSource" style="font-size: 0.75rem;">Google Calendar</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Live Digital Clock WIB
    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const timeString = new Intl.DateTimeFormat('id-ID', options).format(now);
        const clockEl = document.getElementById('adminLiveClock');
        if (clockEl) {
            clockEl.textContent = timeString + ' WIB';
        }
    }
    setInterval(updateClock, 1000);

    // Modal Detail Tanggal
    function showDateDetail(fullDate, dayNum, dayOfYear, weekOfYear, dayType, desc, source) {
        document.getElementById('modalDayNumber').textContent = dayNum;
        document.getElementById('modalDateFull').textContent = fullDate;
        document.getElementById('modalDayType').textContent = dayType;
        document.getElementById('modalDayOfYear').textContent = dayOfYear + ' dalam tahun ini';
        document.getElementById('modalWeekOfYear').textContent = 'Minggu ke-' + weekOfYear;
        document.getElementById('modalDescText').textContent = desc || 'Tidak ada keterangan khusus.';
        document.getElementById('adminModalSource').textContent = source || 'Google Calendar';

        const isHoliday = dayType.toLowerCase().includes('tanggal merah');
        const descBox = document.getElementById('modalDescBox');
        if (descBox) {
            if (isHoliday) {
                descBox.style.background = '#FFF5F5';
                descBox.style.borderColor = '#FECACA';
            } else {
                descBox.style.background = '#F8FAFC';
                descBox.style.borderColor = '#E2E8F0';
            }
        }

        const modalEl = document.getElementById('dateDetailModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    }
</script>
@endpush
@endsection
