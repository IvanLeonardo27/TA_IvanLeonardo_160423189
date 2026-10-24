<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class CustomerTranslateController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'text'    => ['required', 'string', 'max:2000'],
            'source'  => ['nullable', 'string', 'max:10'],
            'target'  => ['nullable', 'string', 'max:10'],
            'dialect' => ['nullable', 'string', 'in:ngoko,krama'],
        ]);

        $source    = $data['source'] ?? 'id';
        $target    = $data['target'] ?? 'jw';
        $dialect   = $data['dialect'] ?? 'ngoko';
        $inputText = trim($data['text']);

        $rawTranslated = $this->fetchNeuralTranslation($inputText, $source, $target);

        if ($rawTranslated === null || trim($rawTranslated) === '') {
            // Fallback ke Mesin Penerjemah Lokal jika internet/endpoint tidak dapat diakses
            $rawTranslated = $this->translateUsingLocalDictionary($inputText, $source, $target, $dialect);
        } else {
            if ($source === 'id' && $target === 'jw') {
                if ($dialect === 'krama') {
                    $rawTranslated = $this->convertToKrama($rawTranslated, $inputText);
                } else {
                    $rawTranslated = $this->refineNgoko($rawTranslated);
                }
            }
        }

        return response()->json([
            'translated' => $rawTranslated,
            'source'     => $source,
            'target'     => $target,
            'dialect'    => $dialect,
        ]);
    }

    /**
     * Multi-Endpoint Neural Translation (menghindari error 429 Too Many Requests dari translate.google.com)
     */
    private function fetchNeuralTranslation(string $text, string $source, string $target): ?string
    {
        // Endpoint 1: translate.googleapis.com (Stabil & bebas 429 rate-limit)
        try {
            $response = Http::timeout(6)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                ])
                ->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl'     => $source,
                    'tl'     => $target,
                    'dt'     => 't',
                    'q'      => $text,
                ]);

            if ($response->successful()) {
                $json = $response->json();
                if (isset($json[0]) && is_array($json[0])) {
                    $translatedParts = [];
                    foreach ($json[0] as $segment) {
                        if (isset($segment[0]) && is_string($segment[0])) {
                            $translatedParts[] = $segment[0];
                        }
                    }
                    $combined = implode('', $translatedParts);
                    if (trim($combined) !== '') {
                        return $combined;
                    }
                }
            }
        } catch (Throwable $e) {
            Log::debug('Primary googleapis translate failed', ['error' => $e->getMessage()]);
        }

        // Endpoint 2: clients5.google.com
        try {
            $response = Http::timeout(6)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ])
                ->get('https://clients5.google.com/translate_a/t', [
                    'client' => 'dict-chrome-ex',
                    'sl'     => $source,
                    'tl'     => $target,
                    'q'      => $text,
                ]);

            if ($response->successful()) {
                $json = $response->json();
                if (isset($json[0]) && is_string($json[0]) && trim($json[0]) !== '') {
                    return $json[0];
                }
                if (isset($json['sentences']) && is_array($json['sentences'])) {
                    $parts = [];
                    foreach ($json['sentences'] as $s) {
                        if (!empty($s['trans'])) {
                            $parts[] = $s['trans'];
                        }
                    }
                    if (!empty($parts)) {
                        return implode('', $parts);
                    }
                }
            }
        } catch (Throwable $e) {
            Log::debug('Secondary clients5 translate failed', ['error' => $e->getMessage()]);
        }

        // Endpoint 3: Stichoza GoogleTranslate package
        try {
            $tr = new GoogleTranslate();
            $tr->setSource($source);
            $tr->setTarget($target);
            $res = $tr->translate($text);
            if (!empty($res)) {
                return $res;
            }
        } catch (Throwable $e) {
            Log::info('All Google Translate endpoints unavailable, switching to local dictionary fallback', [
                'message' => $e->getMessage()
            ]);
        }

        return null;
    }

    /**
     * Penyempurnaan dialek Ngoko sehari-hari agar lebih luwes & natural
     */
    private function refineNgoko(string $javaneseText): string
    {
        $replacements = [
            '/\bdina iki\b/iu'      => 'dino iki',
            '/\bsega goreng\b/iu'   => 'sego goreng',
            '/\bsega\b/iu'          => 'sego',
            '/\bing restoran\b/iu'  => 'nang restoran',
            '/\bing pasar\b/iu'     => 'nang pasar',
            '/\bing omah\b/iu'      => 'nang omah',
            '/\bing sekolah\b/iu'   => 'nang sekolah',
            '/\brestoran cina\b/iu' => 'restoran Cino',
        ];

        $result = $javaneseText;
        foreach ($replacements as $pattern => $replacement) {
            $result = preg_replace_callback($pattern, function ($matches) use ($replacement) {
                $matched = $matches[0];
                if (ctype_upper(mb_substr($matched, 0, 1))) {
                    return mb_strtoupper(mb_substr($replacement, 0, 1)) . mb_substr($replacement, 1);
                }
                return $replacement;
            }, $result);
        }

        return $result;
    }

    /**
     * Mesin Penerjemah Cadangan (Local Dictionary Engine) berbasis Database Kosakata + Imbuhan
     */
    private function translateUsingLocalDictionary(string $text, string $source, string $target, string $dialect): string
    {
        $dictionary = Vocabulary::all();

        $map = [];
        foreach ($dictionary as $v) {
            $indo  = mb_strtolower(trim($v->indonesian_word));
            $ngoko = $this->cleanDictWord($v->javanese_ngoko);
            $krama = $this->cleanDictWord($v->javanese_krama);

            if ($source === 'id') {
                $targetWord = ($dialect === 'krama' && !empty($krama)) ? $krama : $ngoko;
                if ($indo && $targetWord) {
                    $map[$indo] = $targetWord;
                }
            } else {
                if ($ngoko && $indo) $map[$ngoko] = $indo;
                if ($krama && $indo) $map[$krama] = $indo;
            }
        }

        if ($source === 'id') {
            $phraseFallbacks = $dialect === 'krama' ? [
                'hari ini'       => 'dinten menika',
                'pagi ini'       => 'enjing menika',
                'siang ini'      => 'siyang menika',
                'sore ini'       => 'sonten menika',
                'malam ini'      => 'dalu menika',
                'nasi goreng'    => 'sekul goreng',
                'enak sekali'    => 'eco sanget',
                'mahal harganya' => 'reginipun awrat',
                'harganya mahal' => 'reginipun awrat',
                'terima kasih'   => 'matur nuwun',
            ] : [
                'hari ini'       => 'dino iki',
                'pagi ini'       => 'isuk iki',
                'siang ini'      => 'awan iki',
                'sore ini'       => 'sore iki',
                'malam ini'      => 'bengi iki',
                'nasi goreng'    => 'sego goreng',
                'enak sekali'    => 'enak banget',
                'mahal harganya' => 'regane larang',
                'harganya mahal' => 'regane larang',
                'restoran cina'  => 'restoran Cino',
                'terima kasih'   => 'matur nuwun',
            ];

            foreach ($phraseFallbacks as $idPhrase => $jwPhrase) {
                $text = preg_replace_callback('/\b' . preg_quote($idPhrase, '/') . '\b/iu', function ($m) use ($jwPhrase) {
                    return ctype_upper(mb_substr($m[0], 0, 1))
                        ? mb_strtoupper(mb_substr($jwPhrase, 0, 1)) . mb_substr($jwPhrase, 1)
                        : $jwPhrase;
                }, $text);
            }
        }

        $fallbacks = $dialect === 'krama' ? [
            'aku' => 'kula', 'saya' => 'kula', 'kamu' => 'panjenengan', 'anda' => 'panjenengan',
            'dia' => 'piyambakipun', 'makan' => 'dhahar', 'minum' => 'unjuk', 'tidur' => 'sare',
            'pergi' => 'tindak', 'datang' => 'rawuh', 'pulang' => 'kondur', 'rumah' => 'griya',
            'nasi' => 'sekul', 'air' => 'toya', 'bersama' => 'kaliyan', 'dengan' => 'kaliyan',
            'dan' => 'kaliyan', 'di' => 'wonten', 'ke' => 'dhateng', 'dari' => 'saking',
            'ini' => 'menika', 'itu' => 'menika', 'rasanya' => 'raosipun', 'harganya' => 'reginipun',
            'keluargaku' => 'kulawarga kula', 'keluarga' => 'kulawarga', 'enak' => 'eco',
            'sekali' => 'sanget', 'sangat' => 'sanget', 'tapi' => 'nanging', 'tetapi' => 'nanging',
            'mahal' => 'awrat', 'murah' => 'mirah', 'tidak' => 'mboten', 'belum' => 'dereng',
            'sudah' => 'sampun', 'bisa' => 'saged', 'mau' => 'kersa', 'ingin' => 'badhe',
        ] : [
            'aku' => 'aku', 'saya' => 'aku', 'kamu' => 'kowe', 'dia' => 'dheweke',
            'makan' => 'mangan', 'minum' => 'ngombe', 'tidur' => 'turu', 'pergi' => 'lunga',
            'datang' => 'teka', 'pulang' => 'mulih', 'rumah' => 'omah', 'nasi' => 'sego',
            'air' => 'banyu', 'bersama' => 'karo', 'dengan' => 'karo', 'dan' => 'lan',
            'di' => 'nang', 'ke' => 'nang', 'dari' => 'saka', 'ini' => 'iki', 'itu' => 'iku',
            'rasanya' => 'rasane', 'harganya' => 'regane', 'keluargaku' => 'keluargaku',
            'enak' => 'enak', 'sekali' => 'banget', 'sangat' => 'banget', 'tapi' => 'nanging',
            'tetapi' => 'nanging', 'mahal' => 'larang', 'murah' => 'murah', 'tidak' => 'ora',
            'belum' => 'durung', 'sudah' => 'wis', 'bisa' => 'iso', 'mau' => 'gelem', 'ingin' => 'pengin',
        ];

        $tokens = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = [];

        foreach ($tokens as $token) {
            $lower = mb_strtolower($token);
            if (trim($token) === '') {
                $result[] = $token;
                continue;
            }

            if (isset($fallbacks[$lower])) {
                $result[] = $this->matchCase($token, $fallbacks[$lower]);
            } elseif (isset($map[$lower])) {
                $result[] = $this->matchCase($token, $map[$lower]);
            } else {
                $result[] = $token;
            }
        }

        return implode('', $result);
    }

    /**
     * Mengubah teks hasil terjemahan Jawa Ngoko menjadi Krama Alus / Krama Inggil secara kontekstual
     */
    private function convertToKrama(string $javaneseText, string $originalIndonesianText): string
    {
        // 1. Konversi Frasa Majemuk (Multi-word Expressions) terlebih dahulu
        $phraseMap = [
            'dina iki'      => 'dinten menika',
            'dino iki'      => 'dinten menika',
            'esuk iki'      => 'enjing menika',
            'isuk iki'      => 'enjing menika',
            'awan iki'      => 'siyang menika',
            'sore iki'      => 'sonten menika',
            'bengi iki'     => 'dalu menika',
            'wengi iki'     => 'dalu menika',
            'sega goreng'   => 'sekul goreng',
            'sego goreng'   => 'sekul goreng',
            'enak banget'   => 'eco sanget',
            'penak banget'  => 'eco sanget',
            'penak tenan'   => 'eco sanget',
            'enak tenan'    => 'eco sanget',
            'regane larang' => 'reginipun awrat',
            'larang regane' => 'awrat reginipun',
            'keluargaku'    => 'kulawarga kula',
            'kulawargaku'   => 'kulawarga kula',
            'keluargamu'    => 'kulawarga panjenengan',
            'kulawargamu'   => 'kulawarga panjenengan',
            'ana ing'       => 'wonten',
            'matur suwun'   => 'matursembah nuwun',
        ];

        $text = $javaneseText;
        foreach ($phraseMap as $ngokoPhrase => $kramaPhrase) {
            $text = preg_replace_callback('/\b' . preg_quote($ngokoPhrase, '/') . '\b/iu', function ($m) use ($kramaPhrase) {
                return $this->matchCase($m[0], $kramaPhrase);
            }, $text);
        }

        // 2. Kamus Prioritas Tata Bahasa & Krama Alus / Inggil
        $priorityKramaMap = [
            'aku'       => 'kula',
            'kowe'      => 'panjenengan',
            'awakmu'    => 'panjenengan',
            'dheweke'   => 'piyambakipun',
            'mangan'    => 'dhahar',
            'nedha'     => 'dhahar',
            'ngombe'    => 'unjuk',
            'turu'      => 'sare',
            'lunga'     => 'tindak',
            'teka'      => 'rawuh',
            'mulih'     => 'kondur',
            'tuku'      => 'mundhut',
            'nggawa'    => 'mbekta',
            'ndelok'    => 'mirsani',
            'nyawang'   => 'mirsani',
            'krungu'    => 'mireng',
            'ngomong'   => 'ngendika',
            'kandha'    => 'ngendika',
            'takon'     => 'nyuwun pirsa',
            'menehi'    => 'maringi',
            'njaluk'    => 'nyuwun',
            'sega'      => 'sekul',
            'sego'      => 'sekul',
            'banyu'     => 'toya',
            'karo'      => 'kaliyan',
            'lan'       => 'kaliyan',
            'ing'       => 'wonten',
            'nang'      => 'wonten',
            'neng'      => 'wonten',
            'ning'      => 'wonten',
            'saka'      => 'saking',
            'kanggo'    => 'kagem',
            'menyang'   => 'dhateng',
            'rasane'    => 'raosipun',
            'regane'    => 'reginipun',
            'enak'      => 'eco',
            'penak'     => 'eco',
            'banget'    => 'sanget',
            'tenan'     => 'sanget',
            'nanging'   => 'nanging',
            'larang'    => 'awrat',
            'murah'     => 'mirah',
            'iki'       => 'menika',
            'iku'       => 'menika',
            'kuwi'      => 'menika',
            'ana'       => 'wonten',
            'ora'       => 'mboten',
            'durung'    => 'dereng',
            'wis'       => 'sampun',
            'isih'      => 'taksih',
            'bisa'      => 'saged',
            'iso'       => 'saged',
            'gelem'     => 'kersa',
            'arep'      => 'badhe',
            'pengin'    => 'badhe',
            'kabeh'     => 'sedaya',
            'akeh'      => 'kathah',
            'sithik'    => 'sekedhik',
            'gedhe'     => 'ageng',
            'cilik'     => 'alit',
            'apik'      => 'sae',
            'becik'     => 'sae',
            'ala'       => 'awon',
            'elek'      => 'awon',
            'cepet'     => 'enggal',
            'suwe'      => 'dangu',
            'adoh'      => 'tebih',
            'cedhak'    => 'celak',
            'omah'      => 'griya',
            'keluarga'  => 'kulawarga',
            'kulawarga' => 'kulawarga',
            'dina'      => 'dinten',
            'dino'      => 'dinten',
        ];

        // 3. Kamus Database Kosakata (dibersihkan dari garis miring seperti "Dhahar/Nedha")
        $dictionary = Vocabulary::query()
            ->whereNotNull('javanese_krama')
            ->where('javanese_krama', '!=', '')
            ->get(['indonesian_word', 'javanese_ngoko', 'javanese_krama']);

        $ngokoToKramaMap = [];
        $indoToKramaMap  = [];

        foreach ($dictionary as $vocab) {
            $krama = $this->cleanDictWord($vocab->javanese_krama);
            $ngoko = $this->cleanDictWord($vocab->javanese_ngoko);
            $indo  = mb_strtolower(trim($vocab->indonesian_word));

            if (!$krama) continue;

            if ($ngoko !== '' && $ngoko !== $krama) {
                $ngokoToKramaMap[$ngoko] = $krama;
            }
            if ($indo !== '' && $indo !== $krama) {
                $indoToKramaMap[$indo] = $krama;
            }
        }

        $words = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        $resultWords = [];
        foreach ($words as $word) {
            if (trim($word) === '' || !preg_match('/^\w+$/u', $word)) {
                $resultWords[] = $word;
                continue;
            }

            $lowerWord = mb_strtolower($word);

            // Cek di kamus prioritas Krama
            if (isset($priorityKramaMap[$lowerWord])) {
                $resultWords[] = $this->matchCase($word, $priorityKramaMap[$lowerWord]);
                continue;
            }

            // Cek di kamus Ngoko -> Krama database
            if (isset($ngokoToKramaMap[$lowerWord])) {
                $resultWords[] = $this->matchCase($word, $ngokoToKramaMap[$lowerWord]);
                continue;
            }

            // Cek di kamus Indo -> Krama database
            if (isset($indoToKramaMap[$lowerWord])) {
                $resultWords[] = $this->matchCase($word, $indoToKramaMap[$lowerWord]);
                continue;
            }

            // Penanganan akhiran kepemilikan "-ku" -> "... kula"
            if (mb_strlen($lowerWord) > 4 && str_ends_with($lowerWord, 'ku')) {
                $stem = mb_substr($lowerWord, 0, -2);
                $kramaStem = $priorityKramaMap[$stem] ?? $ngokoToKramaMap[$stem] ?? $indoToKramaMap[$stem] ?? $stem;
                $resultWords[] = $this->matchCase($word, $kramaStem . ' kula');
                continue;
            }

            // Penanganan akhiran kepemilikan "-mu" -> "... panjenengan"
            if (mb_strlen($lowerWord) > 4 && str_ends_with($lowerWord, 'mu')) {
                $stem = mb_substr($lowerWord, 0, -2);
                $kramaStem = $priorityKramaMap[$stem] ?? $ngokoToKramaMap[$stem] ?? $indoToKramaMap[$stem] ?? $stem;
                $resultWords[] = $this->matchCase($word, $kramaStem . ' panjenengan');
                continue;
            }

            // Penanganan akhiran "-ne" / "-e" -> "-ipun" / "-nipun"
            if (mb_strlen($lowerWord) > 4 && str_ends_with($lowerWord, 'ne')) {
                $stem = mb_substr($lowerWord, 0, -2);
                $kramaStem = $priorityKramaMap[$stem] ?? $ngokoToKramaMap[$stem] ?? $indoToKramaMap[$stem] ?? null;
                if ($kramaStem) {
                    $suffix = preg_match('/[aiueo]$/iu', $kramaStem) ? 'nipun' : 'ipun';
                    $resultWords[] = $this->matchCase($word, $kramaStem . $suffix);
                    continue;
                }
            } elseif (mb_strlen($lowerWord) > 4 && str_ends_with($lowerWord, 'e')) {
                $stem = mb_substr($lowerWord, 0, -1);
                $kramaStem = $priorityKramaMap[$stem] ?? $ngokoToKramaMap[$stem] ?? $indoToKramaMap[$stem] ?? null;
                if ($kramaStem) {
                    $suffix = preg_match('/[aiueo]$/iu', $kramaStem) ? 'nipun' : 'ipun';
                    $resultWords[] = $this->matchCase($word, $kramaStem . $suffix);
                    continue;
                }
            }

            $resultWords[] = $word;
        }

        return implode('', $resultWords);
    }

    /**
     * Membersihkan entri kamus seperti "Dhahar/Nedha" menjadi satu kata bersih ("dhahar")
     */
    private function cleanDictWord(?string $raw): string
    {
        if (!$raw) return '';
        $parts = preg_split('/[\/,;]+/', trim($raw));
        return mb_strtolower(trim($parts[0] ?? ''));
    }

    /**
     * Menyesuaikan huruf kapital di awal kata sesuai teks asli
     */
    private function matchCase(string $original, string $replacement): string
    {
        if ($replacement === '') return '';
        $firstChar = mb_substr($original, 0, 1);
        if (ctype_upper($firstChar)) {
            return mb_strtoupper(mb_substr($replacement, 0, 1)) . mb_substr($replacement, 1);
        }
        return $replacement;
    }
}
