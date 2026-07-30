<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TtsProxyController extends Controller
{
    /**
     * Proxy TTS yang mendukung Suara Bahasa Jawa & Indonesia dengan Web Audio fallback
     */
    public function speak(Request $request)
    {
        $text = trim($request->query('text', 'Sugeng rawuh'));
        if (empty($text)) {
            return response()->json(['error' => 'Teks kosong'], 400);
        }

        // Potong teks jika terlalu panjang agar Google TTS tidak error/timeout
        $cleanText = mb_substr($text, 0, 200);
        $gender = $request->query('gender', 'female');

        // Pilihan bahasa: tl=jv (Jawa) atau tl=id (Indonesia)
        $lang = ($gender === 'male') ? 'jv' : 'id';
        $url = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($cleanText) . "&tl=" . $lang . "&client=tw-ob";

        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Referer' => 'https://translate.google.com/'
                ])->get($url);

            if ($response->successful() && strlen($response->body()) > 100) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'audio/mpeg')
                    ->header('Cache-Control', 'public, max-age=86400');
            }
        } catch (\Exception $e) {
            // Log & Fallback
        }

        // Fallback endpoint 2 jika endpoint 1 bermasalah
        try {
            $fallbackUrl = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($cleanText) . "&tl=id&client=tw-ob";
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])->get($fallbackUrl);

            if ($response->successful() && strlen($response->body()) > 100) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'audio/mpeg');
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return response()->json(['error' => 'Gagal memuat audio TTS'], 500);
    }
}
