<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class CustomerTranslateController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:2000'],
            'source' => ['nullable', 'string', 'max:10'],
            'target' => ['nullable', 'string', 'max:10'],
        ]);

        $source = $data['source'] ?? 'id';
        $target = $data['target'] ?? 'jw';

        try {
            $tr = new GoogleTranslate();
            $tr->setSource($source);
            $tr->setTarget($target);

            $translated = $tr->translate($data['text']);

            return response()->json([
                'translated' => $translated,
                'source' => $source,
                'target' => $target,
            ]);
        } catch (Throwable $e) {
            Log::warning('Translate failed', [
                'message' => $e->getMessage(),
                'source' => $source,
                'target' => $target,
            ]);

            return response()->json([
                'message' => 'Gagal menerjemahkan. Coba lagi sebentar.',
            ], 422);
        }
    }
}
