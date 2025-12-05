<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reserva;

class ReservaTest extends TestCase
{
    /** @test */
    public function reserva_puede_cambiar_de_estado()
    {
        $reserva = new Reserva(['estado' => 'Pendiente']);

        $reserva->estado = 'Aceptada';

        $this->assertEquals('Aceptada', $reserva->estado);
    }
}
