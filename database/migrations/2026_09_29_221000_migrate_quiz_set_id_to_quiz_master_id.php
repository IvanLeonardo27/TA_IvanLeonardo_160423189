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
        $dbName = DB::getDatabaseName();

        // 1. classroom_quizzes
        if (Schema::hasTable('classroom_quizzes')) {
            // Pastikan quiz_master_id ada
            if (!Schema::hasColumn('classroom_quizzes', 'quiz_master_id')) {
                Schema::table('classroom_quizzes', function (Blueprint $table) {
                    $table->unsignedBigInteger('quiz_master_id')->nullable()->after('post_id');
                });
            }

            // Copy data dari quiz_set_id ke quiz_master_id jika quiz_master_id masih null
            if (Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
                DB::table('classroom_quizzes')
                    ->whereNotNull('quiz_set_id')
                    ->whereNull('quiz_master_id')
                    ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

                // Drop FK pada quiz_set_id jika ada
                $fks = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'classroom_quizzes' AND COLUMN_NAME = 'quiz_set_id' AND REFERENCED_TABLE_NAME IS NOT NULL
                ", [$dbName]);

                foreach ($fks as $fk) {
                    DB::statement("ALTER TABLE `classroom_quizzes` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                }

                // Drop kolom quiz_set_id
                Schema::table('classroom_quizzes', function (Blueprint $table) {
                    $table->dropColumn('quiz_set_id');
                });
            }

            // Pastikan quiz_master_id punya FK ke quiz_masters(id)
            $existingFk = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'classroom_quizzes' AND COLUMN_NAME = 'quiz_master_id' AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$dbName]);

            if (empty($existingFk)) {
                Schema::table('classroom_quizzes', function (Blueprint $table) {
                    $table->foreign('quiz_master_id', 'classroom_quizzes_quiz_master_id_foreign')
                          ->references('id')
                          ->on('quiz_masters')
                          ->onDelete('cascade');
                });
            }
        }

        // 2. quiz_attempts
        if (Schema::hasTable('quiz_attempts')) {
            // Pastikan quiz_master_id ada
            if (!Schema::hasColumn('quiz_attempts', 'quiz_master_id')) {
                Schema::table('quiz_attempts', function (Blueprint $table) {
                    $table->unsignedBigInteger('quiz_master_id')->nullable()->after('quiz_id');
                });
            }

            // Copy data dari quiz_set_id ke quiz_master_id jika quiz_master_id masih null
            if (Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                DB::table('quiz_attempts')
                    ->whereNotNull('quiz_set_id')
                    ->whereNull('quiz_master_id')
                    ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

                // Drop FK pada quiz_set_id jika ada
                $fks = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'quiz_attempts' AND COLUMN_NAME = 'quiz_set_id' AND REFERENCED_TABLE_NAME IS NOT NULL
                ", [$dbName]);

                foreach ($fks as $fk) {
                    DB::statement("ALTER TABLE `quiz_attempts` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                }

                // Drop kolom quiz_set_id
                Schema::table('quiz_attempts', function (Blueprint $table) {
                    $table->dropColumn('quiz_set_id');
                });
            }

            // Pastikan quiz_master_id punya FK ke quiz_masters(id)
            $existingFk = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'quiz_attempts' AND COLUMN_NAME = 'quiz_master_id' AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$dbName]);

            if (empty($existingFk)) {
                Schema::table('quiz_attempts', function (Blueprint $table) {
                    $table->foreign('quiz_master_id', 'quiz_attempts_quiz_master_id_foreign')
                          ->references('id')
                          ->on('quiz_masters')
                          ->onDelete('cascade');
                });
            }
        }

        // 3. quiz_questions
        if (Schema::hasTable('quiz_questions')) {
            // Pastikan quiz_master_id ada
            if (!Schema::hasColumn('quiz_questions', 'quiz_master_id')) {
                Schema::table('quiz_questions', function (Blueprint $table) {
                    $table->unsignedBigInteger('quiz_master_id')->nullable()->after('id');
                });
            }

            // Copy data dari quiz_set_id ke quiz_master_id jika quiz_master_id masih null
            if (Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
                DB::table('quiz_questions')
                    ->whereNotNull('quiz_set_id')
                    ->whereNull('quiz_master_id')
                    ->update(['quiz_master_id' => DB::raw('quiz_set_id')]);

                // Drop FK pada quiz_set_id jika ada
                $fks = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'quiz_questions' AND COLUMN_NAME = 'quiz_set_id' AND REFERENCED_TABLE_NAME IS NOT NULL
                ", [$dbName]);

                foreach ($fks as $fk) {
                    DB::statement("ALTER TABLE `quiz_questions` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                }

                // Drop kolom quiz_set_id
                Schema::table('quiz_questions', function (Blueprint $table) {
                    $table->dropColumn('quiz_set_id');
                });
            }

            // Pastikan quiz_master_id punya FK ke quiz_masters(id)
            $existingFk = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'quiz_questions' AND COLUMN_NAME = 'quiz_master_id' AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$dbName]);

            if (empty($existingFk)) {
                Schema::table('quiz_questions', function (Blueprint $table) {
                    $table->foreign('quiz_master_id', 'quiz_questions_quiz_master_id_foreign')
                          ->references('id')
                          ->on('quiz_masters')
                          ->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add quiz_set_id columns if needed for rollback
        Schema::table('classroom_quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('classroom_quizzes', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });
        Schema::table('quiz_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_questions', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_master_id');
            }
        });
    }
};
