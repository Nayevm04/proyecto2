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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            // Pasajero que reserva
            $table->unsignedBigInteger('user_id');

            // Ride reservado
            $table->unsignedBigInteger('ride_id');

            // Estado de la reserva
            $table->enum('estado', ['Pendiente', 'Aceptada', 'Rechazada', 'Cancelada'])
                  ->default('Pendiente');

            $table->timestamps();

            // Relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
