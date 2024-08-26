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
        Schema::create('hose_reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            //$table->unique(['location_id', 'maintenance_id']);
            $table->index(['location_id', 'maintenance_id']);
            $table->string('name');
            $table->string('free_obstruction');
            $table->string('obstruction_remark')->nullable();
            $table->string('condition');
            $table->string('condition_remark')->nullable();
            $table->string('leakage');
            $table->string('leakage_remark')->nullable();
            $table->string('flush_test');
            $table->string('flush_remark')->nullable();
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
        Schema::dropIfExists('hose_reels');
    }
};
