<?php

namespace App\Http\Controllers;

use App\Models\ClassroomComment;
use App\Models\ClassroomPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomCommentController extends Controller
{
    /** Simpan komentar baru di sebuah post */
    public function store(Request $request, ClassroomPost $post)
    {
        Gate::authorize('create', [ClassroomComment::class, $post]);

        $request->validate(['comment' => 'required|string|max:1000']);

        ClassroomComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'body'    => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /** Hapus komentar (hanya milik sendiri atau pengajar) */
    public function destroy(ClassroomComment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
