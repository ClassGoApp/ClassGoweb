<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slot_bookings', function (Blueprint $table) {
            // Si ya existe en prod y solo quieres asegurar, NO uses esto.
            $table->string('meeting_link', 255)->nullable()->after('calendar_event_id');
        });
    }

    public function down(): void
    {
        Schema::table('slot_bookings', function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
};