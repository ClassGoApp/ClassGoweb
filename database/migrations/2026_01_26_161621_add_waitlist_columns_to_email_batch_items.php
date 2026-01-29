<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('email_batch_items', function (Blueprint $table) {
            // Token único para identificar al tutor cuando hace click en el email
            $table->string('accept_token', 80)->nullable()->after('last_error');

            // Timestamp cuando el tutor aceptó
            $table->timestamp('accepted_at')->nullable()->after('accept_token');

            // Opcional: cuando el estudiante lo elige finalmente
            $table->timestamp('chosen_at')->nullable()->after('accepted_at');

            // Índices
            $table->unique('accept_token', 'uniq_accept_token');
            $table->index(['batch_id', 'accepted_at'], 'idx_batch_accepted');
        });
    }

    public function down(): void
    {
        Schema::table('email_batch_items', function (Blueprint $table) {
            $table->dropIndex('idx_batch_accepted');
            $table->dropUnique('uniq_accept_token');
            $table->dropColumn(['chosen_at', 'accepted_at', 'accept_token']);
        });
    }
};
