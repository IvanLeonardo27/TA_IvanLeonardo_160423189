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

        try {
            // 1. Dapatkan hasil terjemahan dasar dari Google Translate API
            $tr = new GoogleTranslate();
            $tr->setSource($source);
            $tr->setTarget($target);

            $rawTranslated = $tr->translate($data['text']);

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
        } catch (Throwable $e) {
            Log::warning('Translate failed', [
                'message' => $e->getMessage(),
                'source'  => $source,
                'target'  => $target,
            ]);

            return response()->json([
                'message' => 'Gagal menerjemahkan. Coba lagi sebentar.',
            ], 422);
        }
    }

    /**
     * Mengubah kata-kata Ngoko menjadi Krama berdasarkan 1.864 database kosakata SinauBasa
     */
    private function convertToKrama(string $javaneseText, string $originalIndonesianText): string
    {
        // Ambil semua kosakata yang memiliki entri krama yang valid dan berbeda dari ngoko
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

        // 1. Ganti kata berdasarkan token hasil terjemahan Jawa (Ngoko -> Krama)
        $words = preg_split('/(\s+|[^\w\x{00C0}-\x{024F}]+)/u', $javaneseText, -1, PREG_SPLIT_DELIM_CAPTURE);

        $resultWords = [];
        foreach ($words as $word) {
            $lowerWord = mb_strtolower($word);
            if (isset($ngokoToKramaMap[$lowerWord])) {
                $targetKrama = $ngokoToKramaMap[$lowerWord];
                // Pertahankan kapitalisasi huruf pertama jika ada
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
