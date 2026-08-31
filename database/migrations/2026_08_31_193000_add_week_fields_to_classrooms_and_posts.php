<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom penataan mingguan (Weekly Course Sections) pada kelas dan post.
     */
    public function up(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            if (!Schema::hasColumn('classrooms', 'week_titles')) {
                $table->json('week_titles')->nullable()->after('banner_icon');
            }
        });

        Schema::table('classroom_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('classroom_posts', 'week_number')) {
                $table->unsignedInteger('week_number')->nullable()->after('classroom_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            if (Schema::hasColumn('classrooms', 'week_titles')) {
                $table->dropColumn('week_titles');
            }
        });

        Schema::table('classroom_posts', function (Blueprint $table) {
            if (Schema::hasColumn('classroom_posts', 'week_number')) {
                $table->dropColumn('week_number');
            }
        });
    }
};
