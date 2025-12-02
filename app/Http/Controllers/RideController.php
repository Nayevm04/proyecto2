<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::where('user_id', auth()->id())
                     ->with('vehiculo')
                     ->get();

        return view('rides.index', compact('rides'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::where('user_id', auth()->id())->get();

        return view('rides.create', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        // 1) Validación básica de campos con nombres IGUALES a la vista
        $validated = $request->validate(
            [
                'nombre'            => 'required|string|max:255',
                'lugar_salida'      => 'required|string|max:255',
                'lugar_llegada'     => 'required|string|max:255',
                'fecha_hora'        => 'required|date',
                'costo_espacio'     => 'required|numeric|min:0',
                'cantidad_espacios' => 'required|integer|min:1',
                'vehiculo_id'       => 'required|exists:vehiculos,id',
            ],
            [
                'required' => 'El campo :attribute es obligatorio.',
                'numeric'  => 'El campo :attribute debe ser numérico.',
                'integer'  => 'El campo :attribute debe ser un número entero.',
                'date'     => 'El campo :attribute debe ser una fecha y hora válida.',
                'exists'   => 'El :attribute seleccionado no es válido.',
                'min'      => 'El campo :attribute debe ser mayor o igual que :min.',
            ],
            [
                'nombre'            => 'nombre del ride',
                'lugar_salida'      => 'lugar de salida',
                'lugar_llegada'     => 'lugar de llegada',
                'fecha_hora'        => 'día y hora',
                'costo_espacio'     => 'costo por espacio',
                'cantidad_espacios' => 'cantidad de espacios',
                'vehiculo_id'       => 'vehículo asociado',
            ]
        );

        // 2) Verificar que el vehículo pertenezca al chofer autenticado
        $vehiculo = Vehiculo::where('id', $validated['vehiculo_id'])
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        // 3) Validar que la cantidad de espacios no supere la capacidad del vehículo
        if ($validated['cantidad_espacios'] > $vehiculo->capacidad) {
            return back()
                ->withErrors([
                    'cantidad_espacios' => 'La cantidad de espacios es superior a la capacidad del vehículo seleccionado.',
                ])
                ->withInput();
        }

        // 4) Validar que no exista otro ride con MISMO vehículo + MISMA fecha/hora
        $existeRide = Ride::where('user_id', auth()->id())
            ->where('vehiculo_id', $validated['vehiculo_id'])
            ->where('fecha_hora', $validated['fecha_hora'])
            ->exists();

        if ($existeRide) {
            return back()
                ->withErrors([
                    'fecha_hora' => 'Ya existe un ride con este vehículo en la misma fecha y hora.',
                ])
                ->withInput();
        }

        // 5) Guardar el ride
        $validated['user_id'] = auth()->id();

        Ride::create($validated);

        return redirect()
            ->route('dashboard.chofer')
            ->with('status', 'Ride creado correctamente.');
    }

    public function edit(Ride $ride)
    {
        // Solo permitir editar rides del chofer logueado
        if ($ride->user_id !== auth()->id()) {
            abort(403);
        }

        $vehiculos = Vehiculo::where('user_id', auth()->id())->get();

        return view('rides.edit', compact('ride', 'vehiculos'));
    }

    public function update(Request $request, Ride $ride)
    {
        if ($ride->user_id !== auth()->id()) {
            abort(403);
        }

        // 1) Validación básica
        $validated = $request->validate(
            [
                'nombre'            => 'required|string|max:255',
                'lugar_salida'      => 'required|string|max:255',
                'lugar_llegada'     => 'required|string|max:255',
                'fecha_hora'        => 'required|date',
                'costo_espacio'     => 'required|numeric|min:0',
                'cantidad_espacios' => 'required|integer|min:1',
                'vehiculo_id'       => 'required|exists:vehiculos,id',
            ],
            [
                'required' => 'El campo :attribute es obligatorio.',
                'numeric'  => 'El campo :attribute debe ser numérico.',
                'integer'  => 'El campo :attribute debe ser un número entero.',
                'date'     => 'El campo :attribute debe ser una fecha y hora válida.',
                'exists'   => 'El :attribute seleccionado no es válido.',
                'min'      => 'El campo :attribute debe ser mayor o igual que :min.',
            ],
            [
                'nombre'            => 'nombre del ride',
                'lugar_salida'      => 'lugar de salida',
                'lugar_llegada'     => 'lugar de llegada',
                'fecha_hora'        => 'día y hora',
                'costo_espacio'     => 'costo por espacio',
                'cantidad_espacios' => 'cantidad de espacios',
                'vehiculo_id'       => 'vehículo asociado',
            ]
        );

        // 2) Confirmar que el vehículo es del chofer actual
        $vehiculo = Vehiculo::where('id', $validated['vehiculo_id'])
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        // 3) Validar capacidad del vehículo
        if ($validated['cantidad_espacios'] > $vehiculo->capacidad) {
            return back()
                ->withErrors([
                    'cantidad_espacios' => 'La cantidad de espacios es superior a la capacidad del vehículo seleccionado.',
                ])
                ->withInput();
        }

        // 4) Validar conflicto con otro ride mismo vehículo + misma fecha/hora
        $existeRide = Ride::where('user_id', auth()->id())
            ->where('vehiculo_id', $validated['vehiculo_id'])
            ->where('fecha_hora', $validated['fecha_hora'])
            ->where('id', '!=', $ride->id) // ignorar el mismo ride
            ->exists();

        if ($existeRide) {
            return back()
                ->withErrors([
                    'fecha_hora' => 'Ya existe un ride con este vehículo en la misma fecha y hora.',
                ])
                ->withInput();
        }

        // 5) Actualizar
        $ride->update($validated);

        return redirect()
            ->route('dashboard.chofer')
            ->with('status', 'Ride actualizado correctamente.');
    }

    public function destroy(Ride $ride)
    {
        if ($ride->user_id !== auth()->id()) {
            abort(403);
        }

        $ride->delete();

        return redirect()
            ->route('dashboard.chofer')
            ->with('status', 'Ride eliminado correctamente.');
    }
}
