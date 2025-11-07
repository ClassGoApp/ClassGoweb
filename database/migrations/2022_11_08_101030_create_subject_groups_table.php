<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->fulltext();
            $table->text('description')->nullable()->fullText();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->softDeletes();
            // 🔗 Clave foránea que apunta a la misma tabla
            $table->foreignId('id_padre')
                ->nullable()
                ->constrained('subject_groups')
                ->nullOnDelete(); // Si se elimina el padre, el hijo queda sin referencia

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_groups');
    }
};
