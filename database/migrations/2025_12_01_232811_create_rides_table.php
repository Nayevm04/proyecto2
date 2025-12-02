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
        Schema::create('rides', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('lugar_salida');
        $table->string('lugar_llegada');
        $table->dateTime('fecha_hora');
        $table->decimal('costo_espacio', 10, 2);
        $table->integer('cantidad_espacios');
        
        // Relación con vehículo
        $table->unsignedBigInteger('vehiculo_id');
        $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

        // Relación con chofer (usuario)
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
