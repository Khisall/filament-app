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
        Schema::create('compressors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('resource_type')->nullable();
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->string('equipment_name');
            $table->string('month');
            $table->string('upload')->nullable();
            $table->string('code');
            $table->string('activity');
            $table->string('requirement');
            $table->string('tools');
            $table->string('who');
            $table->string('interval');
            $table->integer('time');
            $table->json('daily_checks')->nullable(); // Menyimpan hasil cek harian sebagai array JSON
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compressors');
    }
};
