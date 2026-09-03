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
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->renameColumn('actor_name', 'name');
            $table->renameColumn('actor_code', 'code');
            $table->renameColumn('actor_email', 'email');
            $table->dropColumn(['icon', 'badge_color', 'user_agent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->renameColumn('name', 'actor_name');
            $table->renameColumn('code', 'actor_code');
            $table->renameColumn('email', 'actor_email');
            $table->string('icon', 60)->default('fa-solid fa-clock-rotate-left');
            $table->string('badge_color', 60)->default('bg-secondary');
            $table->text('user_agent')->nullable();
        });
    }
};
