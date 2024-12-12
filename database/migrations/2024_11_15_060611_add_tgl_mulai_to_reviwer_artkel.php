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
        Schema::table('reviewer_artikel', function (Blueprint $table) {
            $table->date('tgl_mulai')->after('tgl_pilih');
            $table->date('tgl_estimasi_selesai')->after('tgl_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviwer_artkel', function (Blueprint $table) {
            //
        });
    }
};
