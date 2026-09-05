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
        Schema::table('classroom_comments', function (Blueprint $table) {
            if (!Schema::hasColumn('classroom_comments', 'comment')) {
                $table->text('comment')->nullable()->after('body');
            }
        });

        // Sinkronkan data jika ada
        if (Schema::hasColumn('classroom_comments', 'comment') && Schema::hasColumn('classroom_comments', 'body')) {
            DB::table('classroom_comments')
                ->whereNotNull('body')
                ->whereNull('comment')
                ->update(['comment' => DB::raw('body')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_comments', function (Blueprint $table) {
            if (Schema::hasColumn('classroom_comments', 'comment')) {
                $table->dropColumn('comment');
            }
        });
    }
};
