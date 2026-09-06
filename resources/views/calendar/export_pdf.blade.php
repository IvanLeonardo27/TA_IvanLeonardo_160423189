<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalender BasaKula - {{ $monthName }}</title>
    <style>
        @page {
            margin: 10mm 12mm 10mm 12mm;
            size: a4 landscape;
        }

        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            color: #1e293b;
            font-size: 9pt;
            line-height: 1.3;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Header Layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border-bottom: 2.5px solid #1F4D3A;
            padding-bottom: 8px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .brand-title {
            font-size: 18pt;
            font-weight: bold;
            color: #1F4D3A;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .brand-title .accent {
            color: #C9A66B;
        }

        .brand-subtitle {
            font-size: 9pt;
            color: #64748b;
            margin-top: 2px;
        }

        .period-badge {
            display: inline-block;
            background: #1F4D3A;
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11pt;
            font-weight: bold;
            margin-top: 4px;
        }

        .user-info-box {
            text-align: right;
            font-size: 8pt;
            color: #475569;
        }

        .user-name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
        }

        .role-badge {
            display: inline-block;
            background: #e2e8f0;
            color: #334155;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 7.5pt;
            font-weight: 600;
        }

        /* Calendar Grid Table */
        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 12px;
        }

        .calendar-table th {
            background-color: #1F4D3A;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5pt;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #163e2e;
            letter-spacing: 0.5px;
        }

        .calendar-table th.sunday-header {
            background-color: #991b1b;
            border-color: #7f1d1d;
        }

        .calendar-table td {
            border: 1px solid #cbd5e1;
            height: 70px;
            vertical-align: top;
            padding: 4px 5px;
            position: relative;
            background-color: #ffffff;
        }

        .calendar-table td.other-month {
            background-color: #f8fafc;
            color: #cbd5e1;
        }

        .calendar-table td.holiday-cell {
            background-color: #fef2f2;
        }

        .calendar-table td.today-cell {
            background-color: #f0fdf4;
            border: 2px solid #15803d;
        }

        .date-number {
            float: right;
            font-weight: bold;
            font-size: 9.5pt;
            color: #334155;
            line-height: 1;
        }

        .date-number.red-date {
            color: #dc2626;
        }

        .holiday-label {
            clear: both;
            font-size: 6.5pt;
            font-weight: bold;
            color: #b91c1c;
            background: #fee2e2;
            padding: 1.5px 3px;
            border-radius: 3px;
            margin-top: 2px;
            margin-bottom: 3px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .event-pill {
            display: block;
            font-size: 6.5pt;
            padding: 1.5px 3px;
            border-radius: 3px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .event-asn {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 2.5px solid #dc2626;
        }

        .event-quiz {
            background-color: #eff6ff;
            color: #1e40af;
            border-left: 2.5px solid #2563eb;
        }

        .event-personal {
            background-color: #f0fdf4;
            color: #166534;
            border-left: 2.5px solid #10b981;
        }

        /* Page Break for Agenda Summary */
        .page-break {
            page-break-before: always;
        }

        /* Summary Section */
        .summary-title {
            font-size: 13pt;
            font-weight: bold;
            color: #1F4D3A;
            border-bottom: 2px solid #C9A66B;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .agenda-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 15px;
        }

        .agenda-table th {
            background: #f1f5f9;
            color: #334155;
            font-weight: bold;
            text-align: left;
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
        }

        .agenda-table td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .agenda-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .badge-type {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
        }

        .badge-tugas { background: #fee2e2; color: #b91c1c; }
        .badge-kuis  { background: #dbeafe; color: #1e40af; }
        .badge-acara { background: #dcfce7; color: #166534; }
        .badge-libur { background: #fee2e2; color: #991b1b; }

        .footer-note {
            margin-top: 15px;
            text-align: center;
            font-size: 7pt;
            color: #94a3b8;
            border-top: 1px dashed #cbd5e1;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    {{-- HEADER DOKUMEN --}}
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div class="brand-title">Basa<span class="accent">Kula</span></div>
                <div class="brand-subtitle">Platform Pembelajaran Bahasa Jawa Terpadu</div>
                <div class="period-badge">{{ $monthName }}</div>
            </td>
            <td class="user-info-box" style="width: 40%;">
                <div class="user-name">{{ $user->name }}</div>
                <div style="margin: 2px 0;">
                    <span class="role-badge">{{ $roleLabel }}</span>
                    @if($user->user_code)
                    <span style="color: #64748b; font-size: 7.5pt;">({{ $user->user_code }})</span>
                    @endif
                </div>
                <div style="color: #64748b; font-size: 7pt; margin-top: 3px;">
                    Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </div>
                <div style="color: #059669; font-size: 7pt; font-weight: 600;">
                    Terintegrasi Kalender Nasional & Google Calendar
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL KALENDER BULANAN --}}
    <table class="calendar-table">
        <thead>
            <tr>
                <th style="width: 14.28%;">SENIN</th>
                <th style="width: 14.28%;">SELASA</th>
                <th style="width: 14.28%;">RABU</th>
                <th style="width: 14.28%;">KAMIS</th>
                <th style="width: 14.28%;">JUMAT</th>
                <th style="width: 14.28%;">SABTU</th>
                <th style="width: 14.28%;" class="sunday-header">MINGGU</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentDay = 1;
                $dayOfWeekCounter = 1;
                $totalCellsRendered = 0;
            @endphp

            {{-- Baris pertama: sel kosong sebelum tanggal 1 --}}
            <tr>
                @for ($i = 1; $i < $startDayOfWeek; $i++)
                    <td class="other-month"></td>
                    @php $dayOfWeekCounter++; $totalCellsRendered++; @endphp
                @endfor

                {{-- Tanggal-tanggal di bulan ini --}}
                @while ($currentDay <= $daysInMonth)
                    @php
                        $isSunday = ($dayOfWeekCounter % 7 == 0);
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $currentDay);
                        $holiday = $holidays[$dateStr] ?? null;
                        $dayEvents = $eventsByDay[$currentDay] ?? collect();
                        $isToday = (now()->year == $year && now()->month == $month && now()->day == $currentDay);
                        
                        $cellClass = '';
                        if ($isToday) $cellClass .= ' today-cell';
                        if ($holiday || $isSunday) $cellClass .= ' holiday-cell';
                    @endphp

                    <td class="{{ trim($cellClass) }}">
                        <span class="date-number {{ ($isSunday || $holiday) ? 'red-date' : '' }}">
                            {{ $currentDay }}
                        </span>

                        {{-- Label Hari Libur --}}
                        @if($holiday)
                            <span class="holiday-label" title="{{ $holiday['name'] }}">
                                {{ $holiday['name'] }}
                            </span>
                        @endif

                        {{-- Daftar Event / Tugas / Kuis / Acara Pribadi --}}
                        @foreach($dayEvents->take(3) as $ev)
                            @php
                                $pillClass = 'event-asn';
                                if ($ev['type'] === 'quiz') $pillClass = 'event-quiz';
                                if ($ev['type'] === 'personal') $pillClass = 'event-personal';
                            @endphp
                            <span class="event-pill {{ $pillClass }}">
                                <strong>[{{ $ev['type_label'] }}]</strong> {{ Str::limit($ev['title'], 16) }}
                                @if($ev['time'] && $ev['time'] !== 'Sepanjang Hari')
                                    ({{ $ev['time'] }})
                                @endif
                            </span>
                        @endforeach

                        @if($dayEvents->count() > 3)
                            <span style="font-size: 6pt; color: #64748b; font-weight: bold; display: block; margin-top: 1px;">
                                +{{ $dayEvents->count() - 3 }} agenda lain
                            </span>
                        @endif
                    </td>

                    @php
                        $currentDay++;
                        $dayOfWeekCounter++;
                        $totalCellsRendered++;
                    @endphp

                    {{-- Jika sudah sampai hari Minggu, tutup baris dan buka baris baru --}}
                    @if (($dayOfWeekCounter - 1) % 7 == 0 && $currentDay <= $daysInMonth)
                        </tr><tr>
                    @endif
                @endwhile

                {{-- Sel kosong penutup di baris terakhir --}}
                @while (($dayOfWeekCounter - 1) % 7 != 0)
                    <td class="other-month"></td>
                    @php $dayOfWeekCounter++; $totalCellsRendered++; @endphp
                @endwhile
            </tr>
        </tbody>
    </table>

    {{-- FOOTER HALAMAN 1 --}}
    <div class="footer-note">
        Platform Pembelajaran BasaKula &copy; {{ date('Y') }} &bull; Kalender Pembelajaran Bahasa Jawa Terpadu &bull; Halaman 1
    </div>

    {{-- HALAMAN 2: DAFTAR DETAIL AGENDA & HARI LIBUR --}}
    @if(count($holidays) > 0 || $events->count() > 0)
    <div class="page-break"></div>

    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div class="brand-title">Basa<span class="accent">Kula</span> &bull; <span style="font-size: 14pt; color: #475569;">Rekap Rincian Agenda</span></div>
                <div class="brand-subtitle">Daftar agenda pembelajaran, tenggat kuis/tugas, dan hari libur nasional</div>
            </td>
            <td class="user-info-box" style="width: 40%;">
                <div class="period-badge">{{ $monthName }}</div>
            </td>
        </tr>
    </table>

    {{-- Tabel 1: Hari Libur & Tanggal Merah --}}
    @if(count($holidays) > 0)
    <div class="summary-title">Hari Libur & Peringatan Resmi Nasional ({{ count($holidays) }} Hari)</div>
    <table class="agenda-table">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Hari</th>
                <th style="width: 50%;">Nama Hari Libur / Peringatan</th>
                <th style="width: 15%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($holidays as $date => $h)
            @php $dtH = \Carbon\Carbon::parse($date); @endphp
            <tr>
                <td style="font-weight: bold; color: #dc2626;">{{ $dtH->translatedFormat('d F Y') }}</td>
                <td>{{ $dtH->translatedFormat('l') }}</td>
                <td style="font-weight: bold; color: #1e293b;">{{ $h['name'] }}</td>
                <td><span class="badge-type badge-libur">Tanggal Merah</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Tabel 2: Agenda Pembelajaran & Tugas --}}
    @if($events->count() > 0)
    <div class="summary-title" style="margin-top: 15px;">Daftar Agenda & Tenggat Waktu ({{ $events->count() }} Agenda)</div>
    <table class="agenda-table">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal & Waktu</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 38%;">Judul Agenda / Tugas</th>
                <th style="width: 20%;">Ruang Kelas</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events->sortBy('date') as $ev)
            @php
                $badgeClass = 'badge-tugas';
                if ($ev['type'] === 'quiz') $badgeClass = 'badge-kuis';
                if ($ev['type'] === 'personal') $badgeClass = 'badge-acara';
            @endphp
            <tr>
                <td style="font-weight: bold;">{{ $ev['formatted'] }}</td>
                <td><span class="badge-type {{ $badgeClass }}">{{ $ev['type_label'] }}</span></td>
                <td style="font-weight: 600; color: #0f172a;">{{ $ev['title'] }}</td>
                <td>{{ $ev['classroom'] }}</td>
                <td><span style="font-size: 7.5pt; color: #475569;">{{ $ev['status_label'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer-note" style="margin-top: 25px;">
        Platform Pembelajaran BasaKula &copy; {{ date('Y') }} &bull; Dokumen ini dihasilkan secara otomatis oleh sistem &bull; Halaman 2
    </div>
    @endif

</body>
</html>
