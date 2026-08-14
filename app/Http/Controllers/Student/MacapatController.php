<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MacapatCategory;
use Illuminate\Http\Request;

class MacapatController extends Controller
{
    /**
     * Tampilkan katalog Tembang Macapat untuk siswa.
     */
    public function index()
    {
        $categories = MacapatCategory::withCount('details')->get();
        return view('student.macapat.index', compact('categories'));
    }

    /**
     * Tampilkan detail tembang, paugeran (guru gatra, wilangan, lagu), cakepan/lirik dan audio.
     */
    public function show(MacapatCategory $macapat)
    {
        $macapat->load('details');
        return view('student.macapat.show', ['category' => $macapat]);
    }
}
