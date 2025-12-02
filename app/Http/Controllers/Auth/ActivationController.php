<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class ActivationController extends Controller
{
    public function activarCuenta($token)
    {
        // Buscar usuario por token
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('status', 'El enlace de activación no es válido o ya fue utilizado.');
        }

        // Activar usuario
        $user->estado = 'Activo';
        $user->activation_token = null; // eliminar token
        $user->save();

        // Redirigir según el rol del usuario
        return redirect()->route('login')->with('status', 'Cuenta activada, ya puedes iniciar sesión.');
    }
}
