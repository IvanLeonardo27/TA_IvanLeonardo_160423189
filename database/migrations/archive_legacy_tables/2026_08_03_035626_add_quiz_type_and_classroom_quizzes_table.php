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
        // 1. Modifikasi ENUM type di classroom_posts agar mendukung 'quiz'
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE classroom_posts MODIFY COLUMN type ENUM('announcement', 'material', 'assignment', 'quiz') NOT NULL DEFAULT 'announcement'");

        // 2. Tambahkan classroom_id ke tabel quizzes (opsional direct link)
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'classroom_id')) {
                $table->foreignId('classroom_id')->nullable()->after('teacher_id')->constrained('classrooms')->nullOnDelete();
            }
        });

        // 3. Buat tabel classroom_quizzes (Menghubungkan Post Kuis Kelas)
        if (!Schema::hasTable('classroom_quizzes')) {
            Schema::create('classroom_quizzes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->unique()->constrained('classroom_posts')->cascadeOnDelete();
                $table->unsignedBigInteger('quiz_set_id')->nullable();
                $table->dateTime('due_date')->nullable();
                $table->unsignedSmallInteger('duration_minutes')->default(30);
                $table->unsignedSmallInteger('max_score')->default(100);
                $table->text('instructions')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_quizzes');

        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'classroom_id')) {
                $table->dropForeign(['classroom_id']);
                $table->dropColumn('classroom_id');
            }
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE classroom_posts MODIFY COLUMN type ENUM('announcement', 'material', 'assignment') NOT NULL DEFAULT 'announcement'");
    }
};
