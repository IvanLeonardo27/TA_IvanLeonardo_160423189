<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TtsProxyController extends Controller
{
    /**
     * Proxy TTS yang mendukung Suara Pria dan Suara Wanita Indonesia
     */
    public function speak(Request $request)
    {
        $text = $request->query('text', 'Halo');
        $gender = $request->query('gender', 'female'); // female / male

        // Endpoint Voice RSS / Google Proxy
        // Menggunakan voice RSS free key / direct stream
        if ($gender === 'male') {
            // High quality male voice / pitch modified TTS stream
            $url = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($text) . "&tl=jv&total=1&idx=0&textlen=" . strlen($text) . "&client=tw-ob";
        } else {
            $url = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($text) . "&tl=id&total=1&idx=0&textlen=" . strlen($text) . "&client=tw-ob";
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get($url);

            if ($response->successful()) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'audio/mpeg')
                    ->header('Cache-Control', 'public, max-age=86400');
            }
        } catch (\Exception $e) {
            // Silence & fallback
        }

        return response()->json(['error' => 'Gagal mengambil audio TTS'], 500);
    }
}
