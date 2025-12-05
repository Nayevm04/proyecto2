<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        // Obtener usuarios según rol
        $admins    = User::where('rol', 'admin')->get();
        $choferes  = User::where('rol', 'chofer')->get();
        $pasajeros = User::where('rol', 'pasajero')->get();

        // Enviar datos al dashboard
        return view('dashboard.superadmin', compact(
            'admins',
            'choferes',
            'pasajeros'
        ));
    }
}
