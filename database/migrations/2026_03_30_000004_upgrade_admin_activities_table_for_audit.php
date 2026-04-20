<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->foreignId('actor_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('action', 50)->nullable()->after('description');
            $table->string('subject_type', 120)->nullable()->after('action');
            $table->unsignedBigInteger('subject_id')->nullable()->after('subject_type');
            $table->json('properties')->nullable()->after('subject_id');

            $table->index(['actor_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->dropIndex(['actor_id', 'created_at']);
            $table->dropIndex(['subject_type', 'subject_id']);

            $table->dropConstrainedForeignId('actor_id');
            $table->dropColumn(['action', 'subject_type', 'subject_id', 'properties']);
        });
    }
};
