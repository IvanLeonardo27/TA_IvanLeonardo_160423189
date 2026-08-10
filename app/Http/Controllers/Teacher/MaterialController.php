<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category')->where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('teacher.materials.index', compact('materials'));
    }

    public function create()
    {
        $categories = MaterialCategory::all();
        return view('teacher.materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:material_categories,id',
            'type' => 'required|in:general,unggah_ungguh,sastra_jawa,aksara_jawa',
            'description' => 'nullable|string',
            // unggah_ungguh fields
            'context_scenario' => 'nullable|string|max:255',
            'ngoko_text' => 'nullable|required_if:type,unggah_ungguh|string',
            'krama_text' => 'nullable|required_if:type,unggah_ungguh|string',
            'indonesian_text' => 'nullable|required_if:type,unggah_ungguh|string',
            // sastra_jawa fields
            'author' => 'nullable|string|max:255',
            'genre' => 'nullable|required_if:type,sastra_jawa|string|max:255',
            'content' => 'nullable|required_if:type,sastra_jawa|string',
        ]);

        DB::beginTransaction();
        try {
            $material = Material::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'type' => $request->type,
                'description' => $request->description,
                'teacher_id' => auth()->id(),
                'status' => 'published',
            ]);

            if ($request->type === 'unggah_ungguh') {
                $material->unggahUngguhBasas()->create([
                    'context_scenario' => $request->context_scenario,
                    'ngoko_text' => $request->ngoko_text,
                    'krama_text' => $request->krama_text,
                    'indonesian_text' => $request->indonesian_text,
                ]);
            } elseif ($request->type === 'sastra_jawa') {
                $material->sastraJawas()->create([
                    'author' => $request->author,
                    'genre' => $request->genre,
                    'content' => $request->content,
                ]);
            }

            DB::commit();
            return redirect()->route('teacher.materials.index')->with('success', 'Materi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Material $material)
    {
        $material->load(['category', 'unggahUngguhBasas', 'sastraJawas', 'attachments']);
        return view('teacher.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $categories = MaterialCategory::all();
        $material->load(['unggahUngguhBasas', 'sastraJawas']);
        return view('teacher.materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:material_categories,id',
            'description' => 'nullable|string',
            // unggah_ungguh fields
            'context_scenario' => 'nullable|string|max:255',
            'ngoko_text' => 'nullable|required_if:type,unggah_ungguh|string',
            'krama_text' => 'nullable|required_if:type,unggah_ungguh|string',
            'indonesian_text' => 'nullable|required_if:type,unggah_ungguh|string',
            // sastra_jawa fields
            'author' => 'nullable|string|max:255',
            'genre' => 'nullable|required_if:type,sastra_jawa|string|max:255',
            'content' => 'nullable|required_if:type,sastra_jawa|string',
        ]);

        DB::beginTransaction();
        try {
            $material->update([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);

            if ($material->type === 'unggah_ungguh') {
                $material->unggahUngguhBasas()->updateOrCreate(
                    ['material_id' => $material->id],
                    [
                        'context_scenario' => $request->context_scenario,
                        'ngoko_text' => $request->ngoko_text,
                        'krama_text' => $request->krama_text,
                        'indonesian_text' => $request->indonesian_text,
                    ]
                );
            } elseif ($material->type === 'sastra_jawa') {
                $material->sastraJawas()->updateOrCreate(
                    ['material_id' => $material->id],
                    [
                        'author' => $request->author,
                        'genre' => $request->genre,
                        'content' => $request->content,
                    ]
                );
            }

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
