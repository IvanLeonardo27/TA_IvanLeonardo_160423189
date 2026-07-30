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
        Schema::table('classroom_members', function (Blueprint $table) {
            $table->timestamp('out_at')->nullable()->after('joined_at');
        });

        // Ubah enum role agar mendukung 'teacher'
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE classroom_members MODIFY COLUMN role ENUM('teacher', 'co_teacher', 'student') NOT NULL DEFAULT 'student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_members', function (Blueprint $table) {
            $table->dropColumn('out_at');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE classroom_members MODIFY COLUMN role ENUM('student', 'co_teacher') NOT NULL DEFAULT 'student'");
    }
};
