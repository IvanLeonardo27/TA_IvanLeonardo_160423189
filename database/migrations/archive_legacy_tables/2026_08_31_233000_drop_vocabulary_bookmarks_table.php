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
        Schema::dropIfExists('vocabulary_bookmarks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('vocabulary_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
