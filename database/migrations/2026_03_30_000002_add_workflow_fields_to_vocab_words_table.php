<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vocab_words', function (Blueprint $table) {
            $table->string('status', 20)->default('published')->after('is_published');
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->timestamp('published_at')->nullable()->after('reviewed_at');

            $table->foreignId('created_by')->nullable()->after('published_at')->constrained('users')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->foreignId('published_by')->nullable()->after('reviewed_by')->constrained('users')->nullOnDelete();

            $table->index(['status', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::table('vocab_words', function (Blueprint $table) {
            $table->dropIndex(['status', 'is_published']);

            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropConstrainedForeignId('published_by');

            $table->dropColumn(['status', 'submitted_at', 'reviewed_at', 'published_at']);
        });
    }
};
