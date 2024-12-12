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
        Schema::create('review_stage', function (Blueprint $table) {
            $table->id();
            $table->integer('id_artikel');
            $table->integer('review_ke');
            $table->text('catatan_reviewer');
            $table->string('edoc_catatan_reviewer');
            $table->string('catatan_penulis');
            $table->string('edoc_perbaikan_penulis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_stage');
    }
};
