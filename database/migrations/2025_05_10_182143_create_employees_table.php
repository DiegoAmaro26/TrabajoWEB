<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->string('full_name');
            $table->enum('role', ['veterinario', 'auxiliar', 'administrativo']);
            $table->string('email');
            $table->string('phone');
            $table->string('photo')->nullable(); // Ruta o URL de la foto
            $table->timestamps();

            $table->foreign('hospital_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
