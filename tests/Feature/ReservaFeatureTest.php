<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Ride;
use App\Models\Reserva;

class ReservaFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pasajero_puede_crear_una_reserva()
    {
        $pasajero = User::factory()->create(['rol' => 'pasajero']);
        $ride = Ride::factory()->create(['cantidad_espacios' => 3]);

        $this->actingAs($pasajero);

        $response = $this->post("/reservar/{$ride->id}", []);

        $this->assertDatabaseHas('reservas', ['ride_id' => $ride->id]);
    }

    /** @test */
    public function pasajero_puede_cancelar_reserva()
    {
        $pasajero = User::factory()->create(['rol' => 'pasajero']);
        $ride = Ride::factory()->create(['cantidad_espacios' => 3]);

        $reserva = Reserva::factory()->create([
            'ride_id' => $ride->id,
            'user_id' => $pasajero->id,
            'estado' => 'Pendiente'
        ]);

        $this->actingAs($pasajero);

        $response = $this->post("/reservas/{$reserva->id}/cancelar");

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'Cancelada'
        ]);
    }
}
