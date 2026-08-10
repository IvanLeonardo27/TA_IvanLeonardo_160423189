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
        // Hapus 8 tabel log & tracking yang tidak esensial
        Schema::dropIfExists('login_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('search_histories');
        Schema::dropIfExists('notification_reads');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('calendar_events');
        Schema::dropIfExists('daily_learning_logs');
        Schema::dropIfExists('learning_progress');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-creation logic if needed (optional)
    }
};
