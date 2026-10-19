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
            'arane_kembang',
            'arane_pentil',
            'arane_woh',
            'arane_isi',
            'arane_wit',
            'arane_godhong',
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                Schema::create($table, function (Blueprint $t) {
                    $t->id();
                    $t->string('javanese_term', 255);
                    $t->text('indonesia_meaning');
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
        Schema::dropIfExists('arane_godhong');
        Schema::dropIfExists('arane_wit');
        Schema::dropIfExists('arane_isi');
        Schema::dropIfExists('arane_woh');
        Schema::dropIfExists('arane_pentil');
        Schema::dropIfExists('arane_kembang');
    }
};
