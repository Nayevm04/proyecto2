<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Ride;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),   // crea automáticamente un pasajero
            'ride_id' => Ride::factory(),   // crea automáticamente un ride válido
            'estado'  => 'pendiente',       // valor por defecto para las pruebas
        ];
    }
}

