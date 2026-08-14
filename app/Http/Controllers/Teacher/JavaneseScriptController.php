<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\JavaneseScriptCategory;
use App\Models\JavaneseScriptDetail;
use App\Models\JavaneseScriptExample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JavaneseScriptController extends Controller
{
    /**
     * Tampilkan daftar kelola Aksara Jawa untuk Pengajar.
     */
    public function index(Request $request)
    {
        $categories = JavaneseScriptCategory::all();
        $query = JavaneseScriptDetail::with(['category', 'examples']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('latin', 'like', "%{$search}%")
                  ->orWhere('pronunciation', 'like', "%{$search}%");
            });
        }

        $scripts = $query->latest('id')->paginate(12)->withQueryString();

        return view('teacher.javanese-script.index', compact('categories', 'scripts'));
    }

    /**
     * Form tambah Aksara Jawa baru.
     */
    public function create()
    {
        $categories = JavaneseScriptCategory::all();
        return view('teacher.javanese-script.create', compact('categories'));
    }

    /**
     * Simpan data Aksara Jawa baru beserta contoh kalimatnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:javanese_script_categories,id',
            'name' => 'required|string|max:255',
            'latin' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:svg,png,jpg,jpeg,webp|max:2048',
            // Contoh kalimat
            'javanese_script_text' => 'nullable|string',
            'javanese_latin_text' => 'nullable|string',
            'indonesian_text' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('aksara-jawa/custom', 'public');
            }

            $script = JavaneseScriptDetail::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'latin' => $request->latin,
                'pronunciation' => $request->pronunciation,
                'description' => $request->description,
                'image_path' => $imagePath,
            ]);

            if ($request->filled('javanese_script_text') || $request->filled('javanese_latin_text') || $request->filled('indonesian_text')) {
                JavaneseScriptExample::create([
                    'script_detail_id' => $script->id,
                    'javanese_script_text' => $request->javanese_script_text ?? $script->name,
                    'javanese_latin_text' => $request->javanese_latin_text ?? $script->latin,
                    'indonesian_text' => $request->indonesian_text ?? 'Contoh kalimat aksara ' . $script->name,
                ]);
            }

            DB::commit();
            return redirect()->route('teacher.javanese-script.index')->with('success', 'Aksara Jawa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan aksara: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form edit data Aksara Jawa & contoh kalimatnya.
     */
    public function edit($id)
    {
        $script = JavaneseScriptDetail::with(['category', 'examples'])->findOrFail($id);
        $categories = JavaneseScriptCategory::all();
        $example = $script->examples->first();

        return view('teacher.javanese-script.edit', compact('script', 'categories', 'example'));
    }

    /**
     * Update data Aksara Jawa & contoh kalimat.
     */
    public function update(Request $request, $id)
    {
        $script = JavaneseScriptDetail::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:javanese_script_categories,id',
            'name' => 'required|string|max:255',
            'latin' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:svg,png,jpg,jpeg,webp|max:2048',
            // Contoh kalimat
            'javanese_script_text' => 'nullable|string',
            'javanese_latin_text' => 'nullable|string',
            'indonesian_text' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'latin' => $request->latin,
                'pronunciation' => $request->pronunciation,
                'description' => $request->description,
            ];

            if ($request->hasFile('image')) {
                if ($script->image_path && Storage::disk('public')->exists($script->image_path)) {
                    Storage::disk('public')->delete($script->image_path);
                }
                $data['image_path'] = $request->file('image')->store('aksara-jawa/custom', 'public');
            }

            $script->update($data);

            if ($request->filled('javanese_script_text') || $request->filled('javanese_latin_text') || $request->filled('indonesian_text')) {
                JavaneseScriptExample::updateOrCreate(
                    ['script_detail_id' => $script->id],
                    [
                        'javanese_script_text' => $request->javanese_script_text ?? $script->name,
                        'javanese_latin_text' => $request->javanese_latin_text ?? $script->latin,
                        'indonesian_text' => $request->indonesian_text ?? 'Contoh kalimat aksara ' . $script->name,
                    ]
                );
            }

            DB::commit();
            return redirect()->route('teacher.javanese-script.index')->with('success', 'Data Aksara Jawa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui aksara: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus data Aksara Jawa.
     */
    public function destroy($id)
    {
        $script = JavaneseScriptDetail::findOrFail($id);

        try {
            if ($script->image_path && Storage::disk('public')->exists($script->image_path)) {
                Storage::disk('public')->delete($script->image_path);
            }

            $script->delete();
            return redirect()->route('teacher.javanese-script.index')->with('success', 'Aksara Jawa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus aksara: ' . $e->getMessage());
        }
    }
}
