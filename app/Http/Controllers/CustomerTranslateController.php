<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
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

        $source  = $data['source'] ?? 'id';
        $target  = $data['target'] ?? 'jw';
        $dialect = $data['dialect'] ?? 'ngoko';

        // Batasan Minimal 10 Kata
        $words = preg_split('/\s+/u', trim($data['text']), -1, PREG_SPLIT_NO_EMPTY);
        $wordCount = count($words);

        if ($wordCount < 10) {
            return response()->json([
                'message' => "Teks yang dapat diterjemahkan minimal 10 kata. (Input Anda: {$wordCount} kata)",
            ], 422);
        }

        $rawTranslated = null;

        // Layer 1: Google Translate API
        try {
            $tr = new GoogleTranslate();
            $tr->setSource($source);
            $tr->setTarget($target);

            $rawTranslated = $tr->translate($data['text']);
        } catch (Throwable $e) {
            Log::info('Google Translate API unavailable/rate limited, switching to local dictionary fallback', [
                'message' => $e->getMessage()
            ]);
            
            // Layer 2: Fallback ke Mesin Penerjemah Lokal
            $rawTranslated = $this->translateUsingLocalDictionary($data['text'], $source, $target, $dialect);
        }

        // Jika penerjemahan dari Indonesia -> Jawa dan pengguna memilih Krama
        if ($source === 'id' && $dialect === 'krama') {
            $rawTranslated = $this->convertToKrama($rawTranslated, $data['text']);
        }

        return response()->json([
            'translated' => $rawTranslated,
            'source'     => $source,
            'target'     => $target,
            'dialect'    => $dialect,
        ]);
    }

    /**
     * Mesin Penerjemah Cadangan (Local Dictionary Engine) berbasis 1.864 Database Kosakata
     */
    private function translateUsingLocalDictionary(string $text, string $source, string $target, string $dialect): string
    {
        $dictionary = Vocabulary::all();

        $map = [];
        foreach ($dictionary as $v) {
            $indo  = mb_strtolower(trim($v->indonesian_word));
            $ngoko = mb_strtolower(trim($v->javanese_ngoko));
            $krama = mb_strtolower(trim($v->javanese_krama));

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

        // Common word fallbacks
        $fallbacks = [
            'aku' => 'aku', 'saya' => 'kula', 'mau' => 'gelem', 'ingin' => 'pengin',
            'makan' => 'pangan', 'kamu' => 'kowe', 'dia' => 'dheweke', 'pergi' => 'lunga',
            'datang' => 'teka', 'rumah' => 'omah', 'sekolah' => 'sekolah', 'tidur' => 'turu',
            'minum' => 'ngombe', 'belajar' => 'sinau', 'membaca' => 'maca', 'nulis' => 'menulis'
        ];

        $tokens = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = [];

        foreach ($tokens as $token) {
            $lower = mb_strtolower($token);
            if (trim($token) === '') {
                $result[] = $token;
                continue;
            }

            if (isset($map[$lower])) {
                $trans = $map[$lower];
                if (ctype_upper(mb_substr($token, 0, 1))) {
                    $trans = mb_convert_case($trans, MB_CASE_TITLE, "UTF-8");
                }
                $result[] = $trans;
            } elseif (isset($fallbacks[$lower])) {
                $trans = $fallbacks[$lower];
                if (ctype_upper(mb_substr($token, 0, 1))) {
                    $trans = mb_convert_case($trans, MB_CASE_TITLE, "UTF-8");
                }
                $result[] = $trans;
            } else {
                $result[] = $token;
            }
        }

        return implode('', $result);
    }

    /**
     * Mengubah kata-kata Ngoko menjadi Krama berdasarkan database kosakata
     */
    private function convertToKrama(string $javaneseText, string $originalIndonesianText): string
    {
        $dictionary = Vocabulary::query()
            ->whereNotNull('javanese_krama')
            ->where('javanese_krama', '!=', '')
            ->get(['indonesian_word', 'javanese_ngoko', 'javanese_krama']);

        $ngokoToKramaMap = [];
        $indoToKramaMap = [];

        foreach ($dictionary as $vocab) {
            $krama = trim($vocab->javanese_krama);
            $ngoko = trim($vocab->javanese_ngoko);
            $indo  = trim($vocab->indonesian_word);

            if ($ngoko !== '' && strtolower($ngoko) !== strtolower($krama)) {
                $ngokoToKramaMap[mb_strtolower($ngoko)] = $krama;
            }
            if ($indo !== '' && strtolower($indo) !== strtolower($krama)) {
                $indoToKramaMap[mb_strtolower($indo)] = $krama;
            }
        }

        $words = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $javaneseText, -1, PREG_SPLIT_DELIM_CAPTURE);

        $resultWords = [];
        foreach ($words as $word) {
            $lowerWord = mb_strtolower($word);
            if (isset($ngokoToKramaMap[$lowerWord])) {
                $targetKrama = $ngokoToKramaMap[$lowerWord];
                if (ctype_upper(mb_substr($word, 0, 1))) {
                    $targetKrama = mb_convert_case($targetKrama, MB_CASE_TITLE, "UTF-8");
                }
                $resultWords[] = $targetKrama;
            } elseif (isset($indoToKramaMap[$lowerWord])) {
                $targetKrama = $indoToKramaMap[$lowerWord];
                if (ctype_upper(mb_substr($word, 0, 1))) {
                    $targetKrama = mb_convert_case($targetKrama, MB_CASE_TITLE, "UTF-8");
                }
                $resultWords[] = $targetKrama;
            } else {
                $resultWords[] = $word;
            }
        }

        return implode('', $resultWords);
    }
}
