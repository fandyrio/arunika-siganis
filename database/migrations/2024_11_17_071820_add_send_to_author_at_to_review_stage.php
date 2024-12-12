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
        Schema::table('review_stage', function (Blueprint $table) {
            $table->datetime('send_author_at')->after('edoc_perbaikan_penulis')->nullable();
            $table->string('send_by')->after('send_author_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_stage', function (Blueprint $table) {
            //
        });
    }
};
