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
        if (Schema::hasTable('classroom_submissions')) {
            Schema::table('classroom_submissions', function (Blueprint $table) {
                if (!Schema::hasColumn('classroom_submissions', 'original_name')) {
                    $table->string('original_name', 255)->nullable()->after('file_path');
                }
                if (!Schema::hasColumn('classroom_submissions', 'note')) {
                    $table->text('note')->nullable()->after('original_filename');
                }
                if (!Schema::hasColumn('classroom_submissions', 'status')) {
                    $table->string('status', 50)->default('submitted')->after('submitted_at');
                }
            });

            \DB::statement("UPDATE classroom_submissions SET original_name = original_filename WHERE original_name IS NULL AND original_filename IS NOT NULL");
            \DB::statement("UPDATE classroom_submissions SET original_filename = original_name WHERE original_filename IS NULL AND original_name IS NOT NULL");
            \DB::statement("UPDATE classroom_submissions SET note = notes WHERE note IS NULL AND notes IS NOT NULL");
            \DB::statement("UPDATE classroom_submissions SET notes = note WHERE notes IS NULL AND note IS NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('classroom_submissions')) {
            Schema::table('classroom_submissions', function (Blueprint $table) {
                if (Schema::hasColumn('classroom_submissions', 'original_name')) {
                    $table->dropColumn('original_name');
                }
                if (Schema::hasColumn('classroom_submissions', 'note')) {
                    $table->dropColumn('note');
                }
                if (Schema::hasColumn('classroom_submissions', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
