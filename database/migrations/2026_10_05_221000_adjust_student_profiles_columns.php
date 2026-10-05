<?php

use App\Models\StudentProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('student_profiles')) {
            // 1. Drop school_name column if exists
            if (Schema::hasColumn('student_profiles', 'school_name')) {
                Schema::table('student_profiles', function (Blueprint $table) {
                    $table->dropColumn('school_name');
                });
            }

            // 2. Adjust grade_level column to ENUM
            if (Schema::hasColumn('student_profiles', 'grade_level')) {
                // Sanitize existing rows not in allowed list
                DB::table('student_profiles')
                    ->whereNotNull('grade_level')
                    ->whereNotIn('grade_level', StudentProfile::GRADE_LEVELS)
                    ->update(['grade_level' => null]);

                if (DB::getDriverName() === 'mysql') {
                    $enumList = implode("', '", StudentProfile::GRADE_LEVELS);
                    DB::statement("ALTER TABLE `student_profiles` MODIFY `grade_level` ENUM('{$enumList}') NULL");
                } else {
                    Schema::table('student_profiles', function (Blueprint $table) {
                        $table->enum('grade_level', StudentProfile::GRADE_LEVELS)->nullable()->change();
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
        if (Schema::hasTable('student_profiles')) {
            if (!Schema::hasColumn('student_profiles', 'school_name')) {
                Schema::table('student_profiles', function (Blueprint $table) {
                    $table->string('school_name', 150)->nullable()->after('nisn');
                });
            }

            if (Schema::hasColumn('student_profiles', 'grade_level')) {
                if (DB::getDriverName() === 'mysql') {
                    DB::statement("ALTER TABLE `student_profiles` MODIFY `grade_level` VARCHAR(50) NULL");
                } else {
                    Schema::table('student_profiles', function (Blueprint $table) {
                        $table->string('grade_level', 50)->nullable()->change();
                    });
                }
            }
        }
    }
};
