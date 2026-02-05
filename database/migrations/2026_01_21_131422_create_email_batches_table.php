<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_batches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('created_by');

            $table->enum('status', ['pending', 'running', 'matched', 'done', 'failed'])
                ->default('pending');

            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('batch_size')->default(1);

            $table->timestamp('expires_at')->nullable();
            $table->text('last_error')->nullable();

            $table->unsignedBigInteger('last_tutor_id')->default(0);

            // opcional (si luego haces “primer tutor gana”)
            $table->unsignedBigInteger('accepted_user_id')->nullable();
            $table->unsignedBigInteger('accepted_item_id')->nullable();
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();

            // performance
            $table->index(['status', 'expires_at', 'id'], 'idx_batches_status_expires_id');
            $table->index(['created_by', 'subject_id', 'status', 'expires_at'], 'idx_batches_reuse');
            $table->index(['subject_id', 'status'], 'idx_batches_subject_status');

            // FK
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
}

    public function down(): void
    {
        
        Schema::dropIfExists('email_batches');
    }
};
