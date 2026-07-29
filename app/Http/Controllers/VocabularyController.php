<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use App\Models\VocabularyExample;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Halaman Utama: Daftar Semua Kategori Kosakata (Grid View)
     */
    public function categories(Request $request)
    {
        $query = VocabularyCategory::withCount('vocabularies')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $categories = $query->paginate(18);

        return view('student.kosakata.categories', compact('categories'));
    }

    /**
     * Halaman Kosakata Berdasarkan Kategori yang Dipilih / Semua Kosakata
     */
    public function index(Request $request, $categoryId = null)
    {
        $query = Vocabulary::with(['examples', 'categoryObj'])->orderBy('indonesian_word', 'asc');

        $activeCategory = null;
        if ($categoryId) {
            $activeCategory = VocabularyCategory::findOrFail($categoryId);
            $query->where('category_id', $categoryId);
        } elseif ($request->filled('category_id')) {
            $activeCategory = VocabularyCategory::find($request->category_id);
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('indonesian_word', 'like', "%{$search}%")
                  ->orWhere('javanese_ngoko', 'like', "%{$search}%")
                  ->orWhere('javanese_krama', 'like', "%{$search}%");
            });
        }

        $vocabularies = $query->paginate(20);
        $categories = VocabularyCategory::orderBy('name')->get();

        return view('student.kosakata.index', compact('vocabularies', 'categories', 'activeCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'indonesian_word' => 'required|string|max:191',
            'javanese_ngoko'  => 'required|string|max:191',
            'javanese_krama'  => 'required|string|max:191',
            'category_id'     => 'nullable|exists:vocabulary_categories,id',
            'example_indonesian' => 'nullable|string',
            'example_ngoko'      => 'nullable|string',
            'example_krama'      => 'nullable|string',
        ]);

        $categoryName = null;
        if ($request->filled('category_id')) {
            $cat = VocabularyCategory::find($request->category_id);
            if ($cat) {
                $categoryName = $cat->name;
            }
        }

        $vocab = Vocabulary::create([
            'indonesian_word' => $request->indonesian_word,
            'javanese_ngoko'  => $request->javanese_ngoko,
            'javanese_krama'  => $request->javanese_krama,
            'category_id'     => $request->category_id,
            'category'        => $categoryName,
        ]);

        if ($request->filled('example_indonesian') || $request->filled('example_ngoko') || $request->filled('example_krama')) {
            VocabularyExample::create([
                'vocabulary_id'       => $vocab->id,
                'indonesian_sentence' => $request->example_indonesian,
                'ngoko_sentence'      => $request->example_ngoko,
                'krama_sentence'      => $request->example_krama,
                'javanese_sentence'   => $request->example_ngoko ?: $request->example_krama,
            ]);
        }

        return redirect()->back()->with('success', 'Kosakata baru berhasil ditambahkan!');
    }
}
