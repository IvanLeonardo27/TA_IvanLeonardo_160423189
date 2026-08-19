<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MaterialController extends Controller
{
    public function index()
    {
        Gate::authorize('teacher');
        $materials = Material::with('category')->where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('teacher.materials.index', compact('materials'));
    }

    public function create()
    {
        Gate::authorize('teacher');
        $categories = MaterialCategory::all();
        return view('teacher.materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('teacher');
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:material_categories,id',
            'type'        => 'required|in:general,sastra_jawa,aksara_jawa',
            'description' => 'nullable|string',
            // sastra_jawa fields
            'author'      => 'nullable|string|max:255',
            'genre'       => 'nullable|required_if:type,sastra_jawa|string|max:255',
            'content'     => 'nullable|required_if:type,sastra_jawa|string',
        ]);

        DB::beginTransaction();
        try {
            $material = Material::create([
                'title'       => $request->title,
                'category_id' => $request->category_id,
                'type'        => $request->type,
                'description' => $request->description,
                'teacher_id'  => auth()->id(),
                'status'      => 'published',
            ]);

            DB::commit();
            return redirect()->route('teacher.materials.index')->with('success', 'Materi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Material $material)
    {
        $material->load(['category', 'attachments']);
        return view('teacher.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $categories = MaterialCategory::all();
        return view('teacher.materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:material_categories,id',
            'description' => 'nullable|string',
            // sastra_jawa fields
            'author'      => 'nullable|string|max:255',
            'genre'       => 'nullable|required_if:type,sastra_jawa|string|max:255',
            'content'     => 'nullable|required_if:type,sastra_jawa|string',
        ]);

        DB::beginTransaction();
        try {
            $material->update([
                'title'       => $request->title,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('teacher.materials.index')->with('success', 'Materi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('teacher.materials.index')->with('success', 'Materi berhasil dihapus.');
    }
}
