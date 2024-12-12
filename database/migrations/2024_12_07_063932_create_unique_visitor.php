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
        Schema::create('unique_visitor', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('cookie_id');
            $table->string('device_info')->nullable();
            $table->datetime('last_access');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unique_visitor');
    }
};
