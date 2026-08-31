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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // $table->morphs('bookmarkable') secara otomatis membuat 2 kolom:
            // 1. bookmarkable_type (VARCHAR) -> Menyimpan Nama Class Model
            // 2. bookmarkable_id (BIGINT)   -> Menyimpan Primary Key ID dari item yang dibookmark
            $table->morphs('bookmarkable');
            
            $table->timestamps();

            // Mencegah duplikasi: 1 user tidak bisa bookmark item yang sama lebih dari 1x
            $table->unique(['user_id', 'bookmarkable_type', 'bookmarkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
