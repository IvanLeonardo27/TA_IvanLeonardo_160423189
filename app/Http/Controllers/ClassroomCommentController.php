<?php

namespace App\Http\Controllers;

use App\Models\ClassroomComment;
use App\Models\ClassroomMember;
use App\Models\ClassroomPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomCommentController extends Controller
{
    /** Simpan komentar baru di sebuah post */
    public function store(Request $request, ClassroomPost $post)
    {
        $classroom = $post->classroom;

        // Cek apakah user adalah anggota atau pengajar kelas
        $isMember  = ClassroomMember::where('classroom_id', $classroom->id)->where('user_id', Auth::id())->exists();
        $isTeacher = $classroom->teacher_id === Auth::id();

        abort_unless($isMember || $isTeacher, 403);

        $request->validate(['comment' => 'required|string|max:1000']);

        ClassroomComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /** Hapus komentar (hanya milik sendiri atau pengajar) */
    public function destroy(ClassroomComment $comment)
    {
        $isOwner   = $comment->user_id === Auth::id();
        $isTeacher = $comment->post->classroom->teacher_id === Auth::id();

        abort_unless($isOwner || $isTeacher, 403);

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
