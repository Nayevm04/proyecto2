<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Ride;
use App\Models\Reserva;

class ChoferDashboardController extends Controller
{
    public function index()
    {
        // VEHÍCULOS DEL CHOFER
        $vehiculos = Vehiculo::where('user_id', auth()->id())->get();

        // RIDES DEL CHOFER
        $rides = Ride::where('user_id', auth()->id())
                     ->with('vehiculo')
                     ->orderBy('fecha_hora', 'asc')
                     ->get();

        // RESERVAS DEL CHOFER (todas)
$reservas = Reserva::whereHas('ride', function($q) {
        $q->where('user_id', auth()->id());
    })
    ->with(['ride', 'pasajero'])
    ->orderBy('created_at', 'desc')
    ->get();

return view('dashboard.chofer', compact(
    'vehiculos',
    'rides',
    'reservas'
        ));
    }
}
