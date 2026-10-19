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
            if (!Schema::hasTable($table)) {
                Schema::create($table, function (Blueprint $t) {
                    $t->id();
                    $t->string('javanese_term', 255);
                    $t->text('indonesian_meaning');
                    $t->string('category_note', 255)->nullable();
                    $t->text('example_javanese')->nullable();
                    $t->text('example_indonesian')->nullable();
                    $t->string('source_page', 50)->nullable();
                    $t->string('verification_status', 50)->default('needs_review');
                    $t->timestamps();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candraning_perangan_awak');
        Schema::dropIfExists('sebutane_bocah');
        Schema::dropIfExists('arane_wong');
        Schema::dropIfExists('prenah_sedulur');
        Schema::dropIfExists('urutane_sedulur');
        Schema::dropIfExists('urutane_turunan');
        Schema::dropIfExists('arane_anak_kewan');
    }
};
