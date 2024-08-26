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
            $table->foreignId('no_map_id')->constrained()->cascadeOnDelete();
            $table->foreignId('types_id')->default(1)->constrained()->cascadeOnDelete();
            $table->foreignId('capacities_id')->default(1)->constrained()->cascadeOnDelete();
            $table->foreignId('exfire_locations_id')->default(1)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('duedates_id')->default(1);
            $table->foreignId('years_id')->default(1)->constrained()->cascadeOnDelete();
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            //$table->unique(['no_map_id', 'maintenance_id']);
            $table->string('name');
            $table->string('hose');
            $table->string('hose_remark')->nullable();
            $table->string('seal_pin');
            $table->string('sealpin_remark')->nullable();
            $table->string('pressure');
            $table->string('indicator_condition');
            $table->string('indicator_remark')->nullable();
            $table->string('tube_condition');
            $table->string('tube_remark')->nullable();
            $table->date('date_of_checking');
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
