<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivarCuentaMailable;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesar registro.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'            => ['required', 'string', 'max:255'],
            'apellido'          => ['required', 'string', 'max:255'],
            'cedula'            => ['required', 'string', 'max:50', 'unique:users'],
            'fecha_nacimiento'  => ['required', 'date'],
            'telefono'          => ['required', 'string', 'max:50'],
            'fotografia'        => ['nullable', 'image', 'max:2048'],
            'rol'               => ['required', 'in:chofer,pasajero'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Guardar fotografía si existe
        $fotoPath = null;
        if ($request->hasFile('fotografia')) {
            $fotoPath = $request->file('fotografia')->store('usuarios', 'public');
        }

        // Crear token de activación
        $token = Str::random(60);

        // Crear usuario
        $user = User::create([
            'nombre'            => $request->nombre,
            'apellido'          => $request->apellido,
            'cedula'            => $request->cedula,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'telefono'          => $request->telefono,
            'fotografia'        => $fotoPath,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),

            'rol'               => $request->rol,
            'estado'            => 'Pendiente',
            'activation_token'  => $token,
        ]);

        event(new Registered($user));

        // Enviar correo de activación
        $url = route('activar.cuenta', ['token' => $token]);
        Mail::to($user->email)->send(new ActivarCuentaMailable($user, $url));

        // NO iniciar sesión
        return redirect()->route('login')
            ->with('status', 'Cuenta creada. Revisa tu correo para activarla.');
    }
}
