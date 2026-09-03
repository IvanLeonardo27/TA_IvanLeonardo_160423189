<?php

namespace App\Http\Controllers;

use App\Models\WayangCategory;
use App\Models\WayangCharacter;
use Illuminate\Http\Request;

class WayangController extends Controller
{
    /**
     * Tampilkan Katalog Tokoh Pewayangan dengan Filter & Pencarian
     */
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $categoryId = $request->query('category');
        $allegiance = $request->query('allegiance');

        $categories = WayangCategory::withCount('characters')->get();

        $query = WayangCharacter::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('other_names', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('character_traits', 'like', "%{$search}%")
                  ->orWhere('weapon', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($allegiance) {
            $query->where('allegiance', $allegiance);
        }

        $characters = $query->orderBy('id')->paginate(12)->withQueryString();

        $selectedCategory = $categoryId ? WayangCategory::find($categoryId) : null;
        $totalCharacters  = WayangCharacter::count();

        // Allegiance options for filter
        $allegiances = WayangCharacter::distinct('allegiance')->pluck('allegiance');

        return view('wayang.index', compact(
            'categories',
            'characters',
            'selectedCategory',
            'totalCharacters',
            'allegiances',
            'search',
            'categoryId',
            'allegiance'
        ));
    }

    /**
     * Tampilkan Detail Lengkap Tokoh Wayang
     */
    public function show(WayangCharacter $character)
    {
        $character->load('category');

        // Tokoh terkait dalam kategori yang sama
        $relatedCharacters = WayangCharacter::where('category_id', $character->category_id)
            ->where('id', '!=', $character->id)
            ->take(4)
            ->get();

        return view('wayang.show', compact('character', 'relatedCharacters'));
    }

    /**
     * Form Tambah Tokoh Wayang Baru (Hanya Admin)
     */
    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');
        $categories = WayangCategory::orderBy('name')->get();
        return view('wayang.create', compact('categories'));
    }

    /**
     * Simpan Tokoh Wayang Baru (Hanya Admin)
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');

        $validated = $request->validate([
            'name'             => 'required|string|max:150',
            'category_id'      => 'nullable|exists:wayang_categories,id',
            'other_names'      => 'nullable|string',
            'gender'           => 'nullable|string|max:30',
            'role'             => 'nullable|string',
            'character_traits' => 'nullable|string',
            'weapon'           => 'nullable|string',
            'family'           => 'nullable|string',
            'allegiance'       => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'story'            => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('wayang/custom', 'public');
            $validated['image_path'] = $path;
        }
        unset($validated['image']);

        $character = WayangCharacter::create($validated);

        return redirect()->route('wayang.show', $character)->with('success', "Tokoh wayang '{$character->name}' berhasil ditambahkan!");
    }

    /**
     * Form Edit Tokoh Wayang (Hanya Admin)
     */
    public function edit(WayangCharacter $character)
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');
        $categories = WayangCategory::orderBy('name')->get();
        return view('wayang.edit', compact('character', 'categories'));
    }

    /**
     * Update Data Tokoh Wayang (Hanya Admin)
     */
    public function update(Request $request, WayangCharacter $character)
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');

        $validated = $request->validate([
            'name'             => 'required|string|max:150',
            'category_id'      => 'nullable|exists:wayang_categories,id',
            'other_names'      => 'nullable|string',
            'gender'           => 'nullable|string|max:30',
            'role'             => 'nullable|string',
            'character_traits' => 'nullable|string',
            'weapon'           => 'nullable|string',
            'family'           => 'nullable|string',
            'allegiance'       => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'story'            => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($character->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($character->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($character->image_path);
            }
            $path = $request->file('image')->store('wayang/custom', 'public');
            $validated['image_path'] = $path;
        }
        unset($validated['image']);

        $character->update($validated);

        return redirect()->route('wayang.show', $character)->with('success', "Data tokoh '{$character->name}' berhasil diperbarui!");
    }

    /**
     * Hapus Tokoh Wayang (Hanya Admin)
     */
    public function destroy(WayangCharacter $character)
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');

        $name = $character->name;
        if ($character->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($character->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($character->image_path);
        }
        $character->delete();

        return redirect()->route('wayang.index')->with('success', "Tokoh wayang '{$name}' berhasil dihapus.");
    }
}
