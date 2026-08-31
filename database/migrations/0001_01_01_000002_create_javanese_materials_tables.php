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
        // 1. Kosakata (Vocabularies)
        Schema::create('vocabulary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('vocabulary_categories')->onDelete('set null');
            $table->string('indonesian_word', 255);
            $table->string('javanese_ngoko', 255)->nullable();
            $table->string('javanese_krama', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vocabulary_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->onDelete('cascade');
            $table->text('ngoko_sentence')->nullable();
            $table->text('krama_sentence')->nullable();
            $table->text('javanese_sentence')->nullable();
            $table->text('indonesian_sentence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Pewayangan (Wayang)
        Schema::create('wayang_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('wayang_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('wayang_categories')->onDelete('set null');
            $table->string('name', 150);
            $table->text('other_names')->nullable();
            $table->string('gender', 30)->nullable();
            $table->text('role')->nullable();
            $table->text('character_traits')->nullable();
            $table->text('weapon')->nullable();
            $table->text('family')->nullable();
            $table->string('allegiance', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('story')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Tembang Macapat
        Schema::create('macapat_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('guru_gatra')->default(0);
            $table->string('guru_wilangan', 200)->nullable();
            $table->string('guru_lagu', 100)->nullable();
            $table->text('watak')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('macapat_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('macapat_category_id')->constrained('macapat_categories')->onDelete('cascade');
            $table->text('verse')->nullable();
            $table->text('meaning')->nullable();
            $table->string('audio_path', 255)->nullable();
            $table->timestamps();
        });

        // 4. Aksara Jawa
        Schema::create('javanese_script_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('javanese_script_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('javanese_script_categories')->onDelete('set null');
            $table->string('name', 255);
            $table->string('latin', 255)->nullable();
            $table->string('pronunciation', 255)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('javanese_script_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('script_detail_id')->constrained('javanese_script_details')->onDelete('cascade');
            $table->text('javanese_script')->nullable();
            $table->text('javanese_latin')->nullable();
            $table->text('javanese_script_text')->nullable();
            $table->text('javanese_latin_text')->nullable();
            $table->text('indonesian_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('javanese_script_examples');
        Schema::dropIfExists('javanese_script_details');
        Schema::dropIfExists('javanese_script_categories');
        Schema::dropIfExists('macapat_details');
        Schema::dropIfExists('macapat_categories');
        Schema::dropIfExists('wayang_characters');
        Schema::dropIfExists('wayang_categories');
        Schema::dropIfExists('vocabulary_examples');
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('vocabulary_categories');
    }
};
