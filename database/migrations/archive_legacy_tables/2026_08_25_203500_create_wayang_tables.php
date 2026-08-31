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
        if (!Schema::hasTable('wayang_categories')) {
            Schema::create('wayang_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wayang_characters')) {
            Schema::create('wayang_characters', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('wayang_categories')->cascadeOnDelete();
                $table->string('name', 150);
                $table->text('other_names')->nullable();
                $table->string('gender', 30);
                $table->text('role')->nullable();
                $table->text('character_traits')->nullable();
                $table->text('weapon')->nullable();
                $table->text('family')->nullable();
                $table->string('allegiance', 100);
                $table->text('description')->nullable();
                $table->text('story')->nullable();
                $table->string('image_path', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wayang_characters');
        Schema::dropIfExists('wayang_categories');
    }
};
