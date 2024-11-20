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
        Schema::create('sprinkler_pump_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('resource_type')->nullable();
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->string('equipment_name');
            $table->string('month');
            $table->string('photo')->nullable();
            $table->string('code');
            $table->text('activity');
            $table->text('requirement');
            $table->string('tools');
            $table->string('who');
            $table->string('interval');
            $table->integer('time');
            $table->json('daily_checks')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprinkler_pump_systems');
    }
};
