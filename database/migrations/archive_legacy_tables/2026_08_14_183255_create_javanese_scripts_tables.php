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
        // 1. Drop tabel sastra_jawas jika ada
        Schema::dropIfExists('sastra_jawas');

        // 2. Drop tabel javanese script jika sudah ada sebelumnya
        Schema::dropIfExists('javanese_script_details');
        Schema::dropIfExists('javanese_script_categories');

        // 3. Buat tabel javanese_script_categories (Kategori Aksara Jawa: Carakan, Pasangan, Sandhangan, dll)
        Schema::create('javanese_script_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 4. Buat tabel javanese_script_details (Detail Karakter Aksara Jawa)
        Schema::create('javanese_script_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('javanese_script_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('name');
            $table->string('latin');
            $table->string('pronunciation')->nullable();
            $table->string('image_path')->nullable();
            $table->string('audio_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('javanese_script_details');
        Schema::dropIfExists('javanese_script_categories');
    }
};
