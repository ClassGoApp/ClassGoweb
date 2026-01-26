<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_subject_slots', function (Blueprint $table) {
            $table->index(['user_id', 'date', 'start_time', 'end_time'], 'idx_slots_user_date_time');
        });
    }

    public function down(): void
    {
        Schema::table('user_subject_slots', function (Blueprint $table) {
            $table->dropIndex('idx_slots_user_date_time');
        });
    }
};
