<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 34. calendar_events
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->enum('type', ['quiz', 'tugas', 'materi', 'lainnya'])->default('lainnya');
        });

        // 38. notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, warning, success, danger
            $table->timestamp('created_at')->useCurrent();
        });

        // 39. notification_reads
        Schema::create('notification_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('notifications')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('read_at')->useCurrent();
            $table->unique(['notification_id', 'student_id']);
        });

        // 40. search_histories
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('keyword');
            $table->timestamp('created_at')->useCurrent();
            $table->index('student_id');
        });

        // 41. activity_logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('activity', ['login', 'logout', 'view_material', 'translate', 'tts', 'quiz']);
            $table->string('description')->nullable();
            $table->morphs('loggable'); // loggable_type, loggable_id -> for polymorphic relation
            $table->timestamp('created_at')->useCurrent();
            $table->index('user_id');
        });

        // 42. login_logs
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip', 45)->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->timestamp('login_at')->useCurrent();
            $table->timestamp('logout_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('search_histories');
        Schema::dropIfExists('notification_reads');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('calendar_events');
    }
};
