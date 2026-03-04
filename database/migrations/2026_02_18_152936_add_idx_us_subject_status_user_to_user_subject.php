<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_subject', function (Blueprint $table) {
            $table->index(['subject_id', 'status', 'user_id'], 'idx_us_subject_status_user');
        });
    }

    public function down(): void
    {
        Schema::table('user_subject', function (Blueprint $table) {
            $table->dropIndex('idx_us_subject_status_user');
        });
    }
};
