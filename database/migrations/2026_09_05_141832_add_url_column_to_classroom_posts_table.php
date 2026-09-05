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
        Schema::table('classroom_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('classroom_posts', 'url')) {
                $table->text('url')->nullable()->after('link_url');
            }
        });

        // Sinkronkan data yang sudah ada dari link_url ke url jika link_url terisi
        if (Schema::hasColumn('classroom_posts', 'url') && Schema::hasColumn('classroom_posts', 'link_url')) {
            DB::table('classroom_posts')
                ->whereNotNull('link_url')
                ->whereNull('url')
                ->update(['url' => DB::raw('link_url')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_posts', function (Blueprint $table) {
            if (Schema::hasColumn('classroom_posts', 'url')) {
                $table->dropColumn('url');
            }
        });
    }
};
