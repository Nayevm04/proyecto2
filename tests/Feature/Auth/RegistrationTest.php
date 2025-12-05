<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
{
    $response = $this->post('/register', [
        'nombre' => 'Test',
        'apellido' => 'User',
        'cedula' => '123456789',
        'fecha_nacimiento' => '1990-01-01',
        'telefono' => '8888-8888',
        'rol' => 'pasajero',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login'));
}

}
