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
        // 1. Update quiz_questions table to support Question Bank
        if (Schema::hasTable('quiz_questions')) {
            // Ubah quiz_master_id menjadi nullable
            DB::statement('ALTER TABLE `quiz_questions` MODIFY `quiz_master_id` BIGINT UNSIGNED NULL');

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'teacher_id')) {
                    $table->foreignId('teacher_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('quiz_questions', 'category')) {
                    $table->string('category', 50)->default('umum')->after('image_path');
                }
            });

            // Isi teacher_id untuk soal-soal lama yang sudah ada
            $existingQuestions = DB::table('quiz_questions')->get();
            foreach ($existingQuestions as $q) {
                $teacherId = null;
                if (!empty($q->quiz_master_id)) {
                    $cq = DB::table('classroom_quizzes')
                        ->join('classroom_posts', 'classroom_quizzes.post_id', '=', 'classroom_posts.id')
                        ->where('classroom_quizzes.quiz_master_id', $q->quiz_master_id)
                        ->select('classroom_posts.author_id')
                        ->first();
                    $teacherId = $cq?->author_id;
                }

                if (!$teacherId) {
                    $defaultTeacher = DB::table('users')->where('role_id', 2)->first();
                    $teacherId = $defaultTeacher?->id ?? 1;
                }

                DB::table('quiz_questions')->where('id', $q->id)->update(['teacher_id' => $teacherId]);
            }
        }

        // 2. Create pivot table quiz_question_items
        if (!Schema::hasTable('quiz_question_items')) {
            Schema::create('quiz_question_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('quiz_master_id')->constrained('quiz_masters')->onDelete('cascade');
                $table->foreignId('quiz_question_id')->constrained('quiz_questions')->onDelete('cascade');
                $table->unsignedSmallInteger('order_number')->default(1);
                $table->timestamps();

                $table->unique(['quiz_master_id', 'quiz_question_id'], 'quiz_master_question_unique');
            });

            // Migrasi soal-soal yang sudah ada ke tabel pivot quiz_question_items
            $questions = DB::table('quiz_questions')->whereNotNull('quiz_master_id')->orderBy('id')->get();
            $orderMap = [];
            foreach ($questions as $q) {
                $masterId = $q->quiz_master_id;
                if (!isset($orderMap[$masterId])) {
                    $orderMap[$masterId] = 1;
                }

                DB::table('quiz_question_items')->insertOrIgnore([
                    'quiz_master_id'   => $masterId,
                    'quiz_question_id' => $q->id,
                    'order_number'     => $orderMap[$masterId]++,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_question_items');

        if (Schema::hasTable('quiz_questions')) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'teacher_id')) {
                    $table->dropForeign(['teacher_id']);
                    $table->dropColumn('teacher_id');
                }
                if (Schema::hasColumn('quiz_questions', 'category')) {
                    $table->dropColumn('category');
                }
            });
        }
    }
};
