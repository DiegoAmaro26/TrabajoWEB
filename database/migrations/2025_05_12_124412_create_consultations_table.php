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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->string('type');
            $table->string('reason');
            $table->text('exploration');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->json('tests')->nullable(); // array de rutas a PDFs
            $table->timestamps();

            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
