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
        if (Schema::hasTable('javanese_script_examples')) {
            Schema::table('javanese_script_examples', function (Blueprint $table) {
                if (Schema::hasColumn('javanese_script_examples', 'javanese_script')) {
                    $table->dropColumn('javanese_script');
                }
                if (Schema::hasColumn('javanese_script_examples', 'javanese_latin')) {
                    $table->dropColumn('javanese_latin');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('javanese_script_examples')) {
            Schema::table('javanese_script_examples', function (Blueprint $table) {
                if (!Schema::hasColumn('javanese_script_examples', 'javanese_script')) {
                    $table->text('javanese_script')->nullable()->after('script_detail_id');
                }
                if (!Schema::hasColumn('javanese_script_examples', 'javanese_latin')) {
                    $table->text('javanese_latin')->nullable()->after('javanese_script');
                }
            });
        }
    }
};
