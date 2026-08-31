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
        // Update teacher_profiles
        if (Schema::hasTable('teacher_profiles')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('teacher_profiles', 'institution_name')) {
                    $table->string('institution_name', 150)->nullable()->after('nip');
                }
                if (!Schema::hasColumn('teacher_profiles', 'subject_specialization')) {
                    $table->string('subject_specialization', 100)->nullable()->after('institution_name');
                }
                if (!Schema::hasColumn('teacher_profiles', 'phone_number')) {
                    $table->string('phone_number', 30)->nullable()->after('subject_specialization');
                }
                if (!Schema::hasColumn('teacher_profiles', 'bio')) {
                    $table->text('bio')->nullable()->after('phone_number');
                }
            });
        }

        // Update student_profiles
        if (Schema::hasTable('student_profiles')) {
            Schema::table('student_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('student_profiles', 'nisn')) {
                    $table->string('nisn', 50)->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('student_profiles', 'school_name')) {
                    $table->string('school_name', 150)->nullable()->after('nisn');
                }
                if (!Schema::hasColumn('student_profiles', 'grade_level')) {
                    $table->string('grade_level', 50)->nullable()->after('school_name');
                }
                if (!Schema::hasColumn('student_profiles', 'phone_number')) {
                    $table->string('phone_number', 30)->nullable()->after('grade_level');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('teacher_profiles')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                $table->dropColumn(['institution_name', 'subject_specialization', 'phone_number', 'bio']);
            });
        }

        if (Schema::hasTable('student_profiles')) {
            Schema::table('student_profiles', function (Blueprint $table) {
                $table->dropColumn(['nisn', 'school_name', 'grade_level', 'phone_number']);
            });
        }
    }
};
