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
        if (Schema::hasTable('classroom_quizzes') && !Schema::hasColumn('classroom_quizzes', 'show_explanation')) {
            Schema::table('classroom_quizzes', function (Blueprint $table) {
                $table->boolean('show_explanation')->default(false)->after('show_score');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('classroom_quizzes') && Schema::hasColumn('classroom_quizzes', 'show_explanation')) {
            Schema::table('classroom_quizzes', function (Blueprint $table) {
                $table->dropColumn('show_explanation');
            });
        }
    }
};
