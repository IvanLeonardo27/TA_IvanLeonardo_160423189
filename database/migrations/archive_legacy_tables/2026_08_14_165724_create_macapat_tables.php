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
        // Drop tabel macapats lama jika ada
        Schema::dropIfExists('macapat_details');
        Schema::dropIfExists('macapat_categories');
        Schema::dropIfExists('macapats');

        // 1. Tabel macapat_categories
        Schema::create('macapat_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('guru_gatra');
            $table->string('guru_wilangan', 100);
            $table->string('guru_lagu', 100);
            $table->text('watak')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Tabel macapat_details
        Schema::create('macapat_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('macapat_category_id')
                  ->constrained('macapat_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->text('verse');
            $table->text('meaning')->nullable();
            $table->string('audio_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macapat_details');
        Schema::dropIfExists('macapat_categories');
    }
};
