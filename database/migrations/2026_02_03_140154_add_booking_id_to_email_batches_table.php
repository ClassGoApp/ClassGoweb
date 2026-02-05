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
            if (!Schema::hasColumn('email_batches', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('accepted_item_id');
                $table->index('booking_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_batches', function (Blueprint $table) {
            //
        });
    }
};
