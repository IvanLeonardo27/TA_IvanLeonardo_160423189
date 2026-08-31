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
        // 1. Tambah kolom type ke materials
        Schema::table('materials', function (Blueprint $table) {
            $table->string('type')->default('general')->after('title'); 
            // e.g. general, unggah_ungguh, sastra_jawa, aksara_jawa
        });

        // 2. Aksara Jawa (Karakter statis)
        Schema::create('javanese_characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // e.g., "Ha", "Na", "Ca", "Ra", "Ka"
            $table->string('transliteration');  // e.g., "ha", "na", "ca", "ra", "ka"
            $table->string('speech_text');      // text yang akan dibaca Web Speech API
            $table->timestamps();
        });

        // 3. Unggah-Ungguh Basa (Materi spesifik)
        Schema::create('unggah_ungguh_basas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->string('context_scenario')->nullable(); 
            $table->text('ngoko_text');
            $table->text('krama_text');
            $table->text('indonesian_text');
            $table->timestamps();
        });

        // 4. Sastra Jawa (Geguritan, Tembang, dll)
        Schema::create('sastra_jawas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->string('author')->nullable();
            $table->string('genre'); // e.g., 'geguritan', 'tembang', 'cerkak'
            $table->text('content'); // Lirik / Teks Sastra
            $table->timestamps();
        });

        // 5. Centralized Material Attachments
        Schema::create('material_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // mime type or category (pdf, image, audio)
            $table->unsignedBigInteger('file_size')->nullable(); // bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_attachments');
        Schema::dropIfExists('sastra_jawas');
        Schema::dropIfExists('unggah_ungguh_basas');
        Schema::dropIfExists('javanese_characters');
        
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
