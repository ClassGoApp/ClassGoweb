<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_batch_items', function (Blueprint $table) {
            // Si por alguna razón no existiera, la agregamos
            if (!Schema::hasColumn('email_batch_items', 'accept_token')) {
                $table->string('accept_token', 60)->nullable()->after('status');
            }

            // Índice UNIQUE para búsqueda rápida por token
            // (si ya existe un índice con ese nombre, Laravel lanzará error,
            // por eso usamos un nombre estable y lo manejamos en down())
            $table->unique('accept_token', 'uq_ebi_accept_token');
        });
    }

    public function down(): void
    {
        Schema::table('email_batch_items', function (Blueprint $table) {
            // Borra unique index
            $table->dropUnique('uq_ebi_accept_token');

            // NO borro la columna porque tú ya la usas y podría tener data.
            // Si quieres que también la quite, dímelo y lo agrego.
        });
    }
};
