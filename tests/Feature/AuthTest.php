<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_registrarse()
    {
        $response = $this->post('/register', [
            'nombre' => 'Fiorella',
            'apellido' => 'Lazo',
            'cedula' => '123456789',
            'fecha_nacimiento' => '2000-01-01',
            'telefono' => '88888888',
            'email' => 'fiore@test.com',
            'rol' => 'pasajero',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseHas('users', ['email' => 'fiore@test.com']);
    }

    /** @test */
    public function usuario_puede_iniciar_sesion()
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('12345678')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }
}
