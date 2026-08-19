<?php

use App\Models\Role;
use App\Models\User;
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
        // 1. Tambah kolom user_code ke tabel users jika belum ada
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'user_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_code', 30)->unique()->nullable()->after('email');
            });
        }

        // 2. Generate user_code untuk seluruh akun pengajar dan pelajar yang sudah ada di database
        $studentRole = DB::table('roles')->where('name', 'student')->first();
        $teacherRole = DB::table('roles')->where('name', 'teacher')->first();

        // Generate untuk Teacher (Format: 277 + YY + sequence 2 digit, misal: 2772601)
        if ($teacherRole) {
            $teachers = DB::table('users')
                ->where('role_id', $teacherRole->id)
                ->whereNull('user_code')
                ->orderBy('id', 'asc')
                ->get();

            $seq = 1;
            foreach ($teachers as $t) {
                $year = $t->created_at ? date('y', strtotime($t->created_at)) : date('y');
                $code = '277' . $year . sprintf('%02d', $seq);
                DB::table('users')->where('id', $t->id)->update(['user_code' => $code]);
                $seq++;
            }
        }

        // Generate untuk Student (Format: 27705 + YY + sequence 2 digit, misal: 277052601)
        if ($studentRole) {
            $students = DB::table('users')
                ->where('role_id', $studentRole->id)
                ->whereNull('user_code')
                ->orderBy('id', 'asc')
                ->get();

            $seq = 1;
            foreach ($students as $s) {
                $year = $s->created_at ? date('y', strtotime($s->created_at)) : date('y');
                $code = '27705' . $year . sprintf('%02d', $seq);
                DB::table('users')->where('id', $s->id)->update(['user_code' => $code]);
                $seq++;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'user_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_code');
            });
        }
    }
};
