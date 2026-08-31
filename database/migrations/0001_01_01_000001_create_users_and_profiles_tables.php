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
        // 1. roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 2. users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_code', 30)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamp('last_login')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. student_profiles
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nisn', 30)->nullable();
            $table->string('school_name', 150)->nullable();
            $table->string('grade_level', 50)->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->timestamps();
        });

        // 4. teacher_profiles
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nip', 50)->nullable();
            $table->string('institution_name', 150)->nullable();
            $table->string('subject_specialization', 100)->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_profiles');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
