<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_sets', function (Blueprint $table) {
            $table->unsignedInteger('time_limit_seconds')->nullable()->after('is_default');
            $table->unsignedTinyInteger('max_attempts_per_player')->nullable()->after('time_limit_seconds');
            $table->boolean('randomize_questions')->default(true)->after('max_attempts_per_player');
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->string('status', 20)->default('published')->after('is_active');
            $table->string('difficulty', 20)->default('easy')->after('status');
            $table->text('explanation')->nullable()->after('difficulty');
            $table->unsignedSmallInteger('points')->default(20)->after('explanation');

            $table->foreignId('created_by')->nullable()->after('points')->constrained('users')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->foreignId('published_by')->nullable()->after('reviewed_by')->constrained('users')->nullOnDelete();

            $table->index(['quiz_set_id', 'status']);
            $table->index(['quiz_set_id', 'difficulty']);
        });
    }

    public function down(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropIndex(['quiz_set_id', 'status']);
            $table->dropIndex(['quiz_set_id', 'difficulty']);

            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropConstrainedForeignId('published_by');

            $table->dropColumn(['status', 'difficulty', 'explanation', 'points']);
        });

        Schema::table('quiz_sets', function (Blueprint $table) {
            $table->dropColumn(['time_limit_seconds', 'max_attempts_per_player', 'randomize_questions']);
        });
    }
};
