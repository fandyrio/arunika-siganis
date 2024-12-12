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
        Schema::create('penulis_artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai');
            $table->string('nama');
            $table->string('nip');
            $table->string('no_handphone');
            $table->string('satker');
            $table->string('jabatan');
            $table->string('pangkat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_penulis');
    }
};
