<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 13. vocabulary_categories
        Schema::create('vocabulary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });

        // 14. vocabularies
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('vocabulary_categories')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('javanese_word');
            $table->string('indonesian_word');
            $table->enum('level', ['ngoko', 'krama', 'krama_inggil'])->default('ngoko');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 15. vocabulary_examples
        Schema::create('vocabulary_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->text('javanese_sentence');
            $table->text('indonesian_sentence');
            $table->timestamp('created_at')->useCurrent();
        });

        // 16. vocabulary_views
        Schema::create('vocabulary_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->timestamp('opened_at')->useCurrent();
        });

        // 17. vocabulary_bookmarks
        Schema::create('vocabulary_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->unique(['student_id', 'vocabulary_id']);
        });

        // 18. vocabulary_progress
        Schema::create('vocabulary_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->boolean('is_mastered')->default(false);
            $table->timestamp('last_access')->nullable();
            $table->unique(['student_id', 'vocabulary_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocabulary_progress');
        Schema::dropIfExists('vocabulary_bookmarks');
        Schema::dropIfExists('vocabulary_views');
        Schema::dropIfExists('vocabulary_examples');
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('vocabulary_categories');
    }
};
