<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus tabel translation_favorites (child dari translations)
        Schema::dropIfExists('translation_favorites');

        // 2. Hapus tabel translations
        Schema::dropIfExists('translations');

        // 3. Hapus tabel tts_settings
        Schema::dropIfExists('tts_settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
