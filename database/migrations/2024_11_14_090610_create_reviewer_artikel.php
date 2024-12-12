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
        Schema::create('reviewer_artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai');
            $table->integer('id_artikel');
            $table->datetime('tgl_pilih');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_artikel');
    }
};
