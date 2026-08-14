<?php

namespace App\Http\Controllers;

use App\Models\MacapatCategory;
use Illuminate\Http\Request;

class MacapatController extends Controller
{
    /**
     * Menampilkan daftar 10 Tembang Macapat untuk siswa.
     */
    public function index()
    {
        $categories = MacapatCategory::orderBy('name', 'asc')->get();

        return view('macapat.index', compact('categories'));
    }

    /**
     * Menampilkan detail satu Tembang Macapat beserta seluruh contoh baitnya.
     */
    public function show($id)
    {
        $category = MacapatCategory::with('details')->findOrFail($id);

        return view('macapat.show', compact('category'));
    }
}
