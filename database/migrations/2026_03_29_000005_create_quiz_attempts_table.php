<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_set_id')->constrained('quiz_sets')->cascadeOnDelete();

            $table->string('player_name');
            $table->unsignedSmallInteger('score');
            $table->timestamp('taken_at')->useCurrent();

            $table->timestamps();

            $table->index(['quiz_set_id', 'taken_at']);
            $table->index(['player_name', 'taken_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
