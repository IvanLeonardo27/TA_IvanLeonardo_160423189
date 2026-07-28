<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use Illuminate\Database\Seeder;

class VocabularySeeder extends Seeder
{
    public function run(): void
    {
        $vocabularies = [
            // A
            [
                'indonesian_word' => 'Ada',
                'javanese_ngoko' => 'Ana',
                'javanese_krama' => 'Wonten',
                'example_indonesian' => 'Ada banyak buku di perpustakaan.',
                'example_ngoko' => 'Ana akeh buku ing perpustakaan.',
                'example_krama' => 'Wonten kathah buku ing perpustakaan.',
            ],
            [
                'indonesian_word' => 'Air',
                'javanese_ngoko' => 'Banyu',
                'javanese_krama' => 'Toya / Warih',
                'example_indonesian' => 'Ibu memasak air di dapur.',
                'example_ngoko' => 'Ibu masak banyu ing pawon.',
                'example_krama' => 'Ibu ngolah toya ing pawon.',
            ],
            [
                'indonesian_word' => 'Aku / Saya',
                'javanese_ngoko' => 'Aku',
                'javanese_krama' => 'Kula',
                'example_indonesian' => 'Saya membaca buku cerita.',
                'example_ngoko' => 'Aku moco buku cerita.',
                'example_krama' => 'Kula maos buku cerita.',
            ],
            [
                'indonesian_word' => 'Alas',
                'javanese_ngoko' => 'Lemek',
                'javanese_krama' => 'Lemek',
                'example_indonesian' => 'Duduk menggunakan alas tikar.',
                'example_ngoko' => 'Lungguh nganggo lemek klasa.',
                'example_krama' => 'Lungguh nggelemek klasa.',
            ],
            [
                'indonesian_word' => 'Anak',
                'javanese_ngoko' => 'Bocah / Anak',
                'javanese_krama' => 'Lare',
                'example_indonesian' => 'Anak itu rajin belajar.',
                'example_ngoko' => 'Bocah kuwi sregep sinau.',
                'example_krama' => 'Lare punika sregep sinau.',
            ],
            [
                'indonesian_word' => 'Angin',
                'javanese_ngoko' => 'Angin',
                'javanese_krama' => 'Angin / Samirana',
                'example_indonesian' => 'Angin bertiup kencang sore ini.',
                'example_ngoko' => 'Angin sumilir banter sore iki.',
                'example_krama' => 'Angin sumilir banter sonten punika.',
            ],
            [
                'indonesian_word' => 'Apa',
                'javanese_ngoko' => 'Apa',
                'javanese_krama' => 'Menapa / Punapa',
                'example_indonesian' => 'Apa yang sedang kamu kerjakan?',
                'example_ngoko' => 'Apa sing lagi kokgarap?',
                'example_krama' => 'Menapa ingkang nembe sampeyan garap?',
            ],

            // B
            [
                'indonesian_word' => 'Bagaimana',
                'javanese_ngoko' => 'Piye / Kepiye',
                'javanese_krama' => 'Pundi / Kados pundi',
                'example_indonesian' => 'Bagaimana kabarmu hari ini?',
                'example_ngoko' => 'Piye kabarmu dina iki?',
                'example_krama' => 'Kados pundi kabariyan sampeyan dinten punika?',
            ],
            [
                'indonesian_word' => 'Baju',
                'javanese_ngoko' => 'Klambi',
                'javanese_krama' => 'Rasukan / Ageman',
                'example_indonesian' => 'Budi memakai baju baru.',
                'example_ngoko' => 'Budi nganggo klambi anyar.',
                'example_krama' => 'Budi ngagem rasukan anyar.',
            ],
            [
                'indonesian_word' => 'Banyak',
                'javanese_ngoko' => 'Akeh',
                'javanese_krama' => 'Kathah',
                'example_indonesian' => 'Banyak buah di pasar tradisional.',
                'example_ngoko' => 'Akeh woh-wohan ing pasar tradisional.',
                'example_krama' => 'Kathah woh-wohan ing peken tradisional.',
            ],
            [
                'indonesian_word' => 'Bapak / Ayah',
                'javanese_ngoko' => 'Bapak',
                'javanese_krama' => 'Bapak / Rama',
                'example_indonesian' => 'Bapak pergi ke kantor naik sepeda.',
                'example_ngoko' => 'Bapak tindak kantor numpak pit.',
                'example_krama' => 'Bapak tindak kantor nitih pit.',
            ],
            [
                'indonesian_word' => 'Batu',
                'javanese_ngoko' => 'Watu',
                'javanese_krama' => 'Sela',
                'example_indonesian' => 'Adik melempar batu kecil.',
                'example_ngoko' => 'Adhik mbalang watu cilik.',
                'example_krama' => 'Adhi nglempang sela alit.',
            ],
            [
                'indonesian_word' => 'Belajar',
                'javanese_ngoko' => 'Sinau',
                'javanese_krama' => 'Sinau / Nggulawentah',
                'example_indonesian' => 'Kami belajar matematika bersama.',
                'example_ngoko' => 'Aweke dhewe sinau matematika bareng.',
                'example_krama' => 'Kula sedaya sinau matematika sesarengan.',
            ],
            [
                'indonesian_word' => 'Besar',
                'javanese_ngoko' => 'Gedhe',
                'javanese_krama' => 'Ageng',
                'example_indonesian' => 'Rumah baru itu sangat besar.',
                'example_ngoko' => 'Omah anyar kuwi gedhe banget.',
                'example_krama' => 'Griya anyar punika ageng sanget.',
            ],
            [
                'indonesian_word' => 'Bisa',
                'javanese_ngoko' => 'Bisa',
                'javanese_krama' => 'Saged',
                'example_indonesian' => 'Saya bisa menulis aksara Jawa.',
                'example_ngoko' => 'Aku bisa nulis aksara Jawa.',
                'example_krama' => 'Kula saged nulis aksara Jawa.',
            ],
            [
                'indonesian_word' => 'Buku',
                'javanese_ngoko' => 'Buku',
                'javanese_krama' => 'Buku',
                'example_indonesian' => 'Siswa membaca buku pelajaran.',
                'example_ngoko' => 'Murid moco buku pelajaran.',
                'example_krama' => 'Murid maos buku pelajaran.',
            ],

            // C
            [
                'indonesian_word' => 'Cepat',
                'javanese_ngoko' => 'Cepat / Banter',
                'javanese_krama' => 'Cepat / Enggal',
                'example_indonesian' => 'Berlari dengan sangat cepat.',
                'example_ngoko' => 'Lari kanti banter banget.',
                'example_krama' => 'Mlayu kanthi enggal sanget.',
            ],
            [
                'indonesian_word' => 'Cucu',
                'javanese_ngoko' => 'Putu',
                'javanese_krama' => 'Wayah',
                'example_indonesian' => 'Kakek menyayangi semua cucunya.',
                'example_ngoko' => 'Simbah tresna marang kabeh putune.',
                'example_krama' => 'Simbah tresna dhumateng sedaya wayahipun.',
            ],

            // D
            [
                'indonesian_word' => 'Daftar / Nama',
                'javanese_ngoko' => 'Aran / Jeneng',
                'javanese_krama' => 'Asma / Nama',
                'example_indonesian' => 'Siapa namamu?',
                'example_ngoko' => 'Sapa jenengmu?',
                'example_krama' => 'Sintun asma sampeyan?',
            ],
            [
                'indonesian_word' => 'Datang',
                'javanese_ngoko' => 'Tekan / Teka',
                'javanese_krama' => 'Dugi / Rawuh',
                'example_indonesian' => 'Guru datang ke sekolah tepat waktu.',
                'example_ngoko' => 'Pak Guru teka ing sekolah tepat wektu.',
                'example_krama' => 'Pak Guru rawuh ing sekolah tepat wektu.',
            ],
            [
                'indonesian_word' => 'Daun',
                'javanese_ngoko' => 'Godhong',
                'javanese_krama' => 'Godhong / Ulam',
                'example_indonesian' => 'Daun pisang berwarna hijau.',
                'example_ngoko' => 'Godhong gedhang warnane hijau.',
                'example_krama' => 'Godhong pisang warninipun hijau.',
            ],
            [
                'indonesian_word' => 'Dengar',
                'javanese_ngoko' => 'Rungu / Krungu',
                'javanese_krama' => 'Mireng / Midhanget',
                'example_indonesian' => 'Saya mendengar suara musik.',
                'example_ngoko' => 'Aku krungu suara musik.',
                'example_krama' => 'Kula mireng suara musik.',
            ],
            [
                'indonesian_word' => 'Duduk',
                'javanese_ngoko' => 'Lungguh',
                'javanese_krama' => 'Lenggah / Pungguh',
                'example_indonesian' => 'Silakan duduk di kursi depan.',
                'example_ngoko' => 'Monggo lungguh ing kursi ngarep.',
                'example_krama' => 'Manggadh Lenggah ing kursi ngajeng.',
            ],

            // I
            [
                'indonesian_word' => 'Ibu',
                'javanese_ngoko' => 'Ibu / Mbok',
                'javanese_krama' => 'Ibu / Ibu',
                'example_indonesian' => 'Ibu membuat kue lezat.',
                'example_ngoko' => 'Ibu gae roti enak.',
                'example_krama' => 'Ibu damel roti eca.',
            ],
            [
                'indonesian_word' => 'Ingin / Mau',
                'javanese_ngoko' => 'Gelem / Pengin',
                'javanese_krama' => 'Kersa / Suka',
                'example_indonesian' => 'Saya ingin membeli buku baru.',
                'example_ngoko' => 'Aku pengin tuku buku anyar.',
                'example_krama' => 'Kula kersa tumbas buku anyar.',
            ],

            // J
            [
                'indonesian_word' => 'Jalan',
                'javanese_ngoko' => 'Dalan',
                'javanese_krama' => 'Margi',
                'example_indonesian' => 'Jalan ini sangat bersih.',
                'example_ngoko' => 'Dalan iki resik banget.',
                'example_krama' => 'Margi punika resik sanget.',
            ],

            // K
            [
                'indonesian_word' => 'Kaki',
                'javanese_ngoko' => 'Sikil',
                'javanese_krama' => 'Apeyan / Sampeyan',
                'example_indonesian' => 'Kaki saya sakit setelah berjalan.',
                'example_ngoko' => 'Sikilku lara bar mlaku.',
                'example_krama' => 'Sampeyan kula sakit sasampunipun mlampah.',
            ],
            [
                'indonesian_word' => 'Makan',
                'javanese_ngoko' => 'Mangan',
                'javanese_krama' => 'Dhahar / Nedha',
                'example_indonesian' => 'Saya sedang makan nasi goreng.',
                'example_ngoko' => 'Aku lagi mangan sega goreng.',
                'example_krama' => 'Kula nembe dhahar sekul goreng.',
            ],
            [
                'indonesian_word' => 'Minum',
                'javanese_ngoko' => 'Ngombe',
                'javanese_krama' => 'Ngunjuk',
                'example_indonesian' => 'Adik minum air putih.',
                'example_ngoko' => 'Adhik ngombe banyu putih.',
                'example_krama' => 'Adhi ngunjuk toya putih.',
            ],
            [
                'indonesian_word' => 'Rumah',
                'javanese_ngoko' => 'Omah',
                'javanese_krama' => 'Griya / Dalem',
                'example_indonesian' => 'Rumah saya di dekat sekolah.',
                'example_ngoko' => 'Omahku ing cedhak sekolah.',
                'example_krama' => 'Griya kula ing celak sekolah.',
            ],
            [
                'indonesian_word' => 'Tidur',
                'javanese_ngoko' => 'Turu',
                'javanese_krama' => 'Tilem / Sare',
                'example_indonesian' => 'Ayah sedang tidur di kamar.',
                'example_ngoko' => 'Bapak lagi turu ing kamar.',
                'example_krama' => 'Bapak nembe sare ing kamar.',
            ]
        ];

        foreach ($vocabularies as $vocab) {
            Vocabulary::updateOrCreate(
                ['indonesian_word' => $vocab['indonesian_word']],
                $vocab
            );
        }
    }
}
