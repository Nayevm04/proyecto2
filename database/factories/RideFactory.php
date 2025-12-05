<?php

namespace Database\Factories;

use App\Models\Ride;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class RideFactory extends Factory
{
    protected $model = Ride::class;

    public function definition(): array
    {
        return [
            'nombre'            => $this->faker->sentence(3),
            'lugar_salida'      => $this->faker->city(),
            'lugar_llegada'     => $this->faker->city(),
            'fecha_hora'        => now()->addDays(2),
            'costo_espacio'     => 1500,
            'cantidad_espacios' => 3,
            'vehiculo_id'       => Vehiculo::factory()->create()->id,
            'user_id'           => User::factory()->create()->id,
        ];
    }
}

