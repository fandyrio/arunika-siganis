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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('id_penulis');
            $table->string('foto_penulis');
            $table->string('judul');
            $table->string('kategori_artikel_kode');
            $table->string('edoc_artikel');
            $table->text('tentang_artikel');
            $table->integer('step');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
