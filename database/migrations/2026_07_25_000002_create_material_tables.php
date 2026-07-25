<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 5. material_categories
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 6. materials
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('material_categories')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });

        // 7. material_sections
        Schema::create('material_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('order_number')->default(1);
            $table->timestamps();
        });

        // 8. material_resources
        Schema::create('material_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('material_sections')->cascadeOnDelete();
            $table->enum('resource_type', ['video', 'pdf', 'audio', 'image', 'text', 'link']);
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // bytes
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('duration')->nullable(); // seconds for video/audio
            $table->timestamps();
        });

        // 9. material_tags
        Schema::create('material_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        // 10. material_tag_details
        Schema::create('material_tag_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('material_tags')->cascadeOnDelete();
            $table->unique(['material_id', 'tag_id']);
        });

        // 11. material_views
        Schema::create('material_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->timestamp('opened_at')->useCurrent();
            $table->unsignedInteger('duration')->nullable(); // seconds
        });

        // 12. material_bookmarks
        Schema::create('material_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['student_id', 'material_id']);
        });

        // 32. material_progress
        Schema::create('material_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->unsignedTinyInteger('percentage')->default(0);
            $table->boolean('completed')->default(false);
            $table->unique(['student_id', 'material_id']);
        });

        // 31. learning_progress (global per student)
        Schema::create('learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('percentage')->default(0);
            $table->unique(['student_id']);
        });

        // 33. daily_learning_logs
        Schema::create('daily_learning_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedSmallInteger('minutes')->default(0);
            $table->unique(['student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_learning_logs');
        Schema::dropIfExists('learning_progress');
        Schema::dropIfExists('material_progress');
        Schema::dropIfExists('material_bookmarks');
        Schema::dropIfExists('material_views');
        Schema::dropIfExists('material_tag_details');
        Schema::dropIfExists('material_tags');
        Schema::dropIfExists('material_resources');
        Schema::dropIfExists('material_sections');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('material_categories');
    }
};
