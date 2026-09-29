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
        Schema::table('javanese_script_examples', function (Blueprint $table) {
            $table->json('syllable_breakdown')->nullable()->after('indonesian_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('javanese_script_examples', function (Blueprint $table) {
            $table->dropColumn('syllable_breakdown');
        });
    }
};
