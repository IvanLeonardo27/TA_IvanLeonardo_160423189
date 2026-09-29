<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionBankController extends Controller
{
    /** Menampilkan daftar butir soal milik guru di Bank Soal */
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        $query = QuizQuestion::query();

        // Batasi hanya soal milik guru yang sedang login (kecuali admin)
        if (!Auth::user()->isAdmin()) {
            $query->where('teacher_id', $teacherId);
        }

        // Filter pencarian teks soal
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('question_text', 'like', "%{$search}%");
            });
        }

        // Filter kategori / topik
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $questions = $query->latest('id')->paginate(10)->withQueryString();

        // Kategori yang tersedia
        $categories = [
            'umum'          => 'Umum',
            'aksara-jawa'   => 'Aksara Jawa',
            'macapat'       => 'Tembang Macapat',
            'wayang'        => 'Pewayangan',
            'unggah-ungguh' => 'Unggah-Ungguh Basa',
        ];

        return view('teacher.question-bank.index', compact('questions', 'categories'));
    }

    /** Form tambah soal baru ke Bank Soal */
    public function create()
    {
        $categories = [
            'umum'          => 'Umum',
            'aksara-jawa'   => 'Aksara Jawa',
            'macapat'       => 'Tembang Macapat',
            'wayang'        => 'Pewayangan',
            'unggah-ungguh' => 'Unggah-Ungguh Basa',
        ];

        return view('teacher.question-bank.create', compact('categories'));
    }

    /** Menyimpan butir soal baru ke Bank Soal */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'    => 'required|string',
            'category'    => 'nullable|string|max:50',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string',
            'correct'     => 'nullable|string|max:5',
            'percentages' => 'nullable|array',
            'explanation' => 'nullable|string',
            'image'       => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $optionsRaw = $request->input('options', []);
        $pctsRaw    = $request->input('percentages', []);
        $correctKey = $request->input('correct', 'A');

        $optionsList   = [];
        $optionWeights = [];
        $correctIndex  = 0;
        $highestPct    = -1;
        $idx = 0;

        foreach ($optionsRaw as $letter => $text) {
            if ($text !== null && trim($text) !== '') {
                $optionsList[] = trim($text);
                $pct = isset($pctsRaw[$letter]) ? (int) $pctsRaw[$letter] : ($letter === $correctKey ? 100 : 0);
                $optionWeights[] = $pct;

                if ($pct > $highestPct) {
                    $highestPct = $pct;
                    $correctIndex = $idx;
                } elseif ($highestPct <= 0 && $letter === $correctKey) {
                    $correctIndex = $idx;
                }
                $idx++;
            }
        }

        if (count($optionsList) < 2) {
            return back()->withInput()->with('error', 'Soal pilihan ganda minimal harus memiliki 2 pilihan jawaban.');
        }

        // Upload gambar soal jika ada (hanya PNG, JPG, JPEG)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $ext = strtolower($imageFile->getClientOriginalExtension());
            if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                $imagePath = $imageFile->store('classroom/quiz-questions', 'public');
            }
        }

        QuizQuestion::create([
            'teacher_id'         => Auth::id(),
            'question'           => trim($validated['question']),
            'question_text'      => trim($validated['question']),
            'category'           => $validated['category'] ?? 'umum',
            'image_path'         => $imagePath,
            'options'            => $optionsList,
            'option_percentages' => $optionWeights,
            'correct_index'      => $correctIndex,
            'correct_answer'     => (string) $correctIndex,
            'points'             => 10,
            'is_active'          => true,
            'explanation'        => !empty($validated['explanation']) ? trim($validated['explanation']) : null,
        ]);

        return redirect()->route('teacher.question-bank.index')
            ->with('success', 'Butir soal baru berhasil disimpan ke Bank Soal Anda!');
    }

    /** Form edit butir soal di Bank Soal */
    public function edit(QuizQuestion $question)
    {
        // Pastikan hanya pemilik soal yang bisa mengedit
        if (!Auth::user()->isAdmin() && $question->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit soal ini.');
        }

        $categories = [
            'umum'          => 'Umum',
            'aksara-jawa'   => 'Aksara Jawa',
            'macapat'       => 'Tembang Macapat',
            'wayang'        => 'Pewayangan',
            'unggah-ungguh' => 'Unggah-Ungguh Basa',
        ];

        return view('teacher.question-bank.edit', compact('question', 'categories'));
    }

    /** Memperbarui butir soal di Bank Soal */
    public function update(Request $request, QuizQuestion $question)
    {
        if (!Auth::user()->isAdmin() && $question->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah soal ini.');
        }

        $validated = $request->validate([
            'question'    => 'required|string',
            'category'    => 'nullable|string|max:50',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string',
            'correct'     => 'nullable|string|max:5',
            'percentages' => 'nullable|array',
            'explanation' => 'nullable|string',
            'image'       => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $optionsRaw = $request->input('options', []);
        $pctsRaw    = $request->input('percentages', []);
        $correctKey = $request->input('correct', 'A');

        $optionsList   = [];
        $optionWeights = [];
        $correctIndex  = 0;
        $highestPct    = -1;
        $idx = 0;

        foreach ($optionsRaw as $letter => $text) {
            if ($text !== null && trim($text) !== '') {
                $optionsList[] = trim($text);
                $pct = isset($pctsRaw[$letter]) ? (int) $pctsRaw[$letter] : ($letter === $correctKey ? 100 : 0);
                $optionWeights[] = $pct;

                if ($pct > $highestPct) {
                    $highestPct = $pct;
                    $correctIndex = $idx;
                } elseif ($highestPct <= 0 && $letter === $correctKey) {
                    $correctIndex = $idx;
                }
                $idx++;
            }
        }

        if (count($optionsList) < 2) {
            return back()->withInput()->with('error', 'Soal pilihan ganda minimal harus memiliki 2 pilihan jawaban.');
        }

        $imagePath = $question->image_path;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $ext = strtolower($imageFile->getClientOriginalExtension());
            if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $imageFile->store('classroom/quiz-questions', 'public');
            }
        } elseif ($request->boolean('remove_image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = null;
        }

        $question->update([
            'question'           => trim($validated['question']),
            'question_text'      => trim($validated['question']),
            'category'           => $validated['category'] ?? 'umum',
            'image_path'         => $imagePath,
            'options'            => $optionsList,
            'option_percentages' => $optionWeights,
            'correct_index'      => $correctIndex,
            'correct_answer'     => (string) $correctIndex,
            'explanation'        => !empty($validated['explanation']) ? trim($validated['explanation']) : null,
        ]);

        return redirect()->route('teacher.question-bank.index')
            ->with('success', 'Butir soal di Bank Soal berhasil diperbarui!');
    }

    /** Menghapus butir soal dari Bank Soal */
    public function destroy(QuizQuestion $question)
    {
        if (!Auth::user()->isAdmin() && $question->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus soal ini.');
        }

        $question->delete();

        return redirect()->route('teacher.question-bank.index')
            ->with('success', 'Soal berhasil dihapus dari Bank Soal.');
    }

    /** Endpoint JSON untuk modal "Pilih dari Bank Soal" pada saat guru membuat kuis di kelas */
    public function apiList(Request $request)
    {
        $teacherId = Auth::id();
        $query = QuizQuestion::query();

        if (!Auth::user()->isAdmin()) {
            $query->where('teacher_id', $teacherId);
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('question_text', 'like', "%{$search}%");
            });
        }

        $questions = $query->latest('id')->get()->map(function($q) {
            return [
                'id'                 => $q->id,
                'question'           => $q->question,
                'category'           => $q->category,
                'image_path'         => $q->image_path ? asset('storage/' . $q->image_path) : null,
                'options'            => $q->options,
                'option_percentages' => $q->option_percentages,
                'correct_index'      => $q->correct_index,
                'explanation'        => $q->explanation,
                'created_at_fmt'     => $q->created_at ? $q->created_at->format('d M Y') : '-',
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $questions,
        ]);
    }
}
