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
        Schema::create('issue_artikel', function (Blueprint $table) {
            $table->id();
            $table->string('code_issue');
            $table->string('name');
            $table->text('description');
            $table->integer('year');
            $table->string('flyer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volume_artikel');
    }
};
