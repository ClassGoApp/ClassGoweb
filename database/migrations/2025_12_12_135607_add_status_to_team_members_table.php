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
        Schema::table('team_members', function (Blueprint $table) {
            // Agregamos la columna 'status' después de 'role' (o al final)
            $table->boolean('status')->default(true)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            // Si revertimos, borramos la columna
            $table->dropColumn('status');
        });
    }
};
