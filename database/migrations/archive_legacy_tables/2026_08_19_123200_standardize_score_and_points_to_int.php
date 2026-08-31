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
        // 1. Standardize quiz_questions (points & score to INT)
        if (Schema::hasTable('quiz_questions')) {
            // Sinkronkan nilai points dari score jika ada yang belum terisi
            if (Schema::hasColumn('quiz_questions', 'score') && Schema::hasColumn('quiz_questions', 'points')) {
                DB::statement("UPDATE quiz_questions SET points = score WHERE points IS NULL OR points = 0");
            }

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'points')) {
                    $table->integer('points')->default(10)->change();
                }
                if (Schema::hasColumn('quiz_questions', 'score')) {
                    $table->integer('score')->default(10)->change();
                }
            });
        }

        // 2. Standardize quiz_answers (score to INT)
        if (Schema::hasTable('quiz_answers') && Schema::hasColumn('quiz_answers', 'score')) {
            Schema::table('quiz_answers', function (Blueprint $table) {
                $table->integer('score')->default(0)->change();
            });
        }

        // 3. Standardize quiz_scores (total_score to INT)
        if (Schema::hasTable('quiz_scores') && Schema::hasColumn('quiz_scores', 'total_score')) {
            Schema::table('quiz_scores', function (Blueprint $table) {
                $table->integer('total_score')->default(0)->change();
            });
        }

        // 4. Standardize classroom_assignments & classroom_submissions
        if (Schema::hasTable('classroom_assignments') && Schema::hasColumn('classroom_assignments', 'max_score')) {
            Schema::table('classroom_assignments', function (Blueprint $table) {
                $table->integer('max_score')->default(100)->change();
            });
        }

        if (Schema::hasTable('classroom_submissions') && Schema::hasColumn('classroom_submissions', 'score')) {
            Schema::table('classroom_submissions', function (Blueprint $table) {
                $table->integer('score')->nullable()->change();
            });
        }

        // 5. Standardize classroom_quizzes
        if (Schema::hasTable('classroom_quizzes') && Schema::hasColumn('classroom_quizzes', 'max_score')) {
            Schema::table('classroom_quizzes', function (Blueprint $table) {
                $table->integer('max_score')->default(100)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
