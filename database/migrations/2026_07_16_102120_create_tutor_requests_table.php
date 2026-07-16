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
        Schema::create('tutor_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('status', 30)->default('pending'); // pending, countered_by_tutor, countered_by_student, accepted, rejected
            $table->date('current_date');
            $table->string('current_time', 50);
            $table->string('current_duration', 50); // e.g. "20 min", "1 hora" etc.
            $table->text('note')->nullable();
            $table->string('student_token', 64)->unique();
            $table->string('tutor_token', 64)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_requests');
    }
};
