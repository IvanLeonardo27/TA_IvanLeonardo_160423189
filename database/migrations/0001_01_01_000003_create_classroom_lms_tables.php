<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. classrooms
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('subject', 100)->nullable();
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
            $table->string('banner_color', 30)->default('#16402E');
            $table->string('banner_icon', 50)->default('fa-book');
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->json('week_titles')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. classroom_members
        Schema::create('classroom_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['teacher', 'student'])->default('student');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('out_at')->nullable();
            $table->timestamps();

            $table->unique(['classroom_id', 'user_id']);
        });

        // 3. classroom_posts
        Schema::create('classroom_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['announcement', 'material', 'assignment', 'quiz'])->default('announcement');
            $table->string('title', 200)->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->integer('week_number')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. classroom_post_attachments
        Schema::create('classroom_post_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->onDelete('cascade');
            $table->string('original_name', 255);
            $table->string('file_path', 255);
            $table->bigInteger('file_size')->default(0);
            $table->string('mime_type', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. classroom_comments
        Schema::create('classroom_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. classroom_assignments
        Schema::create('classroom_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->onDelete('cascade');
            $table->timestamp('due_date')->nullable();
            $table->integer('max_score')->default(100);
            $table->text('instructions')->nullable();
            $table->softDeletes();
        });

        // 7. classroom_submissions
        Schema::create('classroom_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('classroom_assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('file_path', 255)->nullable();
            $table->string('original_filename', 255)->nullable();
            $table->text('notes')->nullable();
            $table->integer('score')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
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
