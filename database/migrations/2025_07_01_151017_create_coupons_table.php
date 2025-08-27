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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->date('fecha_caducidad')->nullable(); // Fecha de caducidad, puede ser null
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // Estado del cupón
            $table->decimal('descuento', 8, 2)->default(0.00); // Descuento asociado al cupón
            $table->integer('cantidad')->default(1);
            $table->integer('referencia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
