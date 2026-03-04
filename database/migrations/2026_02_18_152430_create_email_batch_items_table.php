<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_batch_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('user_id');

            $table->unsignedInteger('position');

            $table->enum('status', [
                'pending',
                'sending',
                'sent',
                'failed',
                'accepted',
                'chosen',
                'expired',
            ])->default('pending');

            $table->timestamp('sent_at')->nullable();
            $table->text('last_error')->nullable();

            $table->string('accept_token', 80)->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('chosen_at')->nullable();

            $table->timestamps();

            // índices
            $table->unique(['batch_id', 'user_id'], 'uniq_batch_user');
            $table->unique('accept_token', 'uniq_accept_token');
            $table->index(['batch_id', 'status', 'position'], 'idx_batch_next');
            $table->index(['batch_id', 'accepted_at'], 'idx_batch_accepted');

            // FK
            $table->foreign('batch_id')->references('id')->on('email_batches')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_batch_items');
    }
};
