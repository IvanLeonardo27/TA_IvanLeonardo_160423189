<?php

namespace App\Http\Controllers;

use App\Models\QuizSet;
use App\Models\VocabCategory;
use App\Models\VocabWord;
use Illuminate\Http\Request;

class CustomerPageController extends Controller
{
    public function index(Request $request)
    {
        $categories = VocabCategory::query()
            ->with(['words' => function ($q) {
                $q->where('is_published', true)->orderBy('indo');
            }])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $dataKamus = [];
        $kamusTabs = [];

        foreach ($categories as $category) {
            $kamusTabs[] = [
                'slug' => $category->slug,
                'label' => $category->name,
            ];

            $dataKamus[$category->slug] = $category->words
                ->map(fn($w) => [
                    'jawa' => $w->jawa,
                    'indo' => $w->indo,
                    'emoji' => $w->emoji,
                ])
                ->values();
        }

        $uncategorized = VocabWord::query()
            ->where('is_published', true)
            ->whereNull('vocab_category_id')
            ->orderBy('indo')
            ->get(['indo', 'jawa', 'emoji']);

        if ($uncategorized->isNotEmpty()) {
            $kamusTabs[] = [
                'slug' => 'lainnya',
                'label' => 'Lainnya',
            ];

            $dataKamus['lainnya'] = $uncategorized
                ->map(fn($w) => [
                    'jawa' => $w->jawa,
                    'indo' => $w->indo,
                    'emoji' => $w->emoji,
                ])
                ->values();
        }

        $defaultKamusSlug = collect($kamusTabs)->firstWhere('slug', 'angka')['slug']
            ?? ($kamusTabs[0]['slug'] ?? 'lainnya');

        $quizSet = QuizSet::query()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->first();

        $kuisData = [];
        if ($quizSet) {
            $questionsQuery = $quizSet->questions()
                ->where('is_active', true)
                ->where('status', 'published');

            if ($quizSet->randomize_questions ?? true) {
                $questionsQuery->inRandomOrder();
            } else {
                $questionsQuery->orderBy('id');
            }

            $questions = $questionsQuery
                ->limit(5)
                ->get(['id', 'question', 'options', 'correct_index']);

            $kuisData = $questions
                ->map(fn($q) => [
                    'id' => $q->id,
                    'q' => $q->question,
                    'a' => $q->options,
                    'correct' => $q->correct_index,
                ])
                ->values()
                ->all();
        }

        return view('customer.index', [
            'dataKamus' => $dataKamus,
            'kamusTabs' => $kamusTabs,
            'defaultKamusSlug' => $defaultKamusSlug,
            'kuisData' => $kuisData,
            'quizSetId' => $quizSet?->id,
        ]);
    }
}
