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
        Schema::table('subject_groups', function (Blueprint $table) {
            // parent reference, nullable
            $table->unsignedBigInteger('id_padre')->nullable()->after('deleted_at');

            // index/foreign key same as in original SQL definition
            $table->index('id_padre', 'fk_subject_groups_padre');
            $table->foreign('id_padre', 'fk_subject_groups_padre')
                  ->references('id')
                  ->on('subject_groups')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subject_groups', function (Blueprint $table) {
            // drop foreign key and index before the column
            $table->dropForeign('fk_subject_groups_padre');
            $table->dropIndex('fk_subject_groups_padre');
            $table->dropColumn('id_padre');
        });
    }
};
