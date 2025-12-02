<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Ride;

class ChoferDashboardController extends Controller
{
    public function index()
    {
        // Vehículos del chofer
        $vehiculos = Vehiculo::where('user_id', auth()->id())->get();

        // Rides del chofer
        $rides = Ride::where('user_id', auth()->id())
                     ->with('vehiculo')
                     ->get();

        return view('dashboard.chofer', compact('vehiculos', 'rides'));
    }
}
