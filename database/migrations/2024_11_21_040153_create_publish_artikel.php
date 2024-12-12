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
        Schema::create('publish_artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('id_artikel');
            $table->string('judul');
            $table->string('penulis');
            $table->string('satker_penulis');
            $table->text('text_tulisan');
            $table->integer('step');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publish_artikel');
    }
};
