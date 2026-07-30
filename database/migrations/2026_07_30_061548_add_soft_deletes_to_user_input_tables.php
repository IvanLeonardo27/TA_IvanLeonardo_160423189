<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel-tabel yang mengalami proses input dari user/admin
     */
    protected array $tables = [
        'users',
        'classrooms',
        'classroom_posts',
        'classroom_post_attachments',
        'classroom_comments',
        'classroom_assignments',
        'classroom_submissions',
        'vocabularies',
        'vocabulary_examples',
        'vocabulary_categories',
        'quiz_sets',
        'quiz_questions',
        'quiz_attempts',
        'quiz_attempt_answers',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
