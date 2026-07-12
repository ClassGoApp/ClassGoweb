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
        Schema::table('slot_bookings', function (Blueprint $table) {
            $table->text('supporting_material')->nullable();
            $table->longText("description")->nullable();
            $table->string("originName")->nullable();
            $table->string("extencion")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slot_bookings', function (Blueprint $table) {
            $table->dropColumn('supporting_material');
            $table->dropColumn('description');
            $table->dropColumn('extencion');
            $table->dropColumn('originName');
        });
    }


};