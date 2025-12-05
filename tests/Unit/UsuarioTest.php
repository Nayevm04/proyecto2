<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UsuarioTest extends TestCase
{
    /** @test */
    public function usuario_tiene_rol_correcto()
    {
        $user = new User(['rol' => 'chofer']);

        $this->assertEquals('chofer', $user->rol);
    }
}
