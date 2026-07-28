<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomPost;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomPostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassroomPostController extends Controller
{
    /** Form buat post (pengumuman / materi / tugas) */
    public function create(Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);
        return view('teacher.classroom.post.create', compact('classroom'));
    }

    /** Simpan post baru */
    public function store(Request $request, Classroom $classroom)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        $validated = $request->validate([
            'type'         => 'required|in:announcement,material,assignment',
            'title'        => 'nullable|string|max:200',
            'body'         => 'nullable|string',
            'is_pinned'    => 'boolean',
            'files.*'      => 'nullable|file|max:20480', // 20MB per file
            // Assignment fields
            'due_date'     => 'nullable|date|after:now',
            'max_score'    => 'nullable|integer|min:0|max:1000',
            'instructions' => 'nullable|string',
        ]);

        $post = ClassroomPost::create([
            'classroom_id' => $classroom->id,
            'author_id'    => Auth::id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'] ?? null,
            'body'         => $validated['body'] ?? null,
            'is_pinned'    => $request->boolean('is_pinned'),
        ]);

        // Upload lampiran
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store("classrooms/{$classroom->id}/posts/{$post->id}", 'public');
                ClassroomPostAttachment::create([
                    'post_id'       => $post->id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path'     => $path,
                    'file_size'     => $file->getSize(),
                    'mime_type'     => $file->getMimeType(),
                ]);
            }
        }

        // Jika tipe tugas, simpan detail assignment
        if ($validated['type'] === 'assignment') {
            ClassroomAssignment::create([
                'post_id'      => $post->id,
                'due_date'     => $validated['due_date'] ?? null,
                'max_score'    => $validated['max_score'] ?? 100,
                'instructions' => $validated['instructions'] ?? null,
            ]);
        }

        return redirect()->route('teacher.classroom.show', $classroom)
            ->with('success', 'Postingan berhasil dibuat!');
    }

    /** Hapus post */
    public function destroy(Classroom $classroom, ClassroomPost $post)
    {
        abort_if($classroom->teacher_id !== Auth::id(), 403);

        // Hapus file lampiran dari storage
        foreach ($post->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $post->delete();

        return back()->with('success', 'Postingan berhasil dihapus.');
    }
}
