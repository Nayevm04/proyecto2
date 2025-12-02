<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    $request->session()->regenerate();

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Redireccionar según el rol
    switch ($user->rol) {
    case 'superadmin':
        return redirect()->route('dashboard.superadmin');

    case 'admin':
        return redirect()->route('dashboard.admin');

    case 'chofer':
        return redirect()->route('dashboard.chofer');

    case 'pasajero':
        return redirect()->route('dashboard.pasajero');

    default:
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Tu cuenta no tiene un rol válido.',
        ]);
}

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    // Redirigir al login (ruta nombre 'login' que Breeze registra)
    return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
    }
}
