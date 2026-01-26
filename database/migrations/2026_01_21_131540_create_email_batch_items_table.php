<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('email_batch_items', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('batch_id');     // FK a email_batches.id
      $table->unsignedBigInteger('user_id');      // users.id (tutor)
      $table->unsignedInteger('position');        // orden fijo dentro del batch
      $table->enum('status', ['pending','sent','failed'])->default('pending');
      $table->timestamp('sent_at')->nullable();
      $table->text('last_error')->nullable();
      $table->timestamps();

      // Evita duplicados del mismo user dentro del mismo batch
      $table->unique(['batch_id','user_id'], 'uniq_batch_user');

      // Índice clave para leer “el siguiente pendiente” instantáneo:
      $table->index(['batch_id','status','position'], 'idx_batch_next');
    });
  }

  public function down(): void {
    Schema::dropIfExists('email_batch_items');
  }
};
