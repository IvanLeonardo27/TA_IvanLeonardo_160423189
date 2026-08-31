<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. classrooms
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('code', 12)->unique(); // Kode gabung kelas, contoh: JW5A-26
            $table->string('banner_color', 7)->default('#1F4D3A'); // hex color
            $table->string('banner_icon')->default('graduation-cap'); // FontAwesome icon name
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps();
        });

        // 2. classroom_members
        Schema::create('classroom_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['student', 'co_teacher'])->default('student');
            $table->timestamp('joined_at')->useCurrent();
            $table->unique(['classroom_id', 'user_id']);
        });

        // 3. classroom_posts (pengumuman, materi, tugas)
        Schema::create('classroom_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['announcement', 'material', 'assignment'])->default('announcement');
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        // 4. classroom_post_attachments
        Schema::create('classroom_post_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->cascadeOnDelete();
            $table->string('original_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable(); // bytes
            $table->string('mime_type')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 5. classroom_comments
        Schema::create('classroom_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment');
            $table->timestamps();
        });

        // 6. classroom_assignments (detail tugas, terkait classroom_posts)
        Schema::create('classroom_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->unique()->constrained('classroom_posts')->cascadeOnDelete();
            $table->foreignId('material_id')->nullable()->constrained('materials')->nullOnDelete();
            $table->dateTime('due_date')->nullable();
            $table->unsignedSmallInteger('max_score')->default(100);
            $table->text('instructions')->nullable();
        });

        // 7. classroom_submissions (pengumpulan tugas siswa)
        Schema::create('classroom_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('classroom_assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('original_name')->nullable();
            $table->string('file_path')->nullable();
            $table->text('note')->nullable(); // catatan dari siswa
            $table->timestamp('submitted_at')->useCurrent();
            $table->unsignedSmallInteger('score')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->enum('status', ['submitted', 'graded', 'returned'])->default('submitted');
            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_submissions');
        Schema::dropIfExists('classroom_assignments');
        Schema::dropIfExists('classroom_comments');
        Schema::dropIfExists('classroom_post_attachments');
        Schema::dropIfExists('classroom_posts');
        Schema::dropIfExists('classroom_members');
        Schema::dropIfExists('classrooms');
    }
};
