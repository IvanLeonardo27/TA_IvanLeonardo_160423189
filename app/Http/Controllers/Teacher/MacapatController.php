<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\MacapatCategory;
use App\Models\MacapatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MacapatController extends Controller
{
    /**
     * Tampilkan daftar kategori Tembang Macapat.
     */
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('teacher');
        $categories = MacapatCategory::withCount('details')->latest()->paginate(10);
        return view('teacher.macapat.index', compact('categories'));
    }

    /**
     * Form tambah kategori Macapat baru.
     */
    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('teacher');
        return view('teacher.macapat.create');
    }

    /**
     * Simpan kategori Macapat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'guru_gatra' => 'required|integer|min:1',
            'guru_wilangan' => 'required|string|max:100',
            'guru_lagu' => 'required|string|max:100',
            'watak' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        MacapatCategory::create($validated);

        return redirect()->route('teacher.macapat.index')->with('success', 'Kategori Tembang Macapat berhasil ditambahkan.');
    }

    /**
     * Detail kategori beserta daftar bait/cakepan (details).
     */
    public function show(MacapatCategory $macapat)
    {
        $macapat->load('details');
        return view('teacher.macapat.show', ['category' => $macapat]);
    }

    /**
     * Form edit kategori Macapat.
     */
    public function edit(MacapatCategory $macapat)
    {
        return view('teacher.macapat.edit', ['category' => $macapat]);
    }

    /**
     * Update data kategori Macapat.
     */
    public function update(Request $request, MacapatCategory $macapat)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'guru_gatra' => 'required|integer|min:1',
            'guru_wilangan' => 'required|string|max:100',
            'guru_lagu' => 'required|string|max:100',
            'watak' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $macapat->update($validated);

        return redirect()->route('teacher.macapat.index')->with('success', 'Kategori Tembang Macapat berhasil diperbarui.');
    }

    /**
     * Hapus kategori Macapat beserta detailnya.
     */
    public function destroy(MacapatCategory $macapat)
    {
        $macapat->delete();
        return redirect()->route('teacher.macapat.index')->with('success', 'Kategori Tembang Macapat berhasil dihapus.');
    }

    /**
     * Simpan detail bait/cakepan baru ke kategori Macapat.
     */
    public function storeDetail(Request $request, MacapatCategory $macapat)
    {
        $validated = $request->validate([
            'verse' => 'required|string',
            'meaning' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240',
        ]);

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('macapat_audio', 'public');
        }

        $macapat->details()->create([
            'verse' => $validated['verse'],
            'meaning' => $validated['meaning'] ?? null,
            'audio_path' => $audioPath,
        ]);

        return back()->with('success', 'Bait tembang macapat berhasil ditambahkan.');
    }

    /**
     * Hapus detail bait macapat.
     */
    public function destroyDetail(MacapatDetail $detail)
    {
        if ($detail->audio_path && Storage::disk('public')->exists($detail->audio_path)) {
            Storage::disk('public')->delete($detail->audio_path);
        }

        $detail->delete();

        return back()->with('success', 'Bait tembang macapat berhasil dihapus.');
    }
}
