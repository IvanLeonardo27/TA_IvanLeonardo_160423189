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
        // 1. Bersihkan kolom tidak terpakai di teacher_profiles: bio, gender, phone, address
        if (Schema::hasTable('teacher_profiles')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                $columnsToDrop = [];
                if (Schema::hasColumn('teacher_profiles', 'bio')) {
                    $columnsToDrop[] = 'bio';
                }
                if (Schema::hasColumn('teacher_profiles', 'gender')) {
                    $columnsToDrop[] = 'gender';
                }
                if (Schema::hasColumn('teacher_profiles', 'phone')) {
                    $columnsToDrop[] = 'phone';
                }
                if (Schema::hasColumn('teacher_profiles', 'address')) {
                    $columnsToDrop[] = 'address';
                }

                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }

        // 2. Bersihkan kolom tidak terpakai di student_profiles: gender, phone, address, nis, class
        if (Schema::hasTable('student_profiles')) {
            Schema::table('student_profiles', function (Blueprint $table) {
                $columnsToDrop = [];
                if (Schema::hasColumn('student_profiles', 'gender')) {
                    $columnsToDrop[] = 'gender';
                }
                if (Schema::hasColumn('student_profiles', 'phone')) {
                    $columnsToDrop[] = 'phone';
                }
                if (Schema::hasColumn('student_profiles', 'address')) {
                    $columnsToDrop[] = 'address';
                }
                if (Schema::hasColumn('student_profiles', 'nis')) {
                    $columnsToDrop[] = 'nis';
                }
                if (Schema::hasColumn('student_profiles', 'class')) {
                    $columnsToDrop[] = 'class';
                }

                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional
    }
};
