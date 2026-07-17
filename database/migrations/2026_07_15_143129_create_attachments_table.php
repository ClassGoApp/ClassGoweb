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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('original_name'); // Ej: "guia_de_estudio.pdf"
            $table->string('path');          // Ruta física en el disco (ej: "uploads/materials/xyz123.pdf")
            $table->string('extension', 10); // Ej: "pdf", "docx"
            $table->string('mime_type')->nullable(); // Ej: "application/pdf" (útil para el navegador)
            $table->unsignedBigInteger('size')->nullable(); // Tamaño en bytes (buena práctica)
            $table->text('description')->nullable();

            // CAMPOS MÁGICOS PARA MULTI-MÓDULO (Polimorfismo)
            // Esto creará: 'attachable_id' (entero) y 'attachable_type' (string)
            $table->nullableMorphs('attachable'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
