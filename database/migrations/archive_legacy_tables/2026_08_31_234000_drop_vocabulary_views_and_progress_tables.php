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
        Schema::dropIfExists('vocabulary_views');
        Schema::dropIfExists('vocabulary_progress');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('vocabulary_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->onDelete('cascade');
            $table->timestamp('opened_at')->useCurrent();
        });

        Schema::create('vocabulary_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->onDelete('cascade');
            $table->boolean('is_mastered')->default(false);
            $table->timestamp('last_access')->useCurrent();
        });
    }
};
