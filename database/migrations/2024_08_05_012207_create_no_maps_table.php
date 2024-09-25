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
        Schema::create('no_maps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('code');
            $table->string('type');
            $table->string('capacity');
            $table->string('exfire_location');
            $table->string('duedate');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('no_maps');
    }
};