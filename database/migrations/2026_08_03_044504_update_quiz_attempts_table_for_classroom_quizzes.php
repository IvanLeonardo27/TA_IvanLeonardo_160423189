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
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_attempts', 'quiz_id')) {
                $table->unsignedBigInteger('quiz_id')->nullable()->change();
            }
            if (Schema::hasColumn('quiz_attempts', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->change();
            }
            if (!Schema::hasColumn('quiz_attempts', 'quiz_set_id')) {
                $table->unsignedBigInteger('quiz_set_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('quiz_attempts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('quiz_set_id');
            }
            if (!Schema::hasColumn('quiz_attempts', 'player_name')) {
                $table->string('player_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('quiz_attempts', 'score')) {
                $table->integer('score')->default(0)->after('player_name');
            }
            if (!Schema::hasColumn('quiz_attempts', 'taken_at')) {
                $table->dateTime('taken_at')->nullable()->after('score');
            }
            if (!Schema::hasColumn('quiz_attempts', 'created_at')) {
                $table->timestamps();
            }
            if (!Schema::hasColumn('quiz_attempts', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            //
        });
    }
};
