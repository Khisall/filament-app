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
        Schema::create('emergency_lights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_emergency_light_id')->nullable();
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->string('year');
            $table->string('month');
            $table->date('date_of_checking');
            $table->string('map_no');
            $table->string('location');     
            $table->string('type_light');
            $table->string('condition');
            $table->string('remark');
            $table->string('photo')->nullable();
            $table->string('lt_name');
            $table->string('ae_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_lights');

        Schema::table('emergency_lights', function (Blueprint $table) {
            $table->dropColumn('new_emergency_light_id');
        });
    }
};
