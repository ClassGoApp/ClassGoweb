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
    public function up() {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_group_id')->constrained()->onDelete('cascade');
            $table->string('name', 255)->fulltext();
            $table->text('description')->nullable()->fullText();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('subjects');
    }
};
