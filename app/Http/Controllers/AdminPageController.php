<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizSet;
use App\Models\VocabCategory;
use App\Models\VocabWord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{
    public function index(Request $request)
    {
        $since = Carbon::now()->subDays(7);

        $editingWord = null;
        if ($request->filled('edit')) {
            $editId = (int) $request->query('edit');
            if ($editId > 0) {
                $editingWord = VocabWord::query()
                    ->with('category:id,name,slug')
                    ->find($editId);
            }
        }

        $stats = [
            'total_kosakata' => VocabWord::query()->where('is_published', true)->count(),
            'total_soal' => QuizQuestion::query()->where('is_active', true)->count(),
            'siswa_aktif' => QuizAttempt::query()->where('taken_at', '>=', $since)->distinct('player_name')->count('player_name'),
            'rata_rata_skor' => (float) (QuizAttempt::query()->avg('score') ?? 0),
        ];

        $recentActivities = AdminActivity::query()
            ->latest()
            ->limit(5)
            ->get(['icon', 'description', 'created_at']);

        $topStudentsThisWeek = QuizAttempt::query()
            ->where('taken_at', '>=', $since)
            ->select('player_name', DB::raw('MAX(score) as best_score'))
            ->groupBy('player_name')
            ->orderByDesc('best_score')
            ->limit(5)
            ->get();

        $vocabWords = VocabWord::query()
            ->with('category:id,name,slug')
            ->orderByDesc('id')
            ->limit(20)
            ->get();

        $vocabCategories = VocabCategory::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $quizSets = QuizSet::query()
            ->withCount(['questions as questions_count' => fn($q) => $q->where('is_active', true)])
            ->withMax(['questions as last_question_updated_at' => fn($q) => $q->where('is_active', true)], 'updated_at')
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->get();

        $recentAttempts = QuizAttempt::query()
            ->with('quizSet:id,title')
            ->orderByDesc('taken_at')
            ->limit(10)
            ->get(['quiz_set_id', 'player_name', 'score', 'taken_at']);

        return view('admin.index', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'topStudentsThisWeek' => $topStudentsThisWeek,
            'vocabWords' => $vocabWords,
            'vocabCategories' => $vocabCategories,
            'editingWord' => $editingWord,
            'quizSets' => $quizSets,
            'recentAttempts' => $recentAttempts,
        ]);
    }

    public function storeVocab(Request $request)
    {
        $data = $request->validate([
            'indo' => ['required', 'string', 'max:120'],
            'jawa' => ['required', 'string', 'max:120'],
            'emoji' => ['nullable', 'string', 'max:16'],
            'vocab_category_id' => ['nullable', 'integer', 'exists:vocab_categories,id'],
        ]);

        $isPublished = $request->boolean('is_published');
        $data['is_published'] = $isPublished;
        $data['status'] = $isPublished ? 'published' : 'draft';
        $data['created_by'] = $request->user()?->id;

        if ($isPublished) {
            $data['published_at'] = now();
            $data['published_by'] = $request->user()?->id;
        }

        $word = VocabWord::query()->create($data);

        AdminActivity::query()->create([
            'actor_id' => $request->user()?->id,
            'icon' => '📝',
            'description' => 'Menambah kosakata baru "' . $word->indo . '"',
            'action' => 'vocab.created',
            'subject_type' => VocabWord::class,
            'subject_id' => $word->id,
            'properties' => [
                'status' => $word->status,
            ],
        ]);

        return redirect()
            ->route('admin.home', ['view' => 'kosakata'])
            ->with('status', 'Kosakata berhasil ditambahkan.');
    }

    public function updateVocab(Request $request, VocabWord $vocabWord)
    {
        $data = $request->validate([
            'indo' => ['required', 'string', 'max:120'],
            'jawa' => ['required', 'string', 'max:120'],
            'emoji' => ['nullable', 'string', 'max:16'],
            'vocab_category_id' => ['nullable', 'integer', 'exists:vocab_categories,id'],
        ]);

        $isPublished = $request->boolean('is_published');
        $data['is_published'] = $isPublished;
        $data['status'] = $isPublished ? 'published' : 'draft';

        if ($isPublished && !$vocabWord->published_at) {
            $data['published_at'] = now();
            $data['published_by'] = $request->user()?->id;
        }

        $vocabWord->fill($data);
        $vocabWord->save();

        AdminActivity::query()->create([
            'actor_id' => $request->user()?->id,
            'icon' => '✏️',
            'description' => 'Mengubah kosakata "' . $vocabWord->indo . '"',
            'action' => 'vocab.updated',
            'subject_type' => VocabWord::class,
            'subject_id' => $vocabWord->id,
            'properties' => [
                'status' => $vocabWord->status,
            ],
        ]);

        return redirect()
            ->route('admin.home', ['view' => 'kosakata'])
            ->with('status', 'Kosakata berhasil diperbarui.');
    }

    public function destroyVocab(Request $request, VocabWord $vocabWord)
    {
        $indo = $vocabWord->indo;
        $id = $vocabWord->id;
        $vocabWord->delete();

        AdminActivity::query()->create([
            'actor_id' => $request->user()?->id,
            'icon' => '🗑️',
            'description' => 'Menghapus kosakata "' . $indo . '"',
            'action' => 'vocab.deleted',
            'subject_type' => VocabWord::class,
            'subject_id' => $id,
        ]);

        return redirect()
            ->route('admin.home', ['view' => 'kosakata'])
            ->with('status', 'Kosakata berhasil dihapus.');
    }
}
