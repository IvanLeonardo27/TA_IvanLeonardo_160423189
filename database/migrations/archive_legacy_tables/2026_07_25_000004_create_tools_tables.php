<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 19. translations
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->text('input_text');
            $table->text('result_text');
            $table->string('source_language', 10); // 'id' or 'jv'
            $table->string('target_language', 10); // 'id' or 'jv'
            $table->timestamp('created_at')->useCurrent();
        });

        // 20. translation_favorites
        Schema::create('translation_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_id')->constrained('translations')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['translation_id', 'student_id']);
        });

        // 21. tts_histories
        Schema::create('tts_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->text('text');
            $table->string('language', 10); // 'id-ID', 'jv-ID', etc.
            $table->string('voice')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 22. tts_settings
        Schema::create('tts_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('voice_name')->nullable();
            $table->decimal('speed', 3, 1)->default(1.0); // 0.1 - 10
            $table->decimal('pitch', 3, 1)->default(1.0); // 0 - 2
            $table->decimal('volume', 3, 1)->default(1.0); // 0 - 1
            $table->unique(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tts_settings');
        Schema::dropIfExists('tts_histories');
        Schema::dropIfExists('translation_favorites');
        Schema::dropIfExists('translations');
    }
};
