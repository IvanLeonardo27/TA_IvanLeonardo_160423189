<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\JavaneseScriptDetail;
use App\Models\MacapatDetail;
use App\Models\Vocabulary;
use App\Models\WayangCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Pemetaan nama tipe alias ke nama Class Model Laravel
     */
    protected array $modelMapping = [
        'wayang'  => WayangCharacter::class,
        'macapat' => MacapatDetail::class,
        'aksara'  => JavaneseScriptDetail::class,
        'vocab'   => Vocabulary::class,
    ];

    /**
     * Endpoint AJAX Toggle (Simpan / Hapus) Bookmark
     */
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:wayang,macapat,aksara,vocab'],
            'id'   => ['required', 'integer'],
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Silakan login terlebih dahulu.',
            ], 401);
        }

        $modelClass = $this->modelMapping[$validated['type']];
        $item = $modelClass::find($validated['id']);

        if (!$item) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Materi tidak ditemukan.',
            ], 404);
        }

        // Cek apakah siswa sudah bookmark item ini
        $existingBookmark = Bookmark::where('user_id', $user->id)
            ->where('bookmarkable_type', $modelClass)
            ->where('bookmarkable_id', $validated['id'])
            ->first();

        if ($existingBookmark) {
            // Jika sudah ada -> Hapus dari simpanan (Un-bookmark)
            $existingBookmark->delete();
            $totalCount = Bookmark::where('user_id', $user->id)->count();

            return response()->json([
                'status'      => 'success',
                'bookmarked'  => false,
                'total_count' => $totalCount,
                'message'     => 'Materi dihapus dari bookmark!',
            ]);
        } else {
            // Jika belum ada -> Tambahkan ke simpanan (Bookmark)
            Bookmark::create([
                'user_id'           => $user->id,
                'bookmarkable_type' => $modelClass,
                'bookmarkable_id'   => $validated['id'],
            ]);
            $totalCount = Bookmark::where('user_id', $user->id)->count();

            return response()->json([
                'status'      => 'success',
                'bookmarked'  => true,
                'total_count' => $totalCount,
                'message'     => 'Materi berhasil disimpan ke bookmark!',
            ]);
        }
    }


    /**
     * Menampilkan Halaman Daftar Simpanan (Bookmark) Siswa
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with('bookmarkable')
            ->latest()
            ->get();

        return view('student.bookmarks.index', compact('bookmarks'));
    }
}
