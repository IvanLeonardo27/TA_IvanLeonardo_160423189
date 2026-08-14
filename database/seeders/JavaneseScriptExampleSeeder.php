<?php

namespace Database\Seeders;

use App\Models\JavaneseScriptDetail;
use App\Models\JavaneseScriptExample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JavaneseScriptExampleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('javanese_script_examples')->truncate();

        // 1. Aksara Nglegena (1 - 20)
        $examples = [
            // Ha
            'Ha' => [
                'script' => 'ꦲꦮꦤ꧀ꦲꦮꦤ꧀ꦥꦤꦱ꧀ꦔꦤ꧀ꦛꦁꦔꦤ꧀ꦛꦁ',
                'latin' => 'Awan-awan panas nganthang-nganthang.',
                'id' => 'Siang-siang panasnya terik sekali.'
            ],
            // Na
            'Na' => [
                'script' => 'ꦤꦺꦴꦩ꧀ꦤꦺꦴꦩꦤ꧀ꦏꦸꦢꦸꦱꦿꦼꦒꦼꦥ꧀ꦱꦶꦤꦻꦴ',
                'latin' => 'Nom-noman kudu sregep sinau.',
                'id' => 'Pemuda harus rajin belajar.'
            ],
            // Ca
            'Ca' => [
                'script' => 'ꦕꦫꦤꦺꦚꦩ꧀Yꦠ꧀ꦒꦮꦺꦏꦸꦢꦸꦠꦼꦤꦤ꧀',
                'latin' => 'Carane nyambut gawe kudu tenan.',
                'id' => 'Cara bekerjanya harus sungguh-sungguh.'
            ],
            // Ra
            'Ra' => [
                'script' => 'ꦫꦢꦺꦤ꧀ꦗꦤꦏꦱꦠꦿꦶꦪꦩꦢꦸꦏꦫ',
                'latin' => 'Raden Janaka satriya Madukara.',
                'id' => 'Raden Janaka adalah kesatria Madukara.'
            ],
            // Ka
            'Ka' => [
                'script' => 'ꦏꦧꦼꦕꦶꦏꦤ꧀ꦧꦏꦭ꧀ꦠꦶꦤꦼꦩꦸ',
                'latin' => 'Kabecikan bakal tinemu.',
                'id' => 'Kebaikan pasti akan berbuah manis.'
            ],
            // Da
            'Da' => [
                'script' => 'ꦢꦢꦶꦪꦮꦺꦴꦁꦱꦶꦁꦩꦶꦒꦸꦤꦤꦶ',
                'latin' => 'Dadiya wong sing migunani.',
                'id' => 'Jadilah orang yang bermanfaat.'
            ],
            // Ta
            'Ta' => [
                'script' => 'ꦠꦤ꧀ꦱꦃꦲꦺꦭꦶꦁꦩꦫꦁꦒꦸꦱ꧀ꦠꦶ',
                'latin' => 'Tansah eling marang Gusti.',
                'id' => 'Selalu ingat kepada Tuhan.'
            ],
            // Sa
            'Sa' => [
                'script' => 'ꦱꦶꦤꦻꦴꦧꦱꦗꦮꦏꦤ꧀ꦛꦶꦱꦼꦤꦼꦁ',
                'latin' => 'Sinau basa Jawa kanthi seneng.',
                'id' => 'Belajar bahasa Jawa dengan gembira.'
            ],
            // Wa
            'Wa' => [
                'script' => 'ꦮꦺꦴꦁꦲꦸꦫꦶꦥ꧀ꦏꦸꦢꦸꦠꦼꦤ꧀ꦠꦿꦼꦩ꧀',
                'latin' => 'Wong urip kudu tentrem.',
                'id' => 'Orang hidup harus damai tenteram.'
            ],
            // La
            'La' => [
                'script' => 'ꦭꦩ꧀ꦥꦃꦏꦸꦭꦠꦸꦩꦸꦗꦸꦲꦶꦁꦏꦱꦩ꧀ꦥꦸꦂꦤꦤ꧀',
                'latin' => 'Lampah kula tumuju ing kasampurnan.',
                'id' => 'Langkah saya menuju pada kesempurnaan.'
            ],
            // Pa
            'Pa' => [
                'script' => 'ꦥꦱꦂꦒꦼꦝꦺꦫꦩꦺꦧꦔꦼꦠ꧀',
                'latin' => 'Pasar gedhe rame banget.',
                'id' => 'Pasar besar sangat ramai.'
            ],
            // Dha
            'Dha' => [
                'script' => 'ꦝꦮꦸꦲꦶꦥꦸꦤ꧀ꦧꦥꦏ꧀ꦏꦸꦢꦸꦢꦶꦲꦺꦱ꧀ꦠꦺꦴꦏꦏꦺ',
                'latin' => 'Dhawuhipun bapak kudu diestokake.',
                'id' => 'Nasihat bapak harus ditaati.'
            ],
            // Ja
            'Ja' => [
                'script' => 'ꦗꦒꦤꦼꦏꦉꦱꦶꦏꦤ꧀ꦭꦶꦁꦏꦸꦔꦤ꧀',
                'latin' => 'Jaganen karesikan lingkungan.',
                'id' => 'Jagalah kebersihan lingkungan.'
            ],
            // Ya
            'Ya' => [
                'script' => 'ꦪꦪꦶꦏꦸꦭꦱꦩ꧀ꦥꦸꦤ꧀ꦱꦶꦤꦻꦴ',
                'latin' => 'Yayi kula sampun sinau.',
                'id' => 'Adik saya sudah belajar.'
            ],
            // Nya
            'Nya' => [
                'script' => 'ꦚꦩ꧀ꦧꦸꦠ꧀ꦒꦮꦺꦏꦤ꧀ꦛꦶꦱꦸꦩꦸꦫꦸꦥ꧀',
                'latin' => 'Nyambut gawe kanthi sumurup.',
                'id' => 'Bekerja dengan penuh kesadaran.'
            ],
            // Ma
            'Ma' => [
                'script' => 'ꦩꦔꦤ꧀ꦥꦔꦤꦤ꧀ꦱꦶꦁꦱꦺꦲꦠ꧀',
                'latin' => 'Mangan panganan sing sehat.',
                'id' => 'Makan makanan yang sehat.'
            ],
            // Ga
            'Ga' => [
                'script' => 'ꦒꦸꦫꦸꦲꦶꦏꦸꦥꦤꦸꦤ꧀ꦠꦸꦤ꧀ꦏꦧꦼꦕꦶꦏꦤ꧀',
                'latin' => 'Guru iku panuntun kabecikan.',
                'id' => 'Guru adalah penuntun kebaikan.'
            ],
            // Ba
            'Ba' => [
                'script' => 'ꦧꦥꦏ꧀ꦭꦶꦤ꧀ꦢꦶꦁꦠꦶꦤ꧀ꦢꦏ꧀ꦱꦧꦶꦤ꧀',
                'latin' => 'Bapak tindak wonten ing sabin.',
                'id' => 'Bapak pergi bekerja ke sawah.'
            ],
            // Tha
            'Tha' => [
                'script' => 'ꦛꦸꦏꦸꦭ꧀ꦮꦶꦠ꧀ꦥꦫꦶꦲꦶꦁꦱꦧꦶꦤ꧀',
                'latin' => 'Thukul wit pari ing sabin.',
                'id' => 'Tumbuh pohon padi di sawah.'
            ],
            // Nga
            'Nga' => [
                'script' => 'ꦔꦸꦂꦩꦠꦶꦠꦶꦪꦁꦱꦼꦥꦸꦃꦲꦶꦁꦱꦧꦼꦤ꧀ꦢꦶꦤ',
                'latin' => 'Ngurmati tiyang sepuh ing saben dina.',
                'id' => 'Menghormati orang tua setiap hari.'
            ],

            // Aksara Swara
            'A' => [
                'script' => 'ꦄꦤꦏ꧀ꦏꦸꦢꦸꦔꦸꦂꦩꦠꦶꦮꦺꦴꦁꦠꦸꦮ',
                'latin' => 'Anak kudu ngurmati wong tuwa.',
                'id' => 'Anak harus menghormati orang tua.'
            ],
            'I' => [
                'script' => 'ꦅꦧꦸꦩꦱꦏ꧀ꦲꦶꦁꦥꦮꦺꦴꦤ꧀',
                'latin' => 'Ibu masak wonten ing pawon.',
                'id' => 'Ibu memasak di dapur.'
            ],
            'U' => [
                'script' => 'ꦈꦢꦤ꧀ꦢꦼꦉꦱ꧀ꦮꦺꦴꦤ꧀ꦠꦼꦤ꧀ꦢꦺꦱ',
                'latin' => 'Udan deres wonten ing desa.',
                'id' => 'Hujan deras turun di desa.'
            ],
            'E' => [
                'script' => 'ꦌꦱꦸꦏ꧀ꦲꦺꦱꦸꦏ꧀ꦏꦸꦢꦸꦱꦼꦩꦔꦠ꧀',
                'latin' => 'Esuk-esuk kudu semangat.',
                'id' => 'Pagi-pagi harus bersemangat.'
            ],
            'O' => [
                'script' => 'ꦎꦩꦃꦏꦸꦭꦕꦼꦝꦏ꧀ꦱꦼꦏꦺꦴꦭꦃ',
                'latin' => 'Omah kula cedhak sekolah.',
                'id' => 'Rumah saya dekat dengan sekolah.'
            ],

            // Sandhangan
            'Wulu' => [
                'script' => 'ꦱꦶꦠꦶꦱꦶꦤꦻꦴꦱꦼꦱꦫꦼꦔꦤ꧀',
                'latin' => 'Siti sinau sesarengan.',
                'id' => 'Siti belajar bersama-sama.'
            ],
            'Suku' => [
                'script' => 'ꦧꦸꦏꦸꦲꦶꦏꦸꦏꦁꦒꦺꦴꦱꦶꦤꦻꦴ',
                'latin' => 'Buku iku kanggo sinau.',
                'id' => 'Buku itu digunakan untuk belajar.'
            ],
            'Pepet' => [
                'script' => 'ꦱꦼꦒꦼꦂꦲꦮꦤꦺꦲꦶꦁꦒꦸꦤꦸꦁ',
                'latin' => 'Seger hawane ing gunung.',
                'id' => 'Udara di gunung terasa sangat segar.'
            ],
            'Taling Tarung' => [
                'script' => 'ꦠꦺꦴꦏꦺꦴꦫꦺꦴꦠꦶꦧꦸꦏꦲꦺꦱꦸꦏ꧀',
                'latin' => 'Toko roti buka esuk.',
                'id' => 'Toko roti buka pada pagi hari.'
            ],
            'Taling' => [
                'script' => 'ꦭꦺꦭꦺꦒꦺꦴꦫꦺꦁꦫꦱꦤꦺꦲꦺꦤꦏ꧀',
                'latin' => 'Lele goreng rasane enak.',
                'id' => 'Ikan lele goreng rasanya lezat.'
            ],
            'Layar' => [
                'script' => 'ꦥꦱꦂꦒꦼꦝꦺꦏꦸꦛꦱꦭ',
                'latin' => 'Pasar gedhe kutha Sala.',
                'id' => 'Pasar besar di kota Solo.'
            ],
            'Wignyan' => [
                'script' => 'ꦱꦼꦱꦼꦥꦸꦃꦏꦸꦢꦸꦢꦶꦲꦸꦂꦩꦠꦶ',
                'latin' => 'Sesepuh kudu diurmati.',
                'id' => 'Para sesepuh harus dihormati.'
            ],
            'Cecak' => [
                'script' => 'ꦮꦪꦁꦏꦸꦭꦶꦠ꧀ꦏꦱꦼꦤꦼꦔꦤ꧀ꦏꦸ',
                'latin' => 'Wayang kulit kasenenganku.',
                'id' => 'Wayang kulit adalah kesukaanku.'
            ],
            'Pangkon' => [
                'script' => 'ꦱꦶꦤꦻꦴꦏꦤ꧀ꦛꦶꦱꦼꦠꦶꦠꦶꦱ꧀',
                'latin' => 'Sinau kanthi setitis.',
                'id' => 'Belajar dengan cermat dan teliti.'
            ],

            // Aksara Murda
            'Na Murda' => [
                'script' => 'ꦟꦒꦫꦶꦆꦤ꧀ꦢꦺꦴꦤꦺꦱꦶꦪꦏꦸꦛꦤꦺꦒꦼꦝꦺ',
                'latin' => 'Nagari Indonesia kutha-kuthane gedhe.',
                'id' => 'Negara Indonesia kota-kotanya besar.'
            ],
            'Ka Murda' => [
                'script' => 'ꦑꦸꦛꦱꦸꦫꦧꦪꦲꦱꦿꦶ',
                'latin' => 'Kutha Surabaya asri.',
                'id' => 'Kota Surabaya sangat asri.'
            ],

            // Aksara Rekan
            'Kha' => [
                'script' => 'ꦏ꦳ꦸꦠ꧀ꦧꦃꦗꦸꦩꦸꦮꦃꦲꦶꦁꦩꦱ꧀ꦗꦶꦢ꧀',
                'latin' => 'Khutbah Jumuwah ing masjid.',
                'id' => 'Khotbah Jumat di masjid.'
            ],
            'Fa' => [
                'script' => 'ꦥ꦳ꦗꦂꦱꦶꦢꦶꦏ꧀ꦮꦪꦃꦲꦺꦱꦸꦏ꧀',
                'latin' => 'Fajar sidik wayah esuk.',
                'id' => 'Fajar menyingsing di waktu pagi.'
            ],
            'Za' => [
                'script' => 'ꦗ꦳ꦏꦠ꧀ꦥ꦳ꦶꦠꦿꦃꦏꦸꦢꦸꦢꦶꦠꦺꦴꦏꦏꦺ',
                'latin' => 'Zakat fitrah kudu ditokake.',
                'id' => 'Zakat fitrah harus ditunaikan.'
            ],

            // Angka Jawa
            'Angka 1' => [
                'script' => '꧋ꦠꦲꦸꦤ꧀꧇꧒꧐꧒꧔꧇ꦱꦶꦤꦻꦴꦧꦱꦗꦮ꧉',
                'latin' => 'Tahun 2024 sinau basa Jawa.',
                'id' => 'Tahun 2024 belajar bahasa Jawa.'
            ]
        ];

        // Masukkan contoh untuk setiap script detail
        $allDetails = JavaneseScriptDetail::all();
        foreach ($allDetails as $detail) {
            $name = $detail->name;
            if (isset($examples[$name])) {
                $ex = $examples[$name];
                JavaneseScriptExample::create([
                    'script_detail_id' => $detail->id,
                    'javanese_script_text' => $ex['script'],
                    'javanese_latin_text' => $ex['latin'],
                    'indonesian_text' => $ex['id'],
                ]);
            } else {
                // Fallback contoh otomatis yang valid dan edukatif
                JavaneseScriptExample::create([
                    'script_detail_id' => $detail->id,
                    'javanese_script_text' => 'ꦱꦶꦤꦻꦴꦲꦏ꧀ꦱꦫꦗꦮꦲꦶꦏꦸꦒꦩ꧀ꦥꦁ',
                    'javanese_latin_text' => 'Sinau aksara Jawa ' . $detail->name . ' kanthi gampang lan becik.',
                    'indonesian_text' => 'Mempelajari aksara Jawa ' . $detail->name . ' dengan mudah dan baik.',
                ]);
            }
        }
    }
}
