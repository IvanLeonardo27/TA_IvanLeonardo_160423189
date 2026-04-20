<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_set_id')->constrained('quiz_sets')->cascadeOnDelete();

            $table->string('question');
            $table->json('options');
            $table->unsignedTinyInteger('correct_index');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['quiz_set_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
