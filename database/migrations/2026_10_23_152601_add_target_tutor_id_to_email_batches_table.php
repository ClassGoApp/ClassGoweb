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
        Schema::table('email_batches', function (Blueprint $table) {
            $table->unsignedBigInteger('target_tutor_id')->nullable()->after('created_by');
            $table->index('target_tutor_id');
            $table->foreign('target_tutor_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_batches', function (Blueprint $table) {
            $table->dropForeign(['target_tutor_id']);
            $table->dropIndex(['target_tutor_id']);
            $table->dropColumn('target_tutor_id');
        });
    }
};
