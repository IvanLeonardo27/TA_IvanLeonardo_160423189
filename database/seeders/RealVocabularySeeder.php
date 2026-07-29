<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use App\Models\VocabularyExample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RealVocabularySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        $dataset = [
            // Batch A-1
            [1, "Abadi", "Langgeng", "Langgeng", null, "Persahabatan mereka tetap abadi.", "Paseduluran dheweke tetep langgeng.", "Pasaduluranipun tetep langgeng."],
            [2, "Abang", "Abang", "Abrit", null, "Baju abang itu baru.", "Klambi abang kuwi anyar.", "Busana abrit punika enggal."],
            [3, "Abu", "Awu", "Awu", null, "Abu itu tertiup angin.", "Awu kuwi kebur angin.", "Awu punika kabur angin."],
            [4, "Acak", "Acak", null, null, "Rambutnya tampak acak.", "Rambute katon acak.", "Rikmanipun katingal acak."],
            [5, "Acara", "Acara", "Adicara", null, "Acara sekolah dimulai pagi.", "Acara sekolah diwiwiti esuk.", "Adicara sekolah dipunwiwiti enjing."],
            [6, "Adab", "Tata krama", "Tata krama", null, "Anak harus memiliki adab baik.", "Bocah kudu nduweni tata krama apik.", "Putra kedah gadhah tata krama sae."],
            [7, "Adik", "Adhik", "Adhi", null, "Adik sedang belajar.", "Adhik lagi sinau.", "Adhi saweg sinau."],
            [8, "Adil", "Adil", "Adil", null, "Guru bersikap adil.", "Guru tumindak adil.", "Guru gadhah sipat adil."],
            [9, "Adu", "Adu", "Adu", null, "Jangan adu temanmu.", "Aja ngadu kancamu.", "Sampun ngadu kanca panjenengan."],
            [10, "Aduk", "Aduk", "Aduk", null, "Ibu mengaduk sayur.", "Ibu ngaduk jangan.", "Ibu ngaduk janganan."],
            [11, "Agama", "Agama", "Agami", null, "Kami belajar agama.", "Kita sinau agama.", "Kula sinau agami."],
            [12, "Agen", "Agen", "Agen", null, "Ayah bertemu agen.", "Bapak ketemu agen.", "Rama kepanggih agen."],
            [13, "Agung", "Ageng", "Ageng", null, "Gedung itu sangat agung.", "Gedhong kuwi gedhe lan ageng.", "Gedhong punika ageng sanget."],
            [14, "Air", "Banyu", "Toya", null, "Saya minum air putih.", "Aku ngombe banyu putih.", "Kula ngunjuk toya putih."],
            [15, "Air mata", "Luh", "Waspa", null, "Air mata adik jatuh.", "Luhe adhik tiba.", "Waspanipun adhi dhawah."],
            [16, "Ajaib", "Ajaib", "Ajaib", null, "Cerita itu sangat ajaib.", "Crita kuwi ajaib.", "Cariyos punika ajaib."],
            [17, "Ajak", "Ajak", "Ajak", null, "Saya mengajak teman bermain.", "Aku ngajak kanca dolanan.", "Kula ngajak kanca dolanan."],
            [18, "Ajar", "Ajar", "Ajar", null, "Guru mengajar matematika.", "Guru mulang matematika.", "Guru mucal matematika."],
            [19, "Akal", "Akal", "Akal", null, "Manusia memiliki akal.", "Manungsa nduweni akal.", "Manungsa gadhah akal."],
            [20, "Akar", "Oyot", "Oyot", null, "Akar pohon kuat.", "Oyot wit kuwat.", "Oyot uwit kiyat."],
            [21, "Akhir", "Pungkasan", "Pungkasan", null, "Ini akhir cerita.", "Iki pungkasan crita.", "Punika pungkasan cariyos."],
            [22, "Akibat", "Akibat", "Akibat", null, "Itu akibat terlambat.", "Kuwi akibat telat.", "Punika akibat kendel."],
            [23, "Aku", "Aku", "Kula", null, "Aku senang belajar.", "Aku seneng sinau.", "Kula remen sinau."],
            [24, "Alam", "Alam", "Alam", null, "Alam harus dijaga.", "Alam kudu dijaga.", "Alam kedah dipunjagi."],
            [25, "Alamat", "Alamat", "Alamat", null, "Tulis alamat rumahmu.", "Tulis alamat omahmu.", "Serat alamat griya panjenengan."],
            [26, "Alas", "Landhesan", null, null, "Gelas diberi alas.", "Gelas diwenehi landhesan.", "Gelas dipunparingi landhesan."],
            [27, "Alas kaki", "Sendhal", "Selop", null, "Ayah memakai alas kaki.", "Bapak nganggo sendhal.", "Rama ngagem selop."],
            [28, "Alat", "Piranti", "Piranti", null, "Guru membawa alat tulis.", "Guru nggawa piranti nulis.", "Guru nggawa piranti nyerat."],
            [29, "Alis", "Alis", "Alis", null, "Alis ibu rapi.", "Alise ibu rapi.", "Alisipun ibu rapi."],
            [30, "Alpukat", "Alpukat", "Alpukat", null, "Saya membeli alpukat.", "Aku tuku alpukat.", "Kula mundhut alpukat."],
            [31, "Alun-alun", "Alun-alun", "Alun-alun", null, "Kami bermain di alun-alun.", "Kita dolanan ing alun-alun.", "Kula dolanan wonten alun-alun."],
            [32, "Ambil", "Jupuk", "Pendhet", null, "Tolong ambil buku itu.", "Tulung jupuk buku kuwi.", "Sumangga pendhet buku punika."],
            [33, "Ambulans", "Ambulan", "Ambulan", null, "Ambulans datang cepat.", "Ambulan teka cepet.", "Ambulan rawuh rikat."],
            [34, "Amin", "Amin", "Amin", null, "Kami mengucapkan amin.", "Kita ngucap amin.", "Kula ngaturaken amin."],
            [35, "Ampuh", "Mujarab", "Mujarab", null, "Obat itu ampuh.", "Obat kuwi mujarab.", "Obat punika mujarab."],
            [36, "Anak", "Bocah/Anak", "Putra/Putri", null, "Anak itu bermain.", "Bocah kuwi dolanan.", "Putra punika dolanan."],
            [37, "Anak ayam", "Pitik cilik", "Anak pitik", null, "Anak ayam mengikuti induknya.", "Pitik cilik ngetutake babone.", "Anak pitik ndherek babonipun."],
            [38, "Anak tangga", "Undhakan", "Undhakan", null, "Hati-hati di anak tangga.", "Ati-ati ing undhakan.", "Prayogi ngati-ati wonten undhakan."],
            [39, "Anak panah", "Panah", "Panah", null, "Anak panah itu tajam.", "Panah kuwi landhep.", "Panah punika landhep."],
            [40, "Anggrek", "Anggrèk", "Anggrèk", null, "Ibu menanam anggrek.", "Ibu nandur anggrèk.", "Ibu nandur anggrèk."],
            [41, "Angin", "Angin", "Angin", null, "Angin bertiup pelan.", "Angin semribit alon.", "Angin semribit alon."],
            [42, "Angka", "Angka", null, null, "Guru menulis angka lima.", "Guru nulis angka lima.", "Guru nyerat angka gangsal."],
            [43, "Angsa", "Angsa", "Angsa", null, "Angsa berenang di kolam.", "Angsa nglangi ing blumbang.", "Angsa nglangi wonten blumbang."],
            [1845, "Zebra cross", "Lintasan sebrang", "Lintasan nyebrang", "Transportasi", "Kami menyeberang di zebra cross.", "Kita nyebrang ing lintasan sebrang.", "Kula nyebrang wonten lintasan nyebrang."],
            [1846, "Zaman", "Jaman", "Jaman", "Waktu", "Zaman terus berubah.", "Jaman terus owah.", "Jaman tansah ewah."],
            [1847, "Ziarah kubur", "Nyekar", "Ziarah pasareyan", "Agama", "Keluarga melakukan ziarah kubur.", "Kulawarga nyekar.", "Kulawarga ziarah pasareyan."],
            [1848, "Zodiak", "Zodiak", "Zodiak", "Istilah Modern", "Dia membaca zodiak hari ini.", "Dheweke maca zodiak dina iki.", "Piyambakipun maos zodiak dinten punika."],
            [1849, "Zumba", "Zumba", "Zumba", "Olahraga", "Ibu mengikuti senam zumba.", "Ibu melu senam zumba.", "Ibu ndherek senam zumba."],
            [1850, "Zona waktu", "Zona wektu", "Zona wekdal", "Geografi", "Indonesia memiliki tiga zona waktu.", "Indonesia nduweni telung zona wektu.", "Indonesia gadhah tigang zona wekdal."],
            [1860, "Zat gizi", "Zat gizi", "Zat gizi", "Kesehatan", "Buah mengandung banyak zat gizi.", "Woh ngandhut akeh zat gizi.", "Woh ngemot kathah zat gizi."],
            [1861, "Zat besi", "Zat wesi", "Zat wesi", "Kesehatan", "Bayam mengandung zat besi.", "Bayem ngandhut zat wesi.", "Bayem ngemot zat wesi."],
            [1862, "Zat cair", "Zat cair", "Zat cair", "Sains", "Air termasuk zat cair.", "Banyu klebu zat cair.", "Toya kalebet zat cair."],
            [1863, "Zat padat", "Zat padhet", "Zat padhet", "Sains", "Es termasuk zat padat.", "Ès klebu zat padhet.", "Ès kalebet zat padhet."],
            [1864, "Zat warna", "Zat warna", "Zat warna", "Sains", "Kunyit menghasilkan zat warna alami.", "Kunir ngasilake zat warna alami.", "Kunir ngasilaken zat warna alami."],
            [1865, "Zikir pagi", "Dzikir esuk", "Dzikir enjing", "Agama", "Kakek membaca zikir pagi.", "Mbah maca dzikir esuk.", "Eyang maos dzikir enjing."],
            [1866, "Zikir petang", "Dzikir sore", "Dzikir sonten", "Agama", "Ibu membaca zikir petang.", "Ibu maca dzikir sore.", "Ibu maos dzikir sonten."],
            [1867, "Zebra laut", "Zebra laut", "Zebra laut", "Hewan", "Zebra laut hidup di segara.", "Zebra laut urip ing segara.", "Zebra laut gesang wonten seganten."],
            [1868, "Zona aman", "Zona aman", "Zona aman", "Keamanan", "Anak bermain di zona aman.", "Bocah dolanan ing zona aman.", "Putra dolanan wonten zona aman."],
            [1869, "Zona bahaya", "Zona bebaya", "Zona bebaya", "Keamanan", "Dilarang masuk zona bahaya.", "Aja mlebu zona bebaya.", "Sampun mlebet zona bebaya."],
            [1870, "Zona hijau", "Zona ijo", "Zona ijem", "Lingkungan", "Desa memiliki zona hijau.", "Desa nduweni zona ijo.", "Desa gadhah zona ijem."],
            [1871, "Vaksin", "Vaksin", "Vaksin", "Kesehatan", "Anak menerima vaksin.", "Bocah nampa vaksin.", "Putra nampi vaksin."],
            [1872, "Video", "Video", "Video", "Teknologi", "Guru memutar video pembelajaran.", "Guru muter video pasinaon.", "Guru muter video pasinaon."],
            [1873, "Vitamin", "Vitamin", "Vitamin", "Kesehatan", "Ibu membeli vitamin.", "Ibu tuku vitamin.", "Ibu mundhut vitamin."],
            [1874, "Volume", "Volume", "Volume", "Sains", "Guru menaikkan volume suara.", "Guru ngunggahake volume swara.", "Guru nginggilaken volume swanten."],
            [1875, "Voucher", "Voucher", "Voucher", "Teknologi", "Saya memakai voucher internet.", "Aku nganggo voucher internet.", "Kula ngagem voucher internet."],
        ];

        Schema::disableForeignKeyConstraints();
        VocabularyExample::truncate();
        Vocabulary::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($dataset as $row) {
            $vocab = Vocabulary::create([
                'id'              => $row[0],
                'indonesian_word' => $row[1],
                'javanese_ngoko'  => $row[2],
                'javanese_krama'  => $row[3],
                'category'        => $row[4] ?? null,
            ]);

            if (!empty($row[5]) || !empty($row[6]) || !empty($row[7])) {
                VocabularyExample::create([
                    'vocabulary_id'       => $vocab->id,
                    'indonesian_sentence' => $row[5] ?? null,
                    'ngoko_sentence'      => $row[6] ?? null,
                    'krama_sentence'      => $row[7] ?? null,
                    'javanese_sentence'   => $row[6] ?? $row[7] ?? null,
                ]);
            }
        }
    }
}
