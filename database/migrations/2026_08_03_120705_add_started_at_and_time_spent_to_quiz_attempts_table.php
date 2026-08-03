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
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_attempts', 'started_at')) {
                $table->dateTime('started_at')->nullable()->after('score');
            }
            if (!Schema::hasColumn('quiz_attempts', 'time_spent_seconds')) {
                $table->integer('time_spent_seconds')->nullable()->after('started_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'time_spent_seconds']);
        });
    }
};
