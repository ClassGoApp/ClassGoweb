<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_batches', function (Blueprint $table) {
            $table->id(); // BIGINT unsigned auto increment

            // Materia elegida
            $table->unsignedBigInteger('subject_id');

            // Estudiante que inició la búsqueda (para poder recuperar estado si recarga)
            $table->unsignedBigInteger('created_by')->index();

            // Estado del batch
            $table->enum('status', ['pending','running','done','failed'])->default('pending')->index();

            // Para tu lógica anterior (si lo sigues usando)
            $table->unsignedBigInteger('last_tutor_id')->default(0);

            // Contador de enviados
            $table->unsignedInteger('sent_count')->default(0);

            // Tamaño de lote (tú: 1 por minuto)
            $table->unsignedInteger('batch_size')->default(1);

            // Si algo sale mal o si expiró: 'expired'
            $table->text('last_error')->nullable();

            // Tiempo límite de espera (cuando se pase, el batch se detiene solo)
            $table->timestamp('expires_at')->nullable()->index();

            $table->timestamps();

            // Foreign keys (ajusta onDelete según tu criterio)
            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_batches');
    }
};
