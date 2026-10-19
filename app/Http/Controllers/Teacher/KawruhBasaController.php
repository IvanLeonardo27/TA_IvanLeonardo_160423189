<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\KawruhBasaController as PublicKawruhBasaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class KawruhBasaController extends Controller
{
    /**
     * Tampilkan Halaman Manajemen Kawruh Basa untuk Guru / Admin
     */
    public function index(Request $request)
    {
        Gate::authorize('manage-materials');

        $activeCategory = $request->query('category', 'arane_kembang');
        $categories     = PublicKawruhBasaController::CATEGORIES;

        if (!array_key_exists($activeCategory, $categories)) {
            $activeCategory = 'arane_kembang';
        }

        $categoryMeta = $categories[$activeCategory];
        $modelClass   = $categoryMeta['model'];

        $search = $request->query('search');

        $query = $modelClass::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('javanese_term', 'like', "%{$search}%")
                  ->orWhere('indonesia_meaning', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('id', 'asc')->paginate(15)->withQueryString();

        $counts = [];
        $totalAll = 0;
        foreach ($categories as $key => $meta) {
            $count = $meta['model']::count();
            $counts[$key] = $count;
            $totalAll += $count;
        }

        return view('kawruh-basa.index', [
            'categories'     => $categories,
            'activeCategory' => $activeCategory,
            'categoryMeta'   => $categoryMeta,
            'items'          => $items,
            'counts'         => $counts,
            'totalAll'       => $totalAll,
            'search'         => $search,
            'isTeacherView'  => true,
        ]);
    }

    /**
     * Tambah Entri Kawruh Basa Baru
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-materials');

        $categories = PublicKawruhBasaController::CATEGORIES;

        $validated = $request->validate([
            'category'          => 'required|string|in:' . implode(',', array_keys($categories)),
            'javanese_term'     => 'required|string|max:150',
            'indonesia_meaning' => 'required|string',
        ]);

        $categoryKey = $validated['category'];
        $modelClass  = $categories[$categoryKey]['model'];

        $item = $modelClass::create([
            'javanese_term'     => $validated['javanese_term'],
            'indonesia_meaning' => $validated['indonesia_meaning'],
        ]);

        return redirect()
            ->route('kawruh-basa.index', ['category' => $categoryKey])
            ->with('success', "Data '{$item->javanese_term}' berhasil ditambahkan ke kategori {$categories[$categoryKey]['name']}!");
    }

    /**
     * Perbarui Entri Kawruh Basa
     */
    public function update(Request $request, string $category, int $id)
    {
        Gate::authorize('manage-materials');

        $categories = PublicKawruhBasaController::CATEGORIES;

        if (!array_key_exists($category, $categories)) {
            abort(404, 'Kategori tidak valid.');
        }

        $modelClass = $categories[$category]['model'];
        $item       = $modelClass::findOrFail($id);

        $validated = $request->validate([
            'javanese_term'     => 'required|string|max:150',
            'indonesia_meaning' => 'required|string',
        ]);

        $item->update($validated);

        return redirect()
            ->route('kawruh-basa.index', ['category' => $category])
            ->with('success', "Data '{$item->javanese_term}' berhasil diperbarui!");
    }

    /**
     * Hapus Entri Kawruh Basa
     */
    public function destroy(Request $request, string $category, int $id)
    {
        Gate::authorize('manage-materials');

        $categories = PublicKawruhBasaController::CATEGORIES;

        if (!array_key_exists($category, $categories)) {
            abort(404, 'Kategori tidak valid.');
        }

        $modelClass = $categories[$category]['model'];
        $item       = $modelClass::findOrFail($id);
        $term       = $item->javanese_term;

        $item->delete();

        return redirect()
            ->route('kawruh-basa.index', ['category' => $category])
            ->with('success', "Data '{$term}' berhasil dihapus.");
    }
}
