<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Bersihkan nilai quiz_set_id yang tidak ada di tabel quiz_sets (jika ada data orphan)
        $validQuizSetIds = DB::table('quiz_sets')->pluck('id')->toArray();

        if (Schema::hasTable('quiz_questions') && Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
            if (!empty($validQuizSetIds)) {
                DB::table('quiz_questions')
                    ->whereNotNull('quiz_set_id')
                    ->whereNotIn('quiz_set_id', $validQuizSetIds)
                    ->update(['quiz_set_id' => null]);
            }

            Schema::table('quiz_questions', function (Blueprint $table) {
                $table->foreign('quiz_set_id')
                      ->references('id')
                      ->on('quiz_sets')
                      ->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('classroom_quizzes') && Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
            if (!empty($validQuizSetIds)) {
                DB::table('classroom_quizzes')
                    ->whereNotNull('quiz_set_id')
                    ->whereNotIn('quiz_set_id', $validQuizSetIds)
                    ->update(['quiz_set_id' => null]);
            }

            Schema::table('classroom_quizzes', function (Blueprint $table) {
                $table->foreign('quiz_set_id')
                      ->references('id')
                      ->on('quiz_sets')
                      ->nullOnDelete();
            });
        }

        if (Schema::hasTable('quiz_attempts') && Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
            if (!empty($validQuizSetIds)) {
                DB::table('quiz_attempts')
                    ->whereNotNull('quiz_set_id')
                    ->whereNotIn('quiz_set_id', $validQuizSetIds)
                    ->update(['quiz_set_id' => null]);
            }

            Schema::table('quiz_attempts', function (Blueprint $table) {
                $table->foreign('quiz_set_id')
                      ->references('id')
                      ->on('quiz_sets')
                      ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('quiz_questions') && Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                $table->dropForeign(['quiz_set_id']);
            });
        }

        if (Schema::hasTable('classroom_quizzes') && Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
            Schema::table('classroom_quizzes', function (Blueprint $table) {
                $table->dropForeign(['quiz_set_id']);
            });
        }

        if (Schema::hasTable('quiz_attempts') && Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
            Schema::table('quiz_attempts', function (Blueprint $table) {
                $table->dropForeign(['quiz_set_id']);
            });
        }
    }
};
