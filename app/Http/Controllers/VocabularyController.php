<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use App\Models\VocabularyExample;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Halaman Utama Kamus Kosakata (Single Page + Filter Kategori + Search + Load More / Pagination)
     */
    public function index(Request $request)
    {
        // Urutkan kosakata berdasarkan Abjad (A-Z) Bahasa Indonesia
        $query = Vocabulary::with(['examples', 'categoryObj'])->orderBy('indonesian_word', 'asc');

        // Filter berdasarkan kata kunci pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('indonesian_word', 'like', "%{$search}%")
                  ->orWhere('javanese_ngoko', 'like', "%{$search}%")
                  ->orWhere('javanese_krama', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori yang dipilih dari dropdown search bar
        $selectedCategory = null;
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            $selectedCategory = VocabularyCategory::find($request->category_id);
        }

        // Default 15 data per halaman untuk performa ringan
        $perPage = 15;
        $vocabularies = $query->paginate($perPage);

        // Jika request via AJAX (Tombol "Tampilkan Lebih Banyak / Load More")
        if ($request->ajax()) {
            return response()->json([
                'html' => view('student.kosakata._vocab_items', compact('vocabularies'))->render(),
                'next_page_url' => $vocabularies->nextPageUrl(),
                'has_more' => $vocabularies->hasMorePages(),
                'current_count' => $vocabularies->count(),
                'total' => $vocabularies->total(),
            ]);
        }

        // Ambil semua kategori untuk dropdown filter di search bar
        $categories = VocabularyCategory::withCount('vocabularies')
            ->orderBy('name')
            ->get();

        return view('student.kosakata.index', compact('vocabularies', 'categories', 'selectedCategory'));
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
