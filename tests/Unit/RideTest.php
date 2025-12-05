<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ride;

class RideTest extends TestCase
{
    /** @test */
    public function ride_tiene_espacios_disponibles_correctos()
    {
        $ride = new Ride([
            'cantidad_espacios' => 5
        ]);

        $this->assertEquals(5, $ride->cantidad_espacios);
    }
}
