<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 23. quizzes
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->nullable()->constrained('materials')->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration')->nullable(); // minutes
            $table->unsignedTinyInteger('passing_grade')->default(70); // 0-100
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
        });

        // 24. quiz_questions
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'essay'])->default('multiple_choice');
            $table->unsignedSmallInteger('score')->default(10);
        });

        // 25. question_options
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
        });

        // 26. quiz_attempts
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('start_time')->useCurrent();
            $table->dateTime('finish_time')->nullable();
            $table->enum('status', ['in_progress', 'finished', 'timed_out'])->default('in_progress');
        });

        // 27. quiz_answers
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $table->foreignId('option_id')->nullable()->constrained('question_options')->nullOnDelete();
            $table->text('essay_answer')->nullable();
            $table->unsignedSmallInteger('score')->default(0);
        });

        // 28. quiz_scores
        Schema::create('quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
            $table->unsignedSmallInteger('total_score')->default(0);
            $table->char('grade', 2)->nullable(); // A, B, C, D, E
            $table->boolean('passed')->default(false);
            $table->unique(['attempt_id']);
        });

        // 29. quiz_reviews
        Schema::create('quiz_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
            $table->text('teacher_comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 30. quiz_progress
        Schema::create('quiz_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->unique(['student_id', 'quiz_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_progress');
        Schema::dropIfExists('quiz_reviews');
        Schema::dropIfExists('quiz_scores');
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
