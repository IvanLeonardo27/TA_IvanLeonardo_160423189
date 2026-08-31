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
        // 1. Buat tabel quiz_sets jika belum ada
        if (!Schema::hasTable('quiz_sets')) {
            Schema::create('quiz_sets', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_default')->default(false);
                $table->integer('time_limit_seconds')->default(1800);
                $table->integer('max_attempts_per_player')->default(1);
                $table->boolean('randomize_questions')->default(false);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // 2. Sesuaikan kolom quiz_questions agar mendukung quiz_set_id & JSON options
        if (Schema::hasTable('quiz_questions')) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
                    $table->unsignedBigInteger('quiz_set_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('quiz_questions', 'options')) {
                    $table->json('options')->nullable()->after('question');
                }
                if (!Schema::hasColumn('quiz_questions', 'correct_index')) {
                    $table->integer('correct_index')->default(0)->after('options');
                }
                if (!Schema::hasColumn('quiz_questions', 'points')) {
                    $table->integer('points')->default(10)->after('correct_index');
                }
                if (!Schema::hasColumn('quiz_questions', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('points');
                }
                if (!Schema::hasColumn('quiz_questions', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_sets');
    }
};
