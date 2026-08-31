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
        // 1. quiz_sets
        Schema::create('quiz_sets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('category', 50)->default('general');
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. quiz_questions
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_set_id')->nullable()->constrained('quiz_sets')->onDelete('cascade');
            $table->text('question_text');
            $table->json('options');
            $table->string('correct_answer', 10);
            $table->integer('points')->default(10);
            $table->boolean('is_active')->default(true);
            $table->text('explanation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. classroom_quizzes
        Schema::create('classroom_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('classroom_posts')->onDelete('cascade');
            $table->foreignId('quiz_set_id')->constrained('quiz_sets')->onDelete('cascade');
            $table->timestamp('due_date')->nullable();
            $table->integer('duration_minutes')->default(30);
            $table->integer('max_score')->default(100);
            $table->boolean('show_score')->default(true);
            $table->integer('max_attempts')->default(1);
            $table->text('instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. quiz_attempts
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->nullable()->constrained('classroom_quizzes')->onDelete('cascade');
            $table->foreignId('quiz_set_id')->nullable()->constrained('quiz_sets')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('player_name', 100)->nullable();
            $table->integer('score')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->integer('time_spent_seconds')->nullable();
            $table->timestamp('taken_at')->useCurrent();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('completed');
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. quiz_answers
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->string('selected_option', 10);
            $table->boolean('is_correct')->default(false);
            $table->integer('score_earned')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('classroom_quizzes');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quiz_sets');
    }
};
