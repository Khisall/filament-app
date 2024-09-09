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
            $table->string('type'); // Add this column
            $table->string('capacity'); // Add this column
            $table->string('exfire_location'); // Add this column
            $table->string('duedate'); // Add this column
            $table->string('year'); // Add this column
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