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
        if (Schema::hasTable('classroom_posts') && Schema::hasColumn('classroom_posts', 'is_pinned')) {
            Schema::table('classroom_posts', function (Blueprint $table) {
                $table->dropColumn('is_pinned');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('classroom_posts') && !Schema::hasColumn('classroom_posts', 'is_pinned')) {
            Schema::table('classroom_posts', function (Blueprint $table) {
                $table->boolean('is_pinned')->default(false)->after('link_url');
            });
        }
    }
};
