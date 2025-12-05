<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class PasajeroDashboardController extends Controller
{
    public function index()
    {
        // RESERVAS ACTIVAS (pendiente o aceptada)
        $reservas_activas = Reserva::where('user_id', auth()->id())
            ->whereIn('estado', ['Pendiente', 'Aceptada'])
            ->with('ride')
            ->orderBy('created_at', 'desc')
            ->get();

        // HISTORIAL (rechazada o cancelada)
        $reservas_historial = Reserva::where('user_id', auth()->id())
            ->whereIn('estado', ['Rechazada', 'Cancelada'])
            ->with('ride')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.pasajero', compact(
            'reservas_activas',
            'reservas_historial'
        ));
    }
}

