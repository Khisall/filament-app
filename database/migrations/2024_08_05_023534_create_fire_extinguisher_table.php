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
        Schema::create('fire_extinguishers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('ex_locations_id')->constrained()->cascadeOnDelete();
            $table->foreignId('types_id')->constrained()->cascadeOnDelete();
            $table->string('capacity');
            $table->string('location');
            $table->string('due_date');
            $table->string('years');
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('hose');
            $table->string('seal_pin');
            $table->string('pressure');
            $table->string('indicator_condition');
            $table->string('remark');
            $table->string('date_of_checking');
            $table->string('upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_extinguishers');
    }
};
