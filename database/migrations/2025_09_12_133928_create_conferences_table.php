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
       Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description'); // <- corregido
            $table->string('imagen_url');   // not nullable por defecto
            $table->dateTime('start_datetime')->index();
            $table->dateTime('end_datetime')->index();
            $table->unsignedInteger('ability'); // capacidad (cupo)
            $table->unsignedInteger('enrolled_students')->default(0);
            $table->boolean('is_free')->default(true); // si es gratuita o de pago
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // tutor
            
            $table->timestamps();

            // Opcional: evitar duplicados por nombre y fecha del mismo tutor
            $table->unique(['user_id', 'name', 'start_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
