<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocab_words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocab_category_id')->nullable()->constrained('vocab_categories')->nullOnDelete();

            $table->string('indo');
            $table->string('jawa');
            $table->string('emoji')->nullable();
            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->index(['vocab_category_id', 'indo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_words');
    }
};
