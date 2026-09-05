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
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('quiz_id');
            }
        });

        if (Schema::hasColumn('quiz_attempts', 'quiz_set_id') && Schema::hasColumn('quiz_attempts', 'quiz_master_id')) {
            DB::table('quiz_attempts')
                ->whereNotNull('quiz_master_id')
                ->whereNull('quiz_set_id')
                ->update(['quiz_set_id' => DB::raw('quiz_master_id')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                $table->dropColumn('quiz_set_id');
            }
        });
    }
};
