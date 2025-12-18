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
        Schema::create('team_members', function (Blueprint $table) {
            // 1. Identificador único
            $table->id(); 

            // 2. Datos obligatorios del miembro
            $table->string('name');
            $table->string('last_name');
            $table->string('role');       // Cargo (Ej: CEO, Desarrollador)
            $table->integer('order')->default(0); // Para ordenar (1, 2, 3...)

            // 3. Datos opcionales (pueden quedar vacíos)
            $table->string('platform')->nullable();      // Ej: LinkedIn, Facebook
            $table->string('platform_link')->nullable(); // URL del perfil
            $table->string('photo')->nullable();         // Ruta de la imagen subida

            $table->timestamps(); // create_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
