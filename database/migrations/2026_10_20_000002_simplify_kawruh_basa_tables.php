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
        $tables = [
            'arane_anak_kewan',
            'urutane_turunan',
            'urutane_sedulur',
            'prenah_sedulur',
            'arane_wong',
            'sebutane_bocah',
            'candraning_perangan_awak',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'indonesian_meaning')) {
                    $t->renameColumn('indonesian_meaning', 'indonesia_meaning');
                }
                
                $columnsToDrop = [];
                foreach (['category_note', 'example_javanese', 'example_indonesian', 'source_page', 'verification_status'] as $col) {
                    if (Schema::hasColumn($table, $col)) {
                        $columnsToDrop[] = $col;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $t->dropColumn($columnsToDrop);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'arane_anak_kewan',
            'urutane_turunan',
            'urutane_sedulur',
            'prenah_sedulur',
            'arane_wong',
            'sebutane_bocah',
            'candraning_perangan_awak',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'indonesia_meaning')) {
                    $t->renameColumn('indonesia_meaning', 'indonesian_meaning');
                }
                $t->string('category_note', 255)->nullable();
                $t->text('example_javanese')->nullable();
                $t->text('example_indonesian')->nullable();
                $t->string('source_page', 50)->nullable();
                $t->string('verification_status', 50)->default('needs_review');
            });
        }
    }
};
