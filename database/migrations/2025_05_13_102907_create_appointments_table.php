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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id')->nullable();  // Puede no estar registrada
            $table->unsignedBigInteger('employee_id'); // Veterinario o personal que atenderá
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('attended')->default(false); // Si la cita ha sido atendida
            $table->timestamps();

            // Foreign keys
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
