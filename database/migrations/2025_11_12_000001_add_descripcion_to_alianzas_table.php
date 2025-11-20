<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('alianzas') && !Schema::hasColumn('alianzas', 'descripcion')) {
            Schema::table('alianzas', function (Blueprint $table) {
                $table->text('descripcion')->nullable()->after('enlace');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('alianzas') && Schema::hasColumn('alianzas', 'descripcion')) {
            Schema::table('alianzas', function (Blueprint $table) {
                $table->dropColumn('descripcion');
            });
        }
    }
};
