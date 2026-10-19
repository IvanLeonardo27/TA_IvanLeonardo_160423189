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
        Schema::dropIfExists('candraning_perangan_awak');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('candraning_perangan_awak')) {
            Schema::create('candraning_perangan_awak', function (Blueprint $table) {
                $table->id();
                $table->string('javanese_term', 255);
                $table->text('indonesia_meaning');
                $table->timestamps();
            });
        }
    }
};
