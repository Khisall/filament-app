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
        Schema::create('security_patrols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->string('area_main');
            $table->string('area_name');
            $table->text('check_description_en')->nullable();
            $table->text('check_description_id')->nullable();
            $table->enum('status', ['OK', 'NG']);
            $table->string('shift');
            $table->string('time');
            $table->dateTime('checked_at');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_patrols');
    }
};
