<?php

namespace App\Http\Controllers;

use App\Models\JavaneseScriptCategory;
use App\Models\JavaneseScriptDetail;
use Illuminate\Http\Request;

class JavaneseScriptController extends Controller
{
    /**
     * Menampilkan katalog pembelajaran Aksara Jawa.
     */
    public function index()
    {
        $categories = JavaneseScriptCategory::with('details')->get();
        $scripts = JavaneseScriptDetail::with('category')->orderBy('id', 'asc')->get();

        return view('javanese-script.index', compact('categories', 'scripts'));
    }

    /**
     * Menampilkan detail satu karakter Aksara Jawa.
     */
    public function show($id)
    {
        $script = JavaneseScriptDetail::with(['category', 'examples'])->findOrFail($id);

        // Navigasi aksara sebelumnya & berikutnya dalam kategori yang sama
        $previousScript = JavaneseScriptDetail::where('category_id', $script->category_id)
            ->where('id', '<', $script->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextScript = JavaneseScriptDetail::where('category_id', $script->category_id)
            ->where('id', '>', $script->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('javanese-script.show', compact('script', 'previousScript', 'nextScript'));
    }
}
