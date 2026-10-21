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
        if (Schema::hasTable('teacher_profiles')) {
            foreach (['institution_name', 'subject_specialization'] as $column) {
                if (Schema::hasColumn('teacher_profiles', $column)) {
                    Schema::table('teacher_profiles', function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('teacher_profiles')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('teacher_profiles', 'institution_name')) {
                    $table->string('institution_name', 150)->nullable()->after('nip');
                }
                if (!Schema::hasColumn('teacher_profiles', 'subject_specialization')) {
                    $table->string('subject_specialization', 100)->nullable()->after('institution_name');
                }
            });
        }
    }
};
