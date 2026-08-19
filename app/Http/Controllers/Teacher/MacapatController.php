<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\MacapatCategory;
use App\Models\MacapatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MacapatController extends Controller
{
    /**
     * Tampilkan daftar kategori Tembang Macapat.
     */
    public function index()
    {
        $categories = MacapatCategory::withCount('details')->latest()->paginate(10);
        return view('teacher.macapat.index', compact('categories'));
    }

    /**
     * Form tambah kategori Macapat baru (Hanya Admin).
     */
    public function create()
    {
        Gate::authorize('admin');
        return view('teacher.macapat.create');
    }

    /**
     * Simpan kategori Macapat baru (Hanya Admin).
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

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
     * Form edit kategori Macapat (Hanya Admin).
     */
    public function edit(MacapatCategory $macapat)
    {
        Gate::authorize('admin');
        return view('teacher.macapat.edit', ['category' => $macapat]);
    }

    /**
     * Update data kategori Macapat (Hanya Admin).
     */
    public function update(Request $request, MacapatCategory $macapat)
    {
        Gate::authorize('admin');

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
     * Hapus kategori Macapat beserta seluruh baitnya (Hanya Admin).
     */
    public function destroy(MacapatCategory $macapat)
    {
        Gate::authorize('admin');

        $macapat->delete();

        return redirect()->route('teacher.macapat.index')->with('success', 'Kategori Tembang Macapat berhasil dihapus.');
    }

    /**
     * Tambah bait (detail) pada tembang macapat (Hanya Admin).
     */
    public function storeDetail(Request $request, MacapatCategory $macapat)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'verse' => 'required|string',
            'meaning' => 'nullable|string',
            'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:5120',
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

        return back()->with('success', 'Bait tembang berhasil ditambahkan.');
    }

    /**
     * Hapus bait (detail) tembang macapat (Hanya Admin).
     */
    public function destroyDetail(MacapatDetail $detail)
    {
        Gate::authorize('admin');

        if ($detail->audio_path && Storage::disk('public')->exists($detail->audio_path)) {
            Storage::disk('public')->delete($detail->audio_path);
        }

        $detail->delete();

        return back()->with('success', 'Bait tembang berhasil dihapus.');
    }
}
