<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modifikasi tabel vocabulary_examples agar memuat kolom ngoko & krama jika belum ada
        Schema::table('vocabulary_examples', function (Blueprint $table) {
            if (!Schema::hasColumn('vocabulary_examples', 'ngoko_sentence')) {
                $table->text('ngoko_sentence')->nullable()->after('vocabulary_id');
            }
            if (!Schema::hasColumn('vocabulary_examples', 'krama_sentence')) {
                $table->text('krama_sentence')->nullable()->after('ngoko_sentence');
            }
            // Ubah javanese_sentence menjadi nullable jika ada
            if (Schema::hasColumn('vocabulary_examples', 'javanese_sentence')) {
                $table->text('javanese_sentence')->nullable()->change();
            }
            if (Schema::hasColumn('vocabulary_examples', 'indonesian_sentence')) {
                $table->text('indonesian_sentence')->nullable()->change();
            }
        });

        // 2. Migrasikan data yang sudah ada di vocabularies (jika ada) ke vocabulary_examples
        $vocabularies = DB::table('vocabularies')->get();
        foreach ($vocabularies as $vocab) {
            if (!empty($vocab->example_indonesian) || !empty($vocab->example_ngoko) || !empty($vocab->example_krama)) {
                DB::table('vocabulary_examples')->insert([
                    'vocabulary_id' => $vocab->id,
                    'indonesian_sentence' => $vocab->example_indonesian,
                    'ngoko_sentence' => $vocab->example_ngoko,
                    'krama_sentence' => $vocab->example_krama,
                    'javanese_sentence' => $vocab->example_ngoko ?? $vocab->example_krama,
                    'created_at' => now(),
                ]);
            }
        }

        // 3. Drop kolom-kolom contoh dari tabel vocabularies
        Schema::table('vocabularies', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('vocabularies', 'example_indonesian')) $columnsToDrop[] = 'example_indonesian';
            if (Schema::hasColumn('vocabularies', 'example_ngoko')) $columnsToDrop[] = 'example_ngoko';
            if (Schema::hasColumn('vocabularies', 'example_krama')) $columnsToDrop[] = 'example_krama';
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->text('example_indonesian')->nullable();
            $table->text('example_ngoko')->nullable();
            $table->text('example_krama')->nullable();
        });

        Schema::table('vocabulary_examples', function (Blueprint $table) {
            if (Schema::hasColumn('vocabulary_examples', 'ngoko_sentence')) {
                $table->dropColumn('ngoko_sentence');
            }
            if (Schema::hasColumn('vocabulary_examples', 'krama_sentence')) {
                $table->dropColumn('krama_sentence');
            }
        });
    }
};
