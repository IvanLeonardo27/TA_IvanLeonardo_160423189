<?php

namespace Database\Seeders;

use App\Models\JavaneseScriptCategory;
use App\Models\JavaneseScriptDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JavaneseScriptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('javanese_script_details')->truncate();
        DB::table('javanese_script_categories')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Master Categories
        $categories = [
            [
                'id' => 1,
                'name' => 'Aksara Nglegena',
                'description' => 'Aksara dhasar ing panulisan Jawa gunggunge ana 20 aksara (carakan) sing durung kawuwuhan sandhangan.',
            ],
            [
                'id' => 2,
                'name' => 'Aksara Swara',
                'description' => 'Aksara vokal mandhiri (A, I, U, E, O) ing panulisan basa Jawa kanggo nulisake swara vokal ing wiwitan tembung.',
            ],
            [
                'id' => 3,
                'name' => 'Sandhangan',
                'description' => 'Tandha diakritik kanggo ngowahi swara vokal utawa nambah pungkasan swara konsonan.',
            ],
            [
                'id' => 4,
                'name' => 'Pasangan',
                'description' => 'Wujud pasangan saka aksara nglegena kanggo mateni aksara konsonan sadurunge.',
            ],
            [
                'id' => 5,
                'name' => 'Aksara Murda',
                'description' => 'Aksara khusus sing digunakake kanggo nulis jeneng pakurmatan, gelar, utawa kutha (kaya huruf kapital).',
            ],
            [
                'id' => 6,
                'name' => 'Pasangan Aksara Murda',
                'description' => 'Wujud pasangan saka aksara murda kanggo mateni aksara konsonan sadurunge aksara murda.',
            ],
            [
                'id' => 7,
                'name' => 'Aksara Rekan',
                'description' => 'Aksara sing direka kanggo nulisake tembung-tembung serapan manca (khususe basa Arab).',
            ],
            [
                'id' => 8,
                'name' => 'Pasangan Aksara Rekan',
                'description' => 'Wujud pasangan saka aksara rekan kanggo mateni aksara konsonan sadurunge aksara rekan.',
            ],
            [
                'id' => 9,
                'name' => 'Angka Jawa',
                'description' => 'Wilangan utawa simbol angka ing aksara Jawa (angka 0 tekan 9).',
            ],
        ];

        foreach ($categories as $cat) {
            JavaneseScriptCategory::create($cat);
        }

        // 2. 20 Aksara Nglegena (Carakan) Details
        $nglegenaList = [
            ['name' => 'Ha',  'latin' => 'Ha',  'pronunciation' => 'ha',  'image' => 'aksara-jawa/nglegena/ha.svg',  'desc' => 'Aksara Ha minangka aksara kapisan ing carakan Jawa.'],
            ['name' => 'Na',  'latin' => 'Na',  'pronunciation' => 'na',  'image' => 'aksara-jawa/nglegena/na.svg',  'desc' => 'Aksara Na minangka aksara kapindho ing carakan Jawa.'],
            ['name' => 'Ca',  'latin' => 'Ca',  'pronunciation' => 'ca',  'image' => 'aksara-jawa/nglegena/ca.svg',  'desc' => 'Aksara Ca minangka aksara katelu ing carakan Jawa.'],
            ['name' => 'Ra',  'latin' => 'Ra',  'pronunciation' => 'ra',  'image' => 'aksara-jawa/nglegena/ra.svg',  'desc' => 'Aksara Ra minangka aksara kapapat ing carakan Jawa.'],
            ['name' => 'Ka',  'latin' => 'Ka',  'pronunciation' => 'ka',  'image' => 'aksara-jawa/nglegena/ka.svg',  'desc' => 'Aksara Ka minangka aksara kalima ing carakan Jawa.'],
            ['name' => 'Da',  'latin' => 'Da',  'pronunciation' => 'da',  'image' => 'aksara-jawa/nglegena/da.svg',  'desc' => 'Aksara Da minangka aksara kanem ing carakan Jawa.'],
            ['name' => 'Ta',  'latin' => 'Ta',  'pronunciation' => 'ta',  'image' => 'aksara-jawa/nglegena/ta.svg',  'desc' => 'Aksara Ta minangka aksara kapitu ing carakan Jawa.'],
            ['name' => 'Sa',  'latin' => 'Sa',  'pronunciation' => 'sa',  'image' => 'aksara-jawa/nglegena/sa.svg',  'desc' => 'Aksara Sa minangka aksara kawolu ing carakan Jawa.'],
            ['name' => 'Wa',  'latin' => 'Wa',  'pronunciation' => 'wa',  'image' => 'aksara-jawa/nglegena/wa.svg',  'desc' => 'Aksara Wa minangka aksara kasanga ing carakan Jawa.'],
            ['name' => 'La',  'latin' => 'La',  'pronunciation' => 'la',  'image' => 'aksara-jawa/nglegena/la.svg',  'desc' => 'Aksara La minangka aksara kasepuluh ing carakan Jawa.'],
            ['name' => 'Pa',  'latin' => 'Pa',  'pronunciation' => 'pa',  'image' => 'aksara-jawa/nglegena/pa.svg',  'desc' => 'Aksara Pa minangka aksara sawelas ing carakan Jawa.'],
            ['name' => 'Dha', 'latin' => 'Dha', 'pronunciation' => 'dha', 'image' => 'aksara-jawa/nglegena/dha.svg', 'desc' => 'Aksara Dha (d kandel) minangka aksara rolas ing carakan Jawa.'],
            ['name' => 'Ja',  'latin' => 'Ja',  'pronunciation' => 'ja',  'image' => 'aksara-jawa/nglegena/ja.svg',  'desc' => 'Aksara Ja minangka aksara telulas ing carakan Jawa.'],
            ['name' => 'Ya',  'latin' => 'Ya',  'pronunciation' => 'ya',  'image' => 'aksara-jawa/nglegena/ya.svg',  'desc' => 'Aksara Ya minangka aksara patbelas ing carakan Jawa.'],
            ['name' => 'Nya', 'latin' => 'Nya', 'pronunciation' => 'nya', 'image' => 'aksara-jawa/nglegena/nya.svg', 'desc' => 'Aksara Nya minangka aksara limalas ing carakan Jawa.'],
            ['name' => 'Ma',  'latin' => 'Ma',  'pronunciation' => 'ma',  'image' => 'aksara-jawa/nglegena/ma.svg',  'desc' => 'Aksara Ma minangka aksara nembelas ing carakan Jawa.'],
            ['name' => 'Ga',  'latin' => 'Ga',  'pronunciation' => 'ga',  'image' => 'aksara-jawa/nglegena/ga.svg',  'desc' => 'Aksara Ga minangka aksara pitulas ing carakan Jawa.'],
            ['name' => 'Ba',  'latin' => 'Ba',  'pronunciation' => 'ba',  'image' => 'aksara-jawa/nglegena/ba.svg',  'desc' => 'Aksara Ba minangka aksara wolulas ing carakan Jawa.'],
            ['name' => 'Tha', 'latin' => 'Tha', 'pronunciation' => 'tha', 'image' => 'aksara-jawa/nglegena/tha.svg', 'desc' => 'Aksara Tha (t kandel) minangka aksara sangalas ing carakan Jawa.'],
            ['name' => 'Nga', 'latin' => 'Nga', 'pronunciation' => 'nga', 'image' => 'aksara-jawa/nglegena/nga.svg', 'desc' => 'Aksara Nga minangka aksara rongpuluh ing carakan Jawa.'],
        ];

        foreach ($nglegenaList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 1,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 3. 5 Aksara Swara (A, I, U, E, O)
        $swaraList = [
            ['name' => 'A', 'latin' => 'A', 'pronunciation' => 'a', 'image' => 'aksara-jawa/swara/a.svg', 'desc' => 'Aksara Swara A minangka aksara swara dhasar kanggo vokal A ing wiwitan tembung.'],
            ['name' => 'I', 'latin' => 'I', 'pronunciation' => 'i', 'image' => 'aksara-jawa/swara/i.svg', 'desc' => 'Aksara Swara I minangka aksara swara dhasar kanggo vokal I ing wiwitan tembung.'],
            ['name' => 'U', 'latin' => 'U', 'pronunciation' => 'u', 'image' => 'aksara-jawa/swara/u.svg', 'desc' => 'Aksara Swara U minangka aksara swara dhasar kanggo vokal U ing wiwitan tembung.'],
            ['name' => 'E', 'latin' => 'E', 'pronunciation' => 'e', 'image' => 'aksara-jawa/swara/e.svg', 'desc' => 'Aksara Swara E minangka aksara swara dhasar kanggo vokal E ing wiwitan tembung.'],
            ['name' => 'O', 'latin' => 'O', 'pronunciation' => 'o', 'image' => 'aksara-jawa/swara/o.svg', 'desc' => 'Aksara Swara O minangka aksara swara dhasar kanggo vokal O ing wiwitan tembung.'],
        ];

        foreach ($swaraList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 2,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 4. 16 Sandhangan (Swara, Panyigeg, Wyanjana & Tandha Wacan)
        $sandhanganList = [
            ['name' => 'Wulu',          'latin' => 'i',             'pronunciation' => 'i',          'image' => 'aksara-jawa/sandhangan/wulu.svg',          'desc' => 'Sandhangan Swara Wulu kanggo ngowahi swara dadi /i/.'],
            ['name' => 'Suku',          'latin' => 'u',             'pronunciation' => 'u',          'image' => 'aksara-jawa/sandhangan/suku.svg',          'desc' => 'Sandhangan Swara Suku kanggo ngowahi swara dadi /u/.'],
            ['name' => 'Pepet',         'latin' => 'e (pepet)',     'pronunciation' => 'e',          'image' => 'aksara-jawa/sandhangan/pepet.svg',         'desc' => 'Sandhangan Swara Pepet kanggo ngowahi swara dadi /ê/.'],
            ['name' => 'Taling Tarung', 'latin' => 'o',             'pronunciation' => 'o',          'image' => 'aksara-jawa/sandhangan/taling-tarung.svg', 'desc' => 'Sandhangan Swara Taling Tarung kanggo ngowahi swara dadi /o/.'],
            ['name' => 'Taling',        'latin' => 'e (taling)',    'pronunciation' => 'e',          'image' => 'aksara-jawa/sandhangan/taling.svg',        'desc' => 'Sandhangan Swara Taling kanggo ngowahi swara dadi /é/.'],
            ['name' => 'Layar',         'latin' => '_r',            'pronunciation' => 'er',         'image' => 'aksara-jawa/sandhangan/layar.svg',         'desc' => 'Sandhangan Panyigeg Layar kanggo nambah swara konsonan mati /r/ ing pungkasan wanda.'],
            ['name' => 'Wignyan',       'latin' => '_h',            'pronunciation' => 'hah',        'image' => 'aksara-jawa/sandhangan/wignyan.svg',       'desc' => 'Sandhangan Panyigeg Wignyan kanggo nambah swara konsonan mati /h/ ing pungkasan wanda.'],
            ['name' => 'Cecak',         'latin' => '_ng',           'pronunciation' => 'eng',        'image' => 'aksara-jawa/sandhangan/cecak.svg',         'desc' => 'Sandhangan Panyigeg Cecak kanggo nambah swara konsonan mati /ng/ ing pungkasan wanda.'],
            ['name' => 'Pangkon',       'latin' => 'paten',         'pronunciation' => 'pangkon',    'image' => 'aksara-jawa/sandhangan/pangkon.svg',       'desc' => 'Sandhangan Pangkon (Paten) kanggo mateni swara aksara konsonan ing pungkasan ukara.'],
            ['name' => 'Pengkal',       'latin' => '_ya',           'pronunciation' => 'ya',         'image' => 'aksara-jawa/sandhangan/pengkal.svg',       'desc' => 'Sandhangan Wyanjana Pengkal kanggo nyisipake swara /ya/ ing tengah wanda.'],
            ['name' => 'Cakra',         'latin' => '_ra',           'pronunciation' => 'ra',         'image' => 'aksara-jawa/sandhangan/cakra.svg',         'desc' => 'Sandhangan Wyanjana Cakra kanggo nyisipake swara /ra/ ing tengah wanda.'],
            ['name' => 'Cakra Keret',   'latin' => '_re',           'pronunciation' => 're',         'image' => 'aksara-jawa/sandhangan/cakra-keret.svg',   'desc' => 'Sandhangan Wyanjana Cakra Keret kanggo nyisipake swara /rê/ ing tengah wanda.'],
            ['name' => 'Pada Adeg-adeg','latin' => 'awal kalimat',  'pronunciation' => 'adeg adeg',  'image' => 'aksara-jawa/sandhangan/pada-adeg-adeg.svg','desc' => 'Tandha Wacan Pada Adeg-adeg kanggo mratandhani wiwitaning ukara utawa alinea.'],
            ['name' => 'Pada Lungsi',   'latin' => 'titik',         'pronunciation' => 'titik',      'image' => 'aksara-jawa/sandhangan/pada-lungsi.svg',   'desc' => 'Tandha Wacan Pada Lungsi minangka tandha pungkasaning ukara (titik).'],
            ['name' => 'Pada Lingsa',   'latin' => 'koma',          'pronunciation' => 'koma',       'image' => 'aksara-jawa/sandhangan/pada-lingsa.svg',   'desc' => 'Tandha Wacan Pada Lingsa minangka tandha panyela (koma).'],
            ['name' => 'Pada Pangkat',  'latin' => 'pengapit angka','pronunciation' => 'pangkat',    'image' => 'aksara-jawa/sandhangan/pada-pangkat.svg',  'desc' => 'Tandha Wacan Pada Pangkat kanggo ngapit angka Jawa utawa tembung pethikan.'],
        ];

        foreach ($sandhanganList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 3,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 5. 20 Pasangan Aksara Jawa
        $pasanganList = [
            ['name' => 'Pasangan Ha',  'latin' => '-ha',  'pronunciation' => 'ha',  'image' => 'aksara-jawa/pasangan/pasangan-ha.svg',  'desc' => 'Pasangan Ha digunakake kanggo nyambung aksara Ha sawise aksara mati.'],
            ['name' => 'Pasangan Na',  'latin' => '-na',  'pronunciation' => 'na',  'image' => 'aksara-jawa/pasangan/pasangan-na.svg',  'desc' => 'Pasangan Na manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ca',  'latin' => '-ca',  'pronunciation' => 'ca',  'image' => 'aksara-jawa/pasangan/pasangan-ca.svg',  'desc' => 'Pasangan Ca manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ra',  'latin' => '-ra',  'pronunciation' => 'ra',  'image' => 'aksara-jawa/pasangan/pasangan-ra.svg',  'desc' => 'Pasangan Ra manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ka',  'latin' => '-ka',  'pronunciation' => 'ka',  'image' => 'aksara-jawa/pasangan/pasangan-ka.svg',  'desc' => 'Pasangan Ka manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Da',  'latin' => '-da',  'pronunciation' => 'da',  'image' => 'aksara-jawa/pasangan/pasangan-da.svg',  'desc' => 'Pasangan Da manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ta',  'latin' => '-ta',  'pronunciation' => 'ta',  'image' => 'aksara-jawa/pasangan/pasangan-ta.svg',  'desc' => 'Pasangan Ta manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Sa',  'latin' => '-sa',  'pronunciation' => 'sa',  'image' => 'aksara-jawa/pasangan/pasangan-sa.svg',  'desc' => 'Pasangan Sa manggon ana ing jejere aksara mati.'],
            ['name' => 'Pasangan Wa',  'latin' => '-wa',  'pronunciation' => 'wa',  'image' => 'aksara-jawa/pasangan/pasangan-wa.svg',  'desc' => 'Pasangan Wa manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan La',  'latin' => '-la',  'pronunciation' => 'la',  'image' => 'aksara-jawa/pasangan/pasangan-la.svg',  'desc' => 'Pasangan La manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Pa',  'latin' => '-pa',  'pronunciation' => 'pa',  'image' => 'aksara-jawa/pasangan/pasangan-pa.svg',  'desc' => 'Pasangan Pa manggon ana ing jejere aksara mati.'],
            ['name' => 'Pasangan Dha', 'latin' => '-dha', 'pronunciation' => 'dha', 'image' => 'aksara-jawa/pasangan/pasangan-dha.svg', 'desc' => 'Pasangan Dha manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ja',  'latin' => '-ja',  'pronunciation' => 'ja',  'image' => 'aksara-jawa/pasangan/pasangan-ja.svg',  'desc' => 'Pasangan Ja manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ya',  'latin' => '-ya',  'pronunciation' => 'ya',  'image' => 'aksara-jawa/pasangan/pasangan-ya.svg',  'desc' => 'Pasangan Ya manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Nya', 'latin' => '-nya', 'pronunciation' => 'nya', 'image' => 'aksara-jawa/pasangan/pasangan-nya.svg', 'desc' => 'Pasangan Nya manggon nggantung ing garis dhasar aksara mati.'],
            ['name' => 'Pasangan Ma',  'latin' => '-ma',  'pronunciation' => 'ma',  'image' => 'aksara-jawa/pasangan/pasangan-ma.svg',  'desc' => 'Pasangan Ma manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ga',  'latin' => '-ga',  'pronunciation' => 'ga',  'image' => 'aksara-jawa/pasangan/pasangan-ga.svg',  'desc' => 'Pasangan Ga manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ba',  'latin' => '-ba',  'pronunciation' => 'ba',  'image' => 'aksara-jawa/pasangan/pasangan-ba.svg',  'desc' => 'Pasangan Ba manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Tha', 'latin' => '-tha', 'pronunciation' => 'tha', 'image' => 'aksara-jawa/pasangan/pasangan-tha.svg', 'desc' => 'Pasangan Tha manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Nga', 'latin' => '-nga', 'pronunciation' => 'nga', 'image' => 'aksara-jawa/pasangan/pasangan-nga.svg', 'desc' => 'Pasangan Nga manggon ana ing ngisor aksara mati.'],
        ];

        foreach ($pasanganList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 4,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 6. 7 Aksara Murda
        $murdaList = [
            ['name' => 'Na Murda', 'latin' => 'Na (Murda)', 'pronunciation' => 'na', 'image' => 'aksara-jawa/murda/na.svg', 'desc' => 'Aksara Murda Na digunakake minangka huruf kapital kanggo nulis jeneng pakurmatan.'],
            ['name' => 'Ka Murda', 'latin' => 'Ka (Murda)', 'pronunciation' => 'ka', 'image' => 'aksara-jawa/murda/ka.svg', 'desc' => 'Aksara Murda Ka digunakake minangka huruf kapital kanggo nulis jeneng pakurmatan.'],
            ['name' => 'Ta Murda', 'latin' => 'Ta (Murda)', 'pronunciation' => 'ta', 'image' => 'aksara-jawa/murda/ta.svg', 'desc' => 'Aksara Murda Ta digunakake minangka huruf kapital ing tata panulisan aksara Jawa.'],
            ['name' => 'Sa Murda', 'latin' => 'Sa (Murda)', 'pronunciation' => 'sa', 'image' => 'aksara-jawa/murda/sa.svg', 'desc' => 'Aksara Murda Sa digunakake minangka huruf kapital ing tata panulisan aksara Jawa.'],
            ['name' => 'Pa Murda', 'latin' => 'Pa (Murda)', 'pronunciation' => 'pa', 'image' => 'aksara-jawa/murda/pa.svg', 'desc' => 'Aksara Murda Pa digunakake minangka huruf kapital ing tata panulisan aksara Jawa.'],
            ['name' => 'Ga Murda', 'latin' => 'Ga (Murda)', 'pronunciation' => 'ga', 'image' => 'aksara-jawa/murda/ga.svg', 'desc' => 'Aksara Murda Ga digunakake minangka huruf kapital ing tata panulisan aksara Jawa.'],
            ['name' => 'Ba Murda', 'latin' => 'Ba (Murda)', 'pronunciation' => 'ba', 'image' => 'aksara-jawa/murda/ba.svg', 'desc' => 'Aksara Murda Ba digunakake minangka huruf kapital ing tata panulisan aksara Jawa.'],
        ];

        foreach ($murdaList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 5,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 7. 7 Pasangan Aksara Murda
        $pasanganMurdaList = [
            ['name' => 'Pasangan Na Murda', 'latin' => '-na (Murda)', 'pronunciation' => 'na', 'image' => 'aksara-jawa/pasangan-murda/pasangan-na.svg', 'desc' => 'Pasangan Aksara Murda Na manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ka Murda', 'latin' => '-ka (Murda)', 'pronunciation' => 'ka', 'image' => 'aksara-jawa/pasangan-murda/pasangan-ka.svg', 'desc' => 'Pasangan Aksara Murda Ka manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ta Murda', 'latin' => '-ta (Murda)', 'pronunciation' => 'ta', 'image' => 'aksara-jawa/pasangan-murda/pasangan-ta.svg', 'desc' => 'Pasangan Aksara Murda Ta manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Sa Murda', 'latin' => '-sa (Murda)', 'pronunciation' => 'sa', 'image' => 'aksara-jawa/pasangan-murda/pasangan-sa.svg', 'desc' => 'Pasangan Aksara Murda Sa manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Pa Murda', 'latin' => '-pa (Murda)', 'pronunciation' => 'pa', 'image' => 'aksara-jawa/pasangan-murda/pasangan-pa.svg', 'desc' => 'Pasangan Aksara Murda Pa manggon ana ing jejere aksara mati.'],
            ['name' => 'Pasangan Ga Murda', 'latin' => '-ga (Murda)', 'pronunciation' => 'ga', 'image' => 'aksara-jawa/pasangan-murda/pasangan-ga.svg', 'desc' => 'Pasangan Aksara Murda Ga manggon ana ing ngisor aksara mati.'],
            ['name' => 'Pasangan Ba Murda', 'latin' => '-ba (Murda)', 'pronunciation' => 'ba', 'image' => 'aksara-jawa/pasangan-murda/pasangan-ba.svg', 'desc' => 'Pasangan Aksara Murda Ba manggon ana ing ngisor aksara mati.'],
        ];

        foreach ($pasanganMurdaList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 6,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 8. 5 Aksara Rekan
        $rekanList = [
            ['name' => 'Kha', 'latin' => 'Kha', 'pronunciation' => 'kha', 'image' => 'aksara-jawa/rekan/kha.svg', 'desc' => 'Aksara Rekan Kha digunakake kanggo nulisake tembung serapan saka basa Arab kanthi swara /kh/.'],
            ['name' => 'Fa',  'latin' => 'Fa / Va', 'pronunciation' => 'fa', 'image' => 'aksara-jawa/rekan/fa.svg', 'desc' => 'Aksara Rekan Fa digunakake kanggo nulisake tembung serapan manca kanthi swara /f/ utawa /v/.'],
            ['name' => 'Za',  'latin' => 'Za',  'pronunciation' => 'za',  'image' => 'aksara-jawa/rekan/za.svg',  'desc' => 'Aksara Rekan Za digunakake kanggo nulisake tembung serapan saka basa Arab kanthi swara /z/.'],
            ['name' => 'Dza', 'latin' => 'Dza', 'pronunciation' => 'dza', 'image' => 'aksara-jawa/rekan/dza.svg', 'desc' => 'Aksara Rekan Dza digunakake kanggo nulisake tembung serapan saka basa Arab kanthi swara /dz/.'],
            ['name' => 'Gha', 'latin' => 'Gha', 'pronunciation' => 'gha', 'image' => 'aksara-jawa/rekan/gha.svg', 'desc' => 'Aksara Rekan Gha digunakake kanggo nulisake tembung serapan saka basa Arab kanthi swara /gh/.'],
        ];

        foreach ($rekanList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 7,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 9. 5 Pasangan Aksara Rekan
        $pasanganRekanList = [
            ['name' => 'Pasangan Kha', 'latin' => '-kha (Rekan)', 'pronunciation' => 'kha', 'image' => 'aksara-jawa/pasangan-rekan/pasangan-kha.svg', 'desc' => 'Pasangan Aksara Rekan Kha manggon ana ing ngisor aksara mati kanthi cecak telu.'],
            ['name' => 'Pasangan Fa',  'latin' => '-fa (Rekan)',  'pronunciation' => 'fa',  'image' => 'aksara-jawa/pasangan-rekan/pasangan-fa.svg',  'desc' => 'Pasangan Aksara Rekan Fa manggon ana ing jejere aksara mati kanthi cecak telu.'],
            ['name' => 'Pasangan Za',  'latin' => '-za (Rekan)',  'pronunciation' => 'za',  'image' => 'aksara-jawa/pasangan-rekan/pasangan-za.svg',  'desc' => 'Pasangan Aksara Rekan Za manggon ana ing ngisor aksara mati kanthi cecak telu.'],
            ['name' => 'Pasangan Dza', 'latin' => '-dza (Rekan)', 'pronunciation' => 'dza', 'image' => 'aksara-jawa/pasangan-rekan/pasangan-dza.svg', 'desc' => 'Pasangan Aksara Rekan Dza manggon ana ing ngisor aksara mati kanthi cecak telu.'],
            ['name' => 'Pasangan Gha', 'latin' => '-gha (Rekan)', 'pronunciation' => 'gha', 'image' => 'aksara-jawa/pasangan-rekan/pasangan-gha.svg', 'desc' => 'Pasangan Aksara Rekan Gha manggon ana ing ngisor aksara mati kanthi cecak telu.'],
        ];

        foreach ($pasanganRekanList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 8,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }

        // 10. 10 Angka Jawa (0 - 9)
        $angkaList = [
            ['name' => 'Angka 1', 'latin' => '1 (Siji)',  'pronunciation' => 'siji',  'image' => 'aksara-jawa/angka/angka-1.svg', 'desc' => 'Angka Jawa 1 wujude memper aksara Ga kawuwuhan sandhangan.'],
            ['name' => 'Angka 2', 'latin' => '2 (Loro)',  'pronunciation' => 'loro',  'image' => 'aksara-jawa/angka/angka-2.svg', 'desc' => 'Angka Jawa 2 wujude memper aksara Nga lelet.'],
            ['name' => 'Angka 3', 'latin' => '3 (Telu)',  'pronunciation' => 'telu',  'image' => 'aksara-jawa/angka/angka-3.svg', 'desc' => 'Angka Jawa 3 wujude memper aksara Nga lelet kawuwuhan suku.'],
            ['name' => 'Angka 4', 'latin' => '4 (Papat)', 'pronunciation' => 'papat', 'image' => 'aksara-jawa/angka/angka-4.svg', 'desc' => 'Angka Jawa 4 wujude memper aksara Ma miring.'],
            ['name' => 'Angka 5', 'latin' => '5 (Lima)',  'pronunciation' => 'lima',  'image' => 'aksara-jawa/angka/angka-5.svg', 'desc' => 'Angka Jawa 5 wujude memper aksara rekan.'],
            ['name' => 'Angka 6', 'latin' => '6 (Nem)',   'pronunciation' => 'nem',   'image' => 'aksara-jawa/angka/angka-6.svg', 'desc' => 'Angka Jawa 6 wujude memper aksara E kurung.'],
            ['name' => 'Angka 7', 'latin' => '7 (Pitu)',  'pronunciation' => 'pitu',  'image' => 'aksara-jawa/angka/angka-7.svg', 'desc' => 'Angka Jawa 7 wujude memper aksara La.'],
            ['name' => 'Angka 8', 'latin' => '8 (Wolu)',  'pronunciation' => 'wolu',  'image' => 'aksara-jawa/angka/angka-8.svg', 'desc' => 'Angka Jawa 8 wujude memper aksara Murda Pa.'],
            ['name' => 'Angka 9', 'latin' => '9 (Sanga)', 'pronunciation' => 'sanga', 'image' => 'aksara-jawa/angka/angka-9.svg', 'desc' => 'Angka Jawa 9 wujude memper aksara Ya.'],
            ['name' => 'Angka 0', 'latin' => '0 (Nol)',   'pronunciation' => 'nol',   'image' => 'aksara-jawa/angka/angka-0.svg', 'desc' => 'Angka Jawa 0 wujude bunderan cilik miring.'],
        ];

        foreach ($angkaList as $item) {
            JavaneseScriptDetail::create([
                'category_id' => 9,
                'name' => $item['name'],
                'latin' => $item['latin'],
                'pronunciation' => $item['pronunciation'],
                'image_path' => $item['image'],
                'description' => $item['desc'],
            ]);
        }
    }
}
