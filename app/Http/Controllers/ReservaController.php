<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // ============================================
    // PASAJERO: formulario para reservar un ride
    // ============================================
    public function crear($ride_id)
    {
        $ride = Ride::findOrFail($ride_id);

        return view('reservas.create', compact('ride'));
    }

    // ============================================
    // PASAJERO: guardar la reserva
    // ============================================
    public function store(Request $request, $ride_id)
    {
        $ride = Ride::findOrFail($ride_id);

        // VALIDAR QUE AÚN HAY ESPACIOS
        if ($ride->cantidad_espacios <= 0) {
            return back()->with('error', 'Este ride ya no tiene espacios disponibles.');
        }

        // VALIDAR QUE NO SE AUTO-RESERVE
        if ($ride->user_id == auth()->id()) {
            return back()->with('error', 'No puedes reservar un ride que tú mismo creaste.');
        }

        // VALIDAR SI YA EXISTE UNA RESERVA
        $yaReservado = Reserva::where('ride_id', $ride->id)
        ->where('user_id', auth()->id())
        ->whereIn('estado', ['Pendiente', 'Aceptada'])
        ->first();

        if ($yaReservado) {
            return back()->with('error', 'Ya tienes una reserva activa en este ride.');
        }       

        // CREAR RESERVA
        Reserva::create([
            'ride_id' => $ride->id,
            'user_id' => auth()->id(),
            'estado'  => 'Pendiente'
        ]);

        // RESTAR UN ESPACIO
        $ride->cantidad_espacios -= 1;
        $ride->save();

        return redirect()->route('dashboard.pasajero')
            ->with('success', 'Reserva enviada correctamente al chofer.');
    }

    // ============================================
    // PASAJERO CANCELA RESERVA
    // ============================================
    public function cancelar($id)
{
    $reserva = Reserva::findOrFail($id);

    $usuario = auth()->id();

    $esPasajero = $reserva->user_id == $usuario;
    $esChofer   = $reserva->ride->user_id == $usuario;

    // Validar que quien cancela sea pasajero o chofer
    if (! $esPasajero && ! $esChofer) {
        return back()->with('error', 'No tienes permiso para cancelar esta reserva.');
    }

    // Reponer espacio si estaba pendiente o aceptada
    if (in_array($reserva->estado, ['Pendiente', 'Aceptada'])) {
        $ride = $reserva->ride;
        $ride->cantidad_espacios++;
        $ride->save();
    }

    $reserva->estado = 'Cancelada';
    $reserva->save();

    return back()->with('success', 'Reserva cancelada correctamente.');
}


    // ============================================
    // CHOFER ACEPTA RESERVA
    // ============================================
    public function aceptar($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->ride->user_id != auth()->id()) {
            return back()->with('error', 'No puedes aceptar esta reserva.');
        }

        $reserva->estado = 'Aceptada';
        $reserva->save();

        return back()->with('success', 'Reserva aceptada correctamente.');
    }

    // ============================================
    // CHOFER RECHAZA RESERVA
    // ============================================
    public function rechazar($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->ride->user_id != auth()->id()) {
            return back()->with('error', 'No puedes rechazar esta reserva.');
        }

        // devolver espacio
        $ride = $reserva->ride;
        $ride->cantidad_espacios++;
        $ride->save();

        $reserva->estado = 'Rechazada';
        $reserva->save();

        return back()->with('success', 'Reserva rechazada correctamente.');
    }
}



