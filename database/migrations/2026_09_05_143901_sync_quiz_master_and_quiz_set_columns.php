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
        // 1. classroom_quizzes: pastikan ada quiz_master_id dan quiz_set_id
        Schema::table('classroom_quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('classroom_quizzes', 'quiz_master_id')) {
                $table->unsignedBigInteger('quiz_master_id')->nullable()->after('post_id');
            }
            if (!Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });

        // Sync di classroom_quizzes
        if (Schema::hasColumn('classroom_quizzes', 'quiz_master_id') && Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
            DB::table('classroom_quizzes')
                ->whereNotNull('quiz_set_id')
                ->whereNull('quiz_master_id')
                ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

            DB::table('classroom_quizzes')
                ->whereNotNull('quiz_master_id')
                ->whereNull('quiz_set_id')
                ->update(['quiz_set_id' => DB::raw('quiz_master_id')]);
        }

        // 2. quiz_attempts: pastikan ada quiz_master_id dan quiz_set_id
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_attempts', 'quiz_master_id')) {
                $table->unsignedBigInteger('quiz_master_id')->nullable()->after('quiz_id');
            }
            if (!Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });

        // Sync di quiz_attempts
        if (Schema::hasColumn('quiz_attempts', 'quiz_master_id') && Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
            DB::table('quiz_attempts')
                ->whereNotNull('quiz_set_id')
                ->whereNull('quiz_master_id')
                ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

            DB::table('quiz_attempts')
                ->whereNotNull('quiz_master_id')
                ->whereNull('quiz_set_id')
                ->update(['quiz_set_id' => DB::raw('quiz_master_id')]);
        }

        // 3. quiz_questions: pastikan ada quiz_master_id dan quiz_set_id
        Schema::table('quiz_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_questions', 'quiz_master_id')) {
                $table->unsignedBigInteger('quiz_master_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });

        // Sync di quiz_questions
        if (Schema::hasColumn('quiz_questions', 'quiz_master_id') && Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
            DB::table('quiz_questions')
                ->whereNotNull('quiz_set_id')
                ->whereNull('quiz_master_id')
                ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

            DB::table('quiz_questions')
                ->whereNotNull('quiz_master_id')
                ->whereNull('quiz_set_id')
                ->update(['quiz_set_id' => DB::raw('quiz_master_id')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive down (no dropping needed to avoid data loss)
    }
};
