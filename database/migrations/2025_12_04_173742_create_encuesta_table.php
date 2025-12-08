<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('encuesta', function (Blueprint $table) {
            $table->id(); 
            
            $table->boolean('Question_1'); // 1 o 0
            $table->integer('Question_2'); // Estrellas
            $table->text('Question_3')->nullable(); // Comentarios (puede ser nulo)
            // ->unique() evita que el mismo número rellene la encuesta 2 veces.
            $table->string('Contact', 20)->unique();
            // Si está logueado se guarda el ID, si no, se guarda NULL.
            $table->unsignedBigInteger('IdUser')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta');
    }
};
