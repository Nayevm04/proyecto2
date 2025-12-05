<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculoFactory extends Factory
{
    protected $model = Vehiculo::class;

    public function definition()
    {
        return [
            'user_id'   => User::factory()->create()->id,
            'placa'     => strtoupper($this->faker->bothify('???-####')),
            'marca'     => $this->faker->randomElement(['Toyota', 'Nissan', 'Hyundai', 'Kia']),
            'modelo'    => $this->faker->word(),
            'anio'      => $this->faker->numberBetween(2000, 2023),
            'color'     => $this->faker->safeColorName(),
            'capacidad' => 4, // puede ajustarse
            'fotografia'=> null,
        ];
    }
}


