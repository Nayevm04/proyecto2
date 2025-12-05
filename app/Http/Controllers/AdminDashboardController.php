<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Obtener solo choferes y pasajeros
        $choferes = User::where('rol', 'chofer')->get();

        // Pasajeros, excluyendo superadmin por si acaso
        $pasajeros = User::where('rol', 'pasajero')->get();

        return view('dashboard.admin', compact('choferes', 'pasajeros'));
    }

    public function activar($id)
    {
        $usuario = User::findOrFail($id);

        // Impedir activar al superadmin o admins
        if ($usuario->rol === 'superadmin' || $usuario->rol === 'admin') {
            return back()->with('error', 'No tienes permiso para modificar administradores.');
        }

        $usuario->estado = 'Activo';
        $usuario->save();

        return back()->with('success', 'Usuario activado correctamente.');
    }

    public function desactivar($id)
    {
        $usuario = User::findOrFail($id);

        // Impedir desactivar al superadmin o admins
        if ($usuario->rol === 'superadmin' || $usuario->rol === 'admin') {
            return back()->with('error', 'No tienes permiso para modificar administradores.');
        }

        $usuario->estado = 'Inactivo';
        $usuario->save();

        return back()->with('success', 'Usuario desactivado correctamente.');
    }
}

