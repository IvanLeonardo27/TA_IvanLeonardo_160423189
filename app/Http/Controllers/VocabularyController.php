<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use App\Models\VocabularyExample;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index(Request $request)
    {
        $query = Vocabulary::with(['examples', 'categoryObj'])->orderBy('indonesian_word', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('indonesian_word', 'like', "%{$search}%")
                  ->orWhere('javanese_ngoko', 'like', "%{$search}%")
                  ->orWhere('javanese_krama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $vocabularies = $query->paginate(20);
        $categories = VocabularyCategory::orderBy('name')->get();

        return view('student.kosakata.index', compact('vocabularies', 'categories'));
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
