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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('actor_name', 150)->nullable();
            $table->string('actor_code', 50)->nullable();
            $table->string('actor_email', 150)->nullable();
            $table->enum('role', ['admin', 'teacher', 'student', 'guest'])->default('student');
            $table->string('action', 100);
            $table->string('action_type', 50)->index(); // login, logout, classroom, post, submission, quiz, comment, profile, system
            $table->string('icon', 60)->default('fa-solid fa-clock-rotate-left');
            $table->string('badge_color', 60)->default('bg-secondary');
            $table->text('description');
            $table->string('target', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
