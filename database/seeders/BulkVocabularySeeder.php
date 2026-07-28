<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BulkVocabularySeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan log query untuk menghemat memori saat insert besar
        DB::disableQueryLog();

        $prefixIndo = [
            'Agung', 'Arah', 'Angkat', 'Ajak', 'Alir', 'Ambil', 'Amuk', 'Anggap', 'Anjur', 'Antar',
            'Bakar', 'Balas', 'Balik', 'Bandung', 'Bangun', 'Banting', 'Bantu', 'Baring', 'Bawa', 'Bayar',
            'Cari', 'Catur', 'Cegah', 'Cetak', 'Cium', 'Coba', 'Cocok', 'Cucu', 'Cubit', 'Cukur',
            'Dapat', 'Darat', 'Dengar', 'Diri', 'Dorong', 'Duduk', 'Dugaan', 'Duka', 'Dunia', 'Dapur',
            'Ejek', 'Elak', 'Elus', 'Emban', 'Empat', 'Enam', 'Endap', 'Enggan', 'Ekor', 'Emas',
            'Faham', 'Fajar', 'Fikir', 'Fokus', 'Fungsi', 'Firasat', 'Fasilitas', 'Format', 'Fakta', 'Faktor',
            'Gali', 'Gambar', 'Ganti', 'Garap', 'Garis', 'Gelar', 'Genggam', 'Goyang', 'Gugur', 'Gulung',
            'Hapus', 'Harap', 'Hasil', 'Hati', 'Hembus', 'Henti', 'Hias', 'Hidung', 'Hidung', 'Hormat',
            'Ikat', 'Ikut', 'Ingat', 'Ingin', 'Intip', 'Isi', 'Isyarat', 'Izin', 'Ikat', 'Irama',
            'Jaga', 'Jalan', 'Jawab', 'Jemput', 'Jeput', 'Jual', 'Judi', 'Jujur', 'Jumpa', 'Jemur',
            'Kabar', 'Kabul', 'Kala', 'Kalah', 'Kalis', 'Kirim', 'Kunci', 'Kumpul', 'Kupas', 'Kira',
            'Laku', 'Lari', 'Lempar', 'Lihat', 'Lompat', 'Lupa', 'Lurus', 'Latih', 'Layan', 'Lipur',
            'Makan', 'Mandi', 'Masuk', 'Minum', 'Minta', 'Masak', 'Milik', 'Mula', 'Muat', 'Maju',
            'Naik', 'Nyalakan', 'Nikmati', 'Nonton', 'Nanti', 'Niat', 'Nasihat', 'Nol', 'Nafas', 'Nenek',
            'Obat', 'Olahraga', 'Olah', 'Oper', 'Ukurb', 'Ukung', 'Umpan', 'Ukir', 'Ulas', 'Ukuran',
            'Panggil', 'Pegang', 'Petik', 'Pikir', 'Pilih', 'Pindah', 'Potong', 'Putar', 'Pakai', 'Pukul',
            'Raba', 'Rakit', 'Rasa', 'Rawat', 'Rebus', 'Reka', 'Rendam', 'Rindu', 'Roboh', 'Rujuk',
            'Sapa', 'Sapu', 'Sewa', 'Simpan', 'Siram', 'Suruh', 'Sapu', 'Saring', 'Sambut', 'Sulam',
            'Tanam', 'Tanya', 'Tarik', 'Tulis', 'Tutup', 'Tidur', 'Timbang', 'Tolong', 'Tuntut', 'Tukar',
            'Ucap', 'Uji', 'Ukang', 'Ulang', 'Ukur', 'Ukuh', 'Undang', 'Ungkap', 'Urus', 'Usaha',
            'Warna', 'Waris', 'Waspada', 'Wujud', 'Wadah', 'Wawancara', 'Waktu', 'Wajah', 'Warga', 'Wanita',
            'Yakin', 'Yatim', 'Yuyu', 'Yayasan', 'Yuris', 'Yurisdiksi', 'Yodium', 'Yohanes', 'Yuwana', 'Yoga',
            'Ziarah', 'Zaman', 'Zakat', 'Zebra', 'Zona', 'Zitir', 'Zulum', 'Zenith', 'Zat', 'ZODIAK'
        ];

        $totalWordsNeeded = 20500;
        $batchSize = 2500;
        $records = [];
        $count = 0;

        for ($i = 1; $i <= $totalWordsNeeded; $i++) {
            $basePrefix = $prefixIndo[($i - 1) % count($prefixIndo)];
            $numSuffix = floor(($i - 1) / count($prefixIndo)) + 1;
            
            $indo = $numSuffix == 1 ? "Kata {$basePrefix}" : "Kata {$basePrefix} {$numSuffix}";
            $ngoko = "Tembung {$basePrefix} Ngoko " . ($numSuffix == 1 ? "" : $numSuffix);
            $krama = "Tembung {$basePrefix} Krama " . ($numSuffix == 1 ? "" : $numSuffix);

            $records[] = [
                'indonesian_word'    => trim($indo),
                'javanese_ngoko'     => trim($ngoko),
                'javanese_krama'     => trim($krama),
                'example_indonesian' => "Contoh penggunaan kalimat untuk {$indo}.",
                'example_ngoko'      => "Tuladha panganggo ukara kagem {$ngoko}.",
                'example_krama'      => "Tuladha panganggenipun ukara kagem {$krama}.",
                'created_at'         => now(),
                'updated_at'         => now(),
            ];

            if (count($records) >= $batchSize) {
                DB::table('vocabularies')->insert($records);
                $records = [];
            }
        }

        if (count($records) > 0) {
            DB::table('vocabularies')->insert($records);
        }
    }
}
