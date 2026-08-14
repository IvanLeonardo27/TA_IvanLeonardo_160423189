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
        Schema::create('javanese_script_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('script_detail_id')
                  ->constrained('javanese_script_details')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->text('javanese_script_text')->comment('Teks kalimat dalam aksara Jawa');
            $table->text('javanese_latin_text')->comment('Teks kalimat dalam latin bahasa Jawa');
            $table->text('indonesian_text')->comment('Terjemahan kalimat dalam bahasa Indonesia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('javanese_script_examples');
    }
};
