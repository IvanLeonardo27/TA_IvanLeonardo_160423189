<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vocabulary;

$input = 'aku mau makan aku mau makan aku mau makan aku';

// Build Dictionary Map
$dictionary = Vocabulary::all();

$indoToNgoko = [];
$indoToKrama = [];
$ngokoToIndo = [];
$kramaToIndo = [];

foreach ($dictionary as $v) {
    $indo  = mb_strtolower(trim($v->indonesian_word));
    $ngoko = mb_strtolower(trim($v->javanese_ngoko));
    $krama = mb_strtolower(trim($v->javanese_krama));

    if ($indo) {
        if ($ngoko) $indoToNgoko[$indo] = trim($v->javanese_ngoko);
        if ($krama) $indoToKrama[$indo] = trim($v->javanese_krama);
    }
}

// Custom Common Words fallback dictionary if not in DB
$fallbackIndoToNgoko = [
    'aku' => 'aku',
    'saya' => 'kula',
    'mau' => 'gelem',
    'ingin' => 'pengin',
    'makan' => 'pangan',
    'kamu' => 'kowe',
    'dia' => 'dheweke',
    'mereka' => 'dheweke kabeh',
    'kami' => 'kita',
    'kita' => 'kita',
    'pergi' => 'lunga',
    'datang' => 'teka',
    'rumah' => 'omah',
    'sekolah' => 'sekolah',
    'tidur' => 'turu',
    'minum' => 'ngombe',
    'belajar' => 'sinau',
    'membaca' => 'maca',
    'menulis' => 'nulis',
    'bicara' => 'guneman',
];

$words = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $input, -1, PREG_SPLIT_DELIM_CAPTURE);
$translatedWords = [];

foreach ($words as $w) {
    $lower = mb_strtolower($w);
    if (trim($w) === '') {
        $translatedWords[] = $w;
        continue;
    }

    if (isset($indoToNgoko[$lower])) {
        $trans = $indoToNgoko[$lower];
        if (ctype_upper(mb_substr($w, 0, 1))) {
            $trans = mb_convert_case($trans, MB_CASE_TITLE, "UTF-8");
        }
        $translatedWords[] = $trans;
    } elseif (isset($fallbackIndoToNgoko[$lower])) {
        $trans = $fallbackIndoToNgoko[$lower];
        if (ctype_upper(mb_substr($w, 0, 1))) {
            $trans = mb_convert_case($trans, MB_CASE_TITLE, "UTF-8");
        }
        $translatedWords[] = $trans;
    } else {
        $translatedWords[] = $w;
    }
}

$result = implode('', $translatedWords);
echo "Local Dictionary Result: " . $result . "\n";
