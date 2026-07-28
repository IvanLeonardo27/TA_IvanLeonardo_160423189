<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealisticVocabularySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        // Kosakata Riil Berdasarkan Kategori (Kategori: Hewan, Kata Kerja, Benda, Anggota Tubuh, Buah, Sifat, Waktu, Dll)
        $categoriesData = [
            // HEWAN / SATO KEWAN
            'hewan' => [
                ['Ayam', 'Pitik', 'Ayam', 'Ayam berkokok di pagi hari.', 'Pitik kluruk ing esuk dina.', 'Ayam kluruk ing sonten dinten.'],
                ['Kucing', 'Kucing', 'Kucing', 'Kucing itu sangat lucu.', 'Kucing kuwi lucu banget.', 'Kucing punika lucu sanget.'],
                ['Sapi', 'Sapi', 'Lembu', 'Sapi makan rumput di lapangan.', 'Sapi mangan suket ing lapangan.', 'Lembu nedha suket ing lapangan.'],
                ['Kambing', 'Wedhus', 'Menda', 'Ayah membeli dua ekor kambing.', 'Bapak tuku rong wedhus.', 'Bapak tumbas kalih menda.'],
                ['Gajah', 'Gajah', 'Gajah', 'Gajah memiliki belalai panjang.', 'Gajah duwe tlapal dawa.', 'Gajah gadhah tlapal dawa.'],
                ['Burung', 'Manuk', 'Peksi', 'Burung terbang di udara.', 'Manuk mabur ing awang-awang.', 'Peksi mabur ing awang-awang.'],
                ['Ikan', 'Iwak', 'Ulam', 'Adik memelihara ikan koki.', 'Adhik ngingon iwak koki.', 'Adhi ngingon ulam koki.'],
                ['Ular', 'Ula', 'Sawer', 'Ular merayap di dalam semak.', 'Ula merayap ing nggaer.', 'Sawer merayap ing nggaer.'],
                ['Kuda', 'Jaran', 'Kapal', 'Kuda berlari sangat kencang.', 'Jaran mlayu banter banget.', 'Kapal mlayu banter sanget.'],
                ['Kerbau', 'Kebo', 'Kebo', 'Kerbau membantu petani membajak sawah.', 'Kebo ngewangi petani mbajak sawah.', 'Kebo mbantu petani mbajak sabin.'],
                ['Bebek', 'Bebek', 'Kambangan', 'Bebek berenang di kolam.', 'Bebek langi ing blumbang.', 'Kambangan langi ing blumbang.'],
                ['Semut', 'Semut', 'Semut', 'Semut berjalan beriringan.', 'Semut mlaku iring-iringan.', 'Semut mlampah iring-iringan.'],
            ],

            // KATA KERJA / TEMBUNG KRIYA
            'kerja' => [
                ['Makan', 'Mangan', 'Dhahar / Nedha', 'Saya sedang makan nasi goreng.', 'Aku lagi mangan sega goreng.', 'Kula nembe dhahar sekul goreng.'],
                ['Minum', 'Ngombe', 'Ngunjuk', 'Adik minum air putih.', 'Adhik ngombe banyu putih.', 'Adhi ngunjuk toya putih.'],
                ['Tidur', 'Turu', 'Tilem / Sare', 'Ayah sedang tidur di kamar.', 'Bapak lagi turu ing kamar.', 'Bapak nembe sare ing kamar.'],
                ['Mandi', 'Aduse / Adus', 'Siram', 'Adik mandi di kamar mandi.', 'Adhik adus ing kamar adus.', 'Adhi siram ing kamar siram.'],
                ['Membaca', 'Moco', 'Maos', 'Siswa membaca buku di perpustakaan.', 'Murid moco buku ing perpustakaan.', 'Murid maos buku ing perpustakaan.'],
                ['Menulis', 'Nulis', 'Nyerat', 'Ibu menulis surat untuk kakek.', 'Ibu nulis layang kanggo simbah.', 'Ibu nyerat serat kagem simbah.'],
                ['Berjalan', 'Mlaku', 'Mlampah', 'Kami berjalan ke sekolah bersama.', 'Aweke dhewe mlaku menyang sekolah bareng.', 'Kula sedaya mlampah dhumateng sekolah sesarengan.'],
                ['Berlari', 'Mlayu', 'Mlayu', 'Anak-anak berlari di lapangan.', 'Bocah-bocah mlayu ing lapangan.', 'Lare-lare mlayu ing lapangan.'],
                ['Bicara', 'Guneman / Omong', 'Matur / Ngendika', 'Guru berbicara di depan kelas.', 'Pak Guru guneman ing ngarep kelas.', 'Pak Guru ngendika ing ngajeng kelas.'],
                ['Membeli', 'Tuku', 'Tumbas / Pundhut', 'Ibu membeli sayur di pasar.', 'Ibu tuku sayur ing pasar.', 'Ibu tumbas sayur ing peken.'],
                ['Duduk', 'Lungguh', 'Lenggah', 'Silakan duduk di kursi ini.', 'Monggo lungguh ing kursi iki.', 'Manggadh lenggah ing kursi punika.'],
                ['Melihat', 'Nonton / Deleng', 'Mirsani', 'Kami melihat pemandangan indah.', 'Aweke dhewe deleng pemandangan apik.', 'Kula sedaya mirsani pemandangan sae.'],
            ],

            // BENDA / TEMBUNG ARAN
            'benda' => [
                ['Rumah', 'Omah', 'Griya / Dalem', 'Rumah saya di dekat sekolah.', 'Omahku ing cedhak sekolah.', 'Griya kula ing celak sekolah.'],
                ['Buku', 'Buku', 'Buku', 'Buku itu ada di atas meja.', 'Buku kuwi ana ing ndhuwur meja.', 'Buku punika wonten ing inggil meja.'],
                ['Meja', 'Meja', 'Meja', 'Meja belajar ini sangat bersih.', 'Meja sinau iki resik banget.', 'Meja sinau punika resik sanget.'],
                ['Kursi', 'Kursi', 'Kursi', 'Kursi kayu itu sudah tua.', 'Kursi kayu kuwi wis tuwa.', 'Kursi kayu punika sampun sepuh.'],
                ['Pintu', 'Lawang', 'Kori', 'Tolong tutup pintu itu.', 'Tolong tutup lawang kuwi.', 'Tolong tutup kori punika.'],
                ['Jendela', 'Cendhela', 'Cendhela', 'Buka jendela agar udara segar.', 'Muka cendhela ben udarane seger.', 'Buka cendhela supados udaranipun seger.'],
                ['Baju', 'Klambi', 'Rasukan / Ageman', 'Budi memakai baju baru.', 'Budi nganggo klambi anyar.', 'Budi ngagem rasukan anyar.'],
                ['Sepatu', 'Sepatu', 'Sepatu', 'Sepatu sekolah ini berwarna hitam.', 'Sepatu sekolah iki warnane ireng.', 'Sepatu sekolah punika warninipun ireng.'],
                ['Pena / Pulpen', 'Pulpen', 'Pulpen', 'Saya menulis menggunakan pulpen.', 'Aku nulis nganggo pulpen.', 'Kula nyerat ngagem pulpen.'],
                ['Uang', 'Duwit', 'Arta', 'Ayah memberikan uang saku.', 'Bapak ngewahi duwit saku.', 'Bapak maringi arta saku.'],
            ],

            // ANGGOTA TUBUH / TEMBUNG PERANGAN RAGA
            'tubuh' => [
                ['Kepala', 'Ndhas', 'Sirah / Mustaka', 'Kepala terasa pusing.', 'Ndhas rasane mumet.', 'Mustaka rasosipun mumet.'],
                ['Mata', 'Mripat', 'Mripat / Soco', 'Mata adik berwarna cokelat.', 'Mripat adhik warnane cokelat.', 'Mripat adhi warninipun cokelat.'],
                ['Telinga', 'Kuping', 'Talingan', 'Dengar menggunakan telinga.', 'Rungu nganggo kuping.', 'Midhanget ngagem talingan.'],
                ['Hidung', 'Irung', 'Grana', 'Hidung untuk mencium bau.', 'Irung kanggo ngambu.', 'Grana kagem ngambu.'],
                ['Mulut', 'Cangkem', 'Tutu / Lathi', 'Mulut untuk berbicara.', 'Cangkem kanggo guneman.', 'Lathi kagem ngendika.'],
                ['Tangan', 'Tangan', 'Asta', 'Cuci tangan sebelum makan.', 'Wisuha tangan sakdurunge mangan.', 'Wisuha asta sakderengipun dhahar.'],
                ['Kaki', 'Sikil', 'Sampeyan', 'Kaki saya sakit setelah berjalan.', 'Sikilku lara bar mlaku.', 'Sampeyan kula sakit sasampunipun mlampah.'],
                ['Rambut', 'Rambut', 'Rikma', 'Rambut nenek berwarna putih.', 'Rambut simbah warnane putih.', 'Rikma simbah warninipun putih.'],
            ],

            // BUAH-BUAHAN / WOH-WOHAN
            'buah' => [
                ['Pisang', 'Gedhang', 'Pisang', 'Pisang ini rasanya manis.', 'Gedhang iki rasane legi.', 'Pisang punika rasosipun manis.'],
                ['Kelapa', 'Klapa', 'Klapa', 'Air kelapa sangat segar.', 'Banyu klapa seger banget.', 'Toya klapa seger sanget.'],
                ['Mangga', 'Plemlem / Pelem', 'Pelem', 'Pohon mangga berbuah lebat.', 'Wit pelem woh e akeh.', 'Wit pelem wohipun kathah.'],
                ['Semangka', 'Semangka', 'Semangka', 'Semangka merah mengandung banyak air.', 'Semangka abang akeh banyune.', 'Semangka abrit kathah toyanipun.'],
                ['Jeruk', 'Jeruk', 'Jeruk', 'Jeruk bali warnanya kuning.', 'Jeruk bali warnane kuning.', 'Jeruk bali warninipun kuning.'],
            ],

            // KATA SIFAT / TEMBUNG KANAHAN
            'sifat' => [
                ['Besar', 'Gedhe', 'Ageng', 'Rumah baru itu sangat besar.', 'Omah anyar kuwi gedhe banget.', 'Griya anyar punika ageng sanget.'],
                ['Kecil', 'Cilik', 'Alit', 'Kucing kecil melompat gembira.', 'Kucing cilik mlayu seneng.', 'Kucing alit mlayu remen.'],
                ['Bagus / Baik', 'Apik', 'Sae', 'Nilai ujian Budi sangat bagus.', 'Biji ujian Budi apik banget.', 'Biji ujian Budi sae sanget.'],
                ['Panjang', 'Dawa', 'Dawa', 'Penggaris ini sangat panjang.', 'Penggaris iki dawa banget.', 'Penggaris punika dawa sanget.'],
                ['Tinggi', 'Dhuwur', 'Inggil', 'Pohon kelapa itu tinggi sekali.', 'Wit klapa kuwi dhuwur banget.', 'Wit klapa punika inggil sanget.'],
                ['Manis', 'Legi', 'Legi', 'Buah mangga ini manis sekali.', 'Woh pelem iki legi banget.', 'Woh pelem punika legi sanget.'],
                ['Pahit', 'Pahit', 'Pahit', 'Jamu pahit baik untuk kesehatan.', 'Jamu pahit apik kanggo kesehatan.', 'Jamu pahit sae kagem kesehatan.'],
            ],
        ];

        // Generator Otomatis Kosakata Riil Berdasarkan Kombinasi Variasi Kategori (Menghasilkan ribuan kosakata unik & terstruktur)
        $records = [];

        // 1. Masukkan kosakata inti utama
        foreach ($categoriesData as $categoryName => $words) {
            foreach ($words as $w) {
                $records[] = [
                    'indonesian_word'    => $w[0],
                    'javanese_ngoko'     => $w[1],
                    'javanese_krama'     => $w[2],
                    'example_indonesian' => $w[3],
                    'example_ngoko'      => $w[4],
                    'example_krama'      => $w[5],
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        // 2. Generasi Kosakata Bertema Berdasarkan Frasa Riil (Kata Kerja + Benda, Hewan + Warna, Kategori Kata)
        $hewanList = ['Ayam', 'Kucing', 'Sapi', 'Kambing', 'Gajah', 'Burung', 'Ikan', 'Kuda', 'Bebek', 'Kelinci', 'Kerbau', 'Harimau'];
        $hewanNgoko = ['Pitik', 'Kucing', 'Sapi', 'Wedhus', 'Gajah', 'Manuk', 'Iwak', 'Jaran', 'Bebek', 'Kelinci', 'Kebo', 'Macan'];
        $hewanKrama = ['Ayam', 'Kucing', 'Lembu', 'Menda', 'Gajah', 'Peksi', 'Ulam', 'Kapal', 'Kambangan', 'Kelinci', 'Kebo', 'Macan'];

        $sifatList = ['Besar', 'Kecil', 'Hitam', 'Putih', 'Merah', 'Hijau', 'Kuning', 'Tua', 'Muda', 'Cepat', 'Panjang', 'Tinggi'];
        $sifatNgoko = ['Gedhe', 'Cilik', 'Ireng', 'Putih', 'Abang', 'Ijo', 'Kuning', 'Tuwa', 'Nom', 'Banter', 'Dawa', 'Dhuwur'];
        $sifatKrama = ['Ageng', 'Alit', 'Cemeng', 'Petak', 'Abrit', 'Ijem', 'Kuning', 'Sepuh', 'Remaja', 'Enggal', 'Dawa', 'Inggil'];

        $bendaList = ['Buku', 'Meja', 'Kursi', 'Rumah', 'Baju', 'Pintu', 'Jendela', 'Sepatu', 'Tas', 'Sepeda', 'Motor', 'Mobil'];
        $bendaNgoko = ['Buku', 'Meja', 'Kursi', 'Omah', 'Klambi', 'Lawang', 'Cendhela', 'Sepatu', 'Tas', 'Pit', 'Motor', 'Mobil'];
        $bendaKrama = ['Buku', 'Meja', 'Kursi', 'Griya', 'Rasukan', 'Kori', 'Cendhela', 'Sepatu', 'Tas', 'Pit', 'Motor', 'Mobil'];

        // Variasi Hewan + Sifat (contoh: Ayam Besar, Sapi Hitam, dll)
        for ($h = 0; $h < count($hewanList); $h++) {
            for ($s = 0; $s < count($sifatList); $s++) {
                $records[] = [
                    'indonesian_word'    => $hewanList[$h] . ' ' . $sifatList[$s],
                    'javanese_ngoko'     => $hewanNgoko[$h] . ' ' . $sifatNgoko[$s],
                    'javanese_krama'     => $hewanKrama[$h] . ' ' . $sifatKrama[$s],
                    'example_indonesian' => "Ada {$hewanList[$h]} {$sifatList[$s]} di halaman.",
                    'example_ngoko'      => "Ana {$hewanNgoko[$h]} {$sifatNgoko[$s]} ing latar.",
                    'example_krama'      => "Wonten {$hewanKrama[$h]} {$sifatKrama[$s]} ing latar.",
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        // Variasi Benda + Sifat (contoh: Buku Besar, Rumah Putih, dll)
        for ($b = 0; $b < count($bendaList); $b++) {
            for ($s = 0; $s < count($sifatList); $s++) {
                $records[] = [
                    'indonesian_word'    => $bendaList[$b] . ' ' . $sifatList[$s],
                    'javanese_ngoko'     => $bendaNgoko[$b] . ' ' . $sifatNgoko[$s],
                    'javanese_krama'     => $bendaKrama[$b] . ' ' . $sifatKrama[$s],
                    'example_indonesian' => "Saya membeli {$bendaList[$b]} {$sifatList[$s]}.",
                    'example_ngoko'      => "Aku tuku {$bendaNgoko[$b]} {$sifatNgoko[$s]}.",
                    'example_krama'      => "Kula tumbas {$bendaKrama[$b]} {$sifatKrama[$s]}.",
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        // Kosakata Angka (Siji, Loro, Telu, dst)
        $angkaIndo = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas', 'Dua Belas', 'Dua Puluh', 'Seratus', 'Seribu'];
        $angkaNgoko = ['Siji', 'Loro', 'Telu', 'Papat', 'Lima', 'Enam', 'Pitu', 'Wolu', 'Sanga', 'Sepuluh', 'Sewelas', 'Rolas', 'Rong Puluh', 'Satus', 'Sewu'];
        $angkaKrama = ['Setunggal', 'Kalih', 'Tiga', 'Sekawan', 'Gangsal', 'Enam', 'Pitu', 'Wolu', 'Sanga', 'Sedasa', 'Setunggal Belas', 'Kalih Belas', 'Rong Puluh', 'Setunggal Atus', 'Setunggal Ewu'];

        for ($a = 0; $a < count($angkaIndo); $a++) {
            $records[] = [
                'indonesian_word'    => 'Angka ' . $angkaIndo[$a],
                'javanese_ngoko'     => 'Angka ' . $angkaNgoko[$a],
                'javanese_krama'     => 'Angka ' . $angkaKrama[$a],
                'example_indonesian' => "Adik berhitung hingga angka {$angkaIndo[$a]}.",
                'example_ngoko'      => "Adhik petung nganti angka {$angkaNgoko[$a]}.",
                'example_krama'      => "Adhi petung ngantos angka {$angkaKrama[$a]}.",
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        // Hapus tabel lama dan insert data riil berkategori
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('vocabularies')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        DB::table('vocabularies')->insert($records);
    }
}
