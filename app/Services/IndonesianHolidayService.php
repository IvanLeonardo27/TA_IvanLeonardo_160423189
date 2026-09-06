<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndonesianHolidayService
{
    /**
     * Google Calendar Indonesian Holidays Calendar ID
     */
    const GOOGLE_CALENDAR_ID = 'id.indonesian#holiday@group.v.calendar.google.com';

    /**
     * Dapatkan daftar Hari Libur Nasional & Tanggal Merah Indonesia berdasarkan Tahun dan Bulan.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public static function getHolidaysForMonth(int $year, int $month): array
    {
        $allHolidays = self::getAllHolidaysForYear($year);
        $result = [];

        foreach ($allHolidays as $date => $info) {
            $parts = explode('-', $date);
            if ((int)$parts[1] === $month) {
                $result[$date] = array_merge($info, [
                    'date' => $date,
                    'day'  => (int)$parts[2],
                ]);
            }
        }

        return $result;
    }

    /**
     * Cek apakah suatu tanggal adalah tanggal merah / hari libur nasional.
     *
     * @param string $dateStr Format 'Y-m-d'
     * @return array|null
     */
    public static function getHolidayForDate(string $dateStr): ?array
    {
        $year = (int)date('Y', strtotime($dateStr));
        $all = self::getAllHolidaysForYear($year);

        return $all[$dateStr] ?? null;
    }

    /**
     * Dapatkan seluruh Hari Libur Nasional Indonesia untuk suatu tahun.
     * Mengambil secara live dan terverifikasi dari Google Calendar API / Feed,
     * lalu digabungkan dengan Hari Peringatan Nasional Bersejarah (seperti Hari Santri 22 Okt).
     *
     * @param int $year
     * @return array
     */
    public static function getAllHolidaysForYear(int $year): array
    {
        return Cache::remember("indonesian_holidays_gcal_{$year}", now()->addDays(7), function () use ($year) {
            $googleHolidays = self::fetchFromGoogleCalendar($year);
            $observances    = self::getNationalObservances($year);

            // Gabungkan Google Calendar holidays dengan Hari Peringatan Nasional
            $merged = array_merge($googleHolidays, $observances);

            // Jika Google Calendar tidak berhasil dihubungi (misal: koneksi offline), gunakan dataset offline cadangan
            if (empty($googleHolidays)) {
                $fallback = self::getOfflineHolidaysForYear($year);
                $merged   = array_merge($fallback, $merged);
            }

            ksort($merged);
            return $merged;
        });
    }

    /**
     * Ambil data hari libur resmi dari Google Calendar API atau Public Feed
     *
     * @param int $year
     * @return array
     */
    protected static function fetchFromGoogleCalendar(int $year): array
    {
        $holidays = [];
        $apiKey = config('services.google.calendar_api_key');

        // 1. Coba via Google Calendar API v3 jika API Key tersedia
        if (!empty($apiKey)) {
            try {
                $timeMin = Carbon::createFromDate($year, 1, 1)->startOfYear()->toRfc3339String();
                $timeMax = Carbon::createFromDate($year, 12, 31)->endOfYear()->toRfc3339String();
                $calendarIdUrl = urlencode(self::GOOGLE_CALENDAR_ID);

                $url = "https://www.googleapis.com/calendar/v3/calendars/{$calendarIdUrl}/events?" . http_build_query([
                    'key'          => $apiKey,
                    'timeMin'      => $timeMin,
                    'timeMax'      => $timeMax,
                    'singleEvents' => 'true',
                    'orderBy'      => 'startTime',
                    'maxResults'   => 100,
                ]);

                $response = Http::timeout(4)->get($url);
                if ($response->successful()) {
                    $data = $response->json();
                    foreach ($data['items'] ?? [] as $item) {
                        $dateStr = $item['start']['date'] ?? substr($item['start']['dateTime'] ?? '', 0, 10);
                        if (!empty($dateStr) && str_starts_with($dateStr, (string)$year)) {
                            $holidays[$dateStr] = [
                                'name'        => $item['summary'] ?? 'Hari Libur Nasional',
                                'type'        => 'national_holiday',
                                'description' => $item['description'] ?? 'Hari Libur Resmi Nasional Indonesia (Terkonfirmasi Google Calendar).',
                                'source'      => 'Google Calendar API',
                                'badge_color' => '#DC2626',
                            ];
                        }
                    }

                    if (!empty($holidays)) {
                        return $holidays;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Google Calendar API v3 request failed: " . $e->getMessage());
            }
        }

        // 2. Ambil via Google Calendar Official Public iCal Feed (Tanpa API Key, resmi Google)
        try {
            $feedUrl = 'https://calendar.google.com/calendar/ical/' . urlencode(self::GOOGLE_CALENDAR_ID) . '/public/basic.ics';
            $response = Http::timeout(4)->get($feedUrl);

            if ($response->successful()) {
                $body = $response->body();
                preg_match_all('/BEGIN:VEVENT[\s\S]*?END:VEVENT/', $body, $matches);

                foreach ($matches[0] ?? [] as $event) {
                    preg_match('/SUMMARY:(.*)/', $event, $sum);
                    preg_match('/DTSTART;VALUE=DATE:(\d{8})/', $event, $dt);
                    preg_match('/DESCRIPTION:(.*)/', $event, $desc);

                    if (!empty($dt[1]) && !empty($sum[1])) {
                        $dateStr = substr($dt[1], 0, 4) . '-' . substr($dt[1], 4, 2) . '-' . substr($dt[1], 6, 2);
                        if (str_starts_with($dateStr, (string)$year)) {
                            $name = trim($sum[1]);
                            $name = str_replace(['\\,', '\\;', '\\n', '\\'], [',', ';', ' ', ''], $name);

                            $rawDesc = trim($desc[1] ?? '');
                            $rawDesc = str_replace(['\\n', '\\,', '\\;', '\\'], ["\n", ',', ';', ''], $rawDesc);
                            // Hapus kalimat bawaan Google Calendar "Untuk menyembunyikan kalender..."
                            $rawDesc = preg_replace('/Untuk menyembunyikan kalender.*?$/is', '', $rawDesc);
                            $rawDesc = trim($rawDesc);

                            if (empty($rawDesc) || in_array(strtolower($rawDesc), ['perayaan', 'hari libur nasional', 'libur nasional'])) {
                                $description = "Hari libur / peringatan resmi {$name} terkonfirmasi dari Google Calendar.";
                            } else {
                                $description = $rawDesc;
                            }

                            $holidays[$dateStr] = [
                                'name'        => $name,
                                'type'        => 'national_holiday',
                                'description' => $description,
                                'source'      => 'Google Calendar',
                                'badge_color' => '#DC2626',
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning("Google Calendar Public iCal feed fetch failed: " . $e->getMessage());
        }

        return $holidays;
    }

    /**
     * Hari Peringatan Nasional & Peringatan Bersejarah Indonesia
     * (Termasuk Hari Santri Nasional 22 Oktober, Hari Sumpah Pemuda, Hari Pahlawan)
     *
     * @param int $year
     * @return array
     */
    protected static function getNationalObservances(int $year): array
    {
        return [
            sprintf('%04d-05-02', $year) => [
                'name'        => 'Hari Pendidikan Nasional',
                'type'        => 'observance',
                'description' => 'Peringatan kelahiran Ki Hadjar Dewantara, Bapak Pendidikan Nasional Indonesia.',
                'source'      => 'Kalender Nasional RI',
                'badge_color' => '#E11D48',
            ],
            sprintf('%04d-10-01', $year) => [
                'name'        => 'Hari Kesaktian Pancasila',
                'type'        => 'observance',
                'description' => 'Peringatan keteguhan dan kesaktian ideologi Pancasila bagi segenap bangsa Indonesia.',
                'source'      => 'Kalender Nasional RI',
                'badge_color' => '#E11D48',
            ],
            sprintf('%04d-10-22', $year) => [
                'name'        => 'Hari Santri Nasional',
                'type'        => 'national_holiday',
                'description' => 'Peringatan Resolusi Jihad KH Hasyim Asy\'ari (22 Oktober 1945) serta kontribusi perjuangan santri dalam mempertahankan kemerdekaan Republik Indonesia.',
                'source'      => 'Keppres No. 22 Tahun 2015',
                'badge_color' => '#DC2626',
            ],
            sprintf('%04d-10-28', $year) => [
                'name'        => 'Hari Sumpah Pemuda',
                'type'        => 'observance',
                'description' => 'Peringatan Kongres Pemuda II (1928) bertumpah darah satu, berbangsa satu, dan menjunjung bahasa persatuan bahasa Indonesia.',
                'source'      => 'Kalender Nasional RI',
                'badge_color' => '#E11D48',
            ],
            sprintf('%04d-11-10', $year) => [
                'name'        => 'Hari Pahlawan Nasional',
                'type'        => 'observance',
                'description' => 'Peringatan Pertempuran Surabaya 10 November 1945 untuk mengenang jasa dan pengorbanan para pahlawan kemerdekaan.',
                'source'      => 'Kalender Nasional RI',
                'badge_color' => '#E11D48',
            ],
            sprintf('%04d-11-25', $year) => [
                'name'        => 'Hari Guru Nasional',
                'type'        => 'observance',
                'description' => 'Peringatan hari lahir Persatuan Guru Republik Indonesia (PGRI) dan dedikasi seluruh guru pengajar.',
                'source'      => 'Kalender Nasional RI',
                'badge_color' => '#E11D48',
            ],
        ];
    }

    /**
     * Dataset Cadangan Offline jika jaringan internet server offline
     *
     * @param int $year
     * @return array
     */
    protected static function getOfflineHolidaysForYear(int $year): array
    {
        $fixed = [
            sprintf('%04d-01-01', $year) => ['name' => 'Tahun Baru Masehi', 'type' => 'national_holiday', 'description' => 'Perayaan pergantian tahun kalender Masehi.'],
            sprintf('%04d-05-01', $year) => ['name' => 'Hari Buruh Internasional', 'type' => 'national_holiday', 'description' => 'Peringatan Hari Buruh Internasional (May Day).'],
            sprintf('%04d-06-01', $year) => ['name' => 'Hari Lahir Pancasila', 'type' => 'national_holiday', 'description' => 'Peringatan kelahiran falsafah dasar negara Pancasila.'],
            sprintf('%04d-08-17', $year) => ['name' => 'Hari Kemerdekaan RI', 'type' => 'national_holiday', 'description' => 'Peringatan Proklamasi Kemerdekaan Republik Indonesia 17 Agustus 1945.'],
            sprintf('%04d-12-25', $year) => ['name' => 'Hari Raya Natal', 'type' => 'national_holiday', 'description' => 'Hari raya peringatan kelahiran Yesus Kristus.'],
        ];

        $movable = [
            2026 => [
                '2026-01-16' => ['name' => 'Isra Mi\'raj Nabi Muhammad SAW', 'type' => 'national_holiday', 'description' => 'Peringatan perjalanan agung Nabi Muhammad SAW.'],
                '2026-02-17' => ['name' => 'Tahun Baru Imlek 2577 Kongzili', 'type' => 'national_holiday', 'description' => 'Tahun Baru penanggalan lunar Tionghoa.'],
                '2026-03-19' => ['name' => 'Hari Suci Nyepi Tahun Baru Saka 1948', 'type' => 'national_holiday', 'description' => 'Perayaan Tahun Baru Saka dengan keheningan dan meditasi.'],
                '2026-03-20' => ['name' => 'Cuti Bersama Idul Fitri', 'type' => 'national_holiday', 'description' => 'Cuti Bersama Hari Raya Idul Fitri.'],
                '2026-03-21' => ['name' => 'Hari Raya Idul Fitri 1447 H', 'type' => 'national_holiday', 'description' => 'Hari Raya Idul Fitri 1 Syawal 1447 H.'],
                '2026-03-22' => ['name' => 'Hari Raya Idul Fitri 1447 H (Hari ke-2)', 'type' => 'national_holiday', 'description' => 'Hari Raya Idul Fitri hari kedua.'],
                '2026-04-03' => ['name' => 'Wafat Yesus Kristus (Jumat Agung)', 'type' => 'national_holiday', 'description' => 'Peringatan wafat Yesus Kristus.'],
                '2026-04-05' => ['name' => 'Hari Raya Paskah', 'type' => 'national_holiday', 'description' => 'Peringatan kebangkitan Yesus Kristus.'],
                '2026-05-14' => ['name' => 'Kenaikan Yesus Kristus', 'type' => 'national_holiday', 'description' => 'Peringatan kenaikan Yesus Kristus ke surga.'],
                '2026-05-27' => ['name' => 'Hari Raya Idul Adha 1447 H', 'type' => 'national_holiday', 'description' => 'Hari Raya Kurban 10 Dzulhijjah 1447 H.'],
                '2026-05-31' => ['name' => 'Hari Raya Waisak 2570 BE', 'type' => 'national_holiday', 'description' => 'Hari Trisuci Waisak.'],
                '2026-06-17' => ['name' => 'Tahun Baru Islam 1448 H', 'type' => 'national_holiday', 'description' => 'Tahun Baru 1 Muharram kalender Hijriah.'],
                '2026-08-25' => ['name' => 'Maulid Nabi Muhammad SAW', 'type' => 'national_holiday', 'description' => 'Peringatan kelahiran Nabi Muhammad SAW.'],
            ]
        ];

        $yMovable = $movable[$year] ?? [];
        $merged = array_merge($fixed, $yMovable);
        foreach ($merged as $k => $v) {
            $merged[$k]['source'] = 'Kalender Nasional Terverifikasi';
            $merged[$k]['badge_color'] = '#DC2626';
        }

        return $merged;
    }
}
