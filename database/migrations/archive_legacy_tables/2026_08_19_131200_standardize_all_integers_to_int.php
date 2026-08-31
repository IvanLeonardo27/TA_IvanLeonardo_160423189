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
        // 1. Tabel Materi & Resources
        if (Schema::hasTable('material_sections') && Schema::hasColumn('material_sections', 'order_number')) {
            Schema::table('material_sections', function (Blueprint $table) {
                $table->integer('order_number')->default(1)->change();
            });
        }

        if (Schema::hasTable('material_resources')) {
            Schema::table('material_resources', function (Blueprint $table) {
                if (Schema::hasColumn('material_resources', 'file_size')) {
                    $table->integer('file_size')->nullable()->change();
                }
                if (Schema::hasColumn('material_resources', 'duration')) {
                    $table->integer('duration')->nullable()->change();
                }
            });
        }

        if (Schema::hasTable('material_attachments') && Schema::hasColumn('material_attachments', 'file_size')) {
            Schema::table('material_attachments', function (Blueprint $table) {
                $table->integer('file_size')->nullable()->change();
            });
        }

        // 2. Tabel Progress & Log Pembelajaran
        if (Schema::hasTable('material_progress') && Schema::hasColumn('material_progress', 'percentage')) {
            Schema::table('material_progress', function (Blueprint $table) {
                $table->integer('percentage')->default(0)->change();
            });
        }

        if (Schema::hasTable('learning_progress') && Schema::hasColumn('learning_progress', 'percentage')) {
            Schema::table('learning_progress', function (Blueprint $table) {
                $table->integer('percentage')->default(0)->change();
            });
        }

        if (Schema::hasTable('daily_learning_logs') && Schema::hasColumn('daily_learning_logs', 'minutes')) {
            Schema::table('daily_learning_logs', function (Blueprint $table) {
                $table->integer('minutes')->default(0)->change();
            });
        }

        // 3. Tabel Lampiran Kelas (Classroom Attachments)
        if (Schema::hasTable('classroom_post_attachments') && Schema::hasColumn('classroom_post_attachments', 'file_size')) {
            Schema::table('classroom_post_attachments', function (Blueprint $table) {
                $table->integer('file_size')->nullable()->change();
            });
        }

        // 4. Tabel Kuis (Quizzes & Classroom Quizzes)
        if (Schema::hasTable('quizzes')) {
            Schema::table('quizzes', function (Blueprint $table) {
                if (Schema::hasColumn('quizzes', 'duration')) {
                    $table->integer('duration')->nullable()->change();
                }
                if (Schema::hasColumn('quizzes', 'passing_grade')) {
                    $table->integer('passing_grade')->default(70)->change();
                }
            });
        }

        if (Schema::hasTable('classroom_quizzes')) {
            Schema::table('classroom_quizzes', function (Blueprint $table) {
                if (Schema::hasColumn('classroom_quizzes', 'duration_minutes')) {
                    $table->integer('duration_minutes')->default(30)->change();
                }
                if (Schema::hasColumn('classroom_quizzes', 'max_attempts')) {
                    $table->integer('max_attempts')->default(1)->change();
                }
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
