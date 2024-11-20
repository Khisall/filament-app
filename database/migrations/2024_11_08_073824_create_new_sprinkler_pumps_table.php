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
        Schema::create('new_sprinkler_pumps', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('code');
            $table->string('activity');
            $table->string('requirement');
            $table->string('tools');
            $table->string('who');
            $table->string('interval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_sprinkler_pumps');
    }
};
