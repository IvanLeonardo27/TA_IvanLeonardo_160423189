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
        // 1. Update classroom_posts: allow 'url' type & add link_url column
        Schema::table('classroom_posts', function (Blueprint $table) {
            $table->string('type', 30)->default('announcement')->change();
            if (!Schema::hasColumn('classroom_posts', 'link_url')) {
                $table->text('link_url')->nullable()->after('body');
            }
        });

        // 2. Update quiz_sets: add slug, time_limit_seconds, is_active
        Schema::table('quiz_sets', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_sets', 'slug')) {
                $table->string('slug', 200)->nullable()->after('title');
            }
            if (!Schema::hasColumn('quiz_sets', 'time_limit_seconds')) {
                $table->integer('time_limit_seconds')->nullable()->after('description');
            }
            if (!Schema::hasColumn('quiz_sets', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('category');
            }
        });

        // 3. Update quiz_questions: add question & correct_index synonyms
        Schema::table('quiz_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_questions', 'question')) {
                $table->text('question')->nullable()->after('question_text');
            }
            if (!Schema::hasColumn('quiz_questions', 'correct_index')) {
                $table->integer('correct_index')->nullable()->after('correct_answer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_posts', function (Blueprint $table) {
            if (Schema::hasColumn('classroom_posts', 'link_url')) {
                $table->dropColumn('link_url');
            }
        });

        Schema::table('quiz_sets', function (Blueprint $table) {
            $cols = array_filter(['slug', 'time_limit_seconds', 'is_active'], fn($c) => Schema::hasColumn('quiz_sets', $c));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $cols = array_filter(['question', 'correct_index'], fn($c) => Schema::hasColumn('quiz_questions', $c));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
