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
        if (!Schema::hasTable('vocabulary_categories')) {
            Schema::create('vocabulary_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('vocabulary_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('vocabulary_categories', 'created_at')) {
                    $table->timestamps();
                }
            });
        }

        if (!Schema::hasColumn('vocabularies', 'category_id')) {
            Schema::table('vocabularies', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->after('javanese_krama')->constrained('vocabulary_categories')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('vocabularies', 'category_id')) {
            Schema::table('vocabularies', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }
};
