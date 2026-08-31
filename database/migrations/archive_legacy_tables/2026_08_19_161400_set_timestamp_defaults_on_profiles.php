<?php

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
        // 1. Pastikan created_at yang null pada data lama diisi timestamp saat ini
        if (Schema::hasTable('teacher_profiles')) {
            DB::table('teacher_profiles')->whereNull('created_at')->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::statement("ALTER TABLE teacher_profiles MODIFY created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
            DB::statement("ALTER TABLE teacher_profiles MODIFY updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        }

        // 2. Pastikan created_at yang null pada student_profiles diisi timestamp saat ini
        if (Schema::hasTable('student_profiles')) {
            DB::table('student_profiles')->whereNull('created_at')->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::statement("ALTER TABLE student_profiles MODIFY created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
            DB::statement("ALTER TABLE student_profiles MODIFY updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
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
