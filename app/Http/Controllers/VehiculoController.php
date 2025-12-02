<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Mostrar vehículos del chofer autenticado.
     */
    public function index()
    {
        $vehiculos = Vehiculo::where('user_id', auth()->id())->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Formulario para crear vehículo.
     */
    public function create()
    {
        return view('vehiculos.create');
    }

    /**
     * Guardar nuevo vehículo para el chofer autenticado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'placa'      => 'required',
            'marca'      => 'required',
            'modelo'     => 'required',
            'anio'       => 'required',
            'color'      => 'required',
            'capacidad'  => 'required|integer',
            'fotografia' => 'nullable|image'
        ]);

        // Asignar usuario dueño del vehículo
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('fotografia')) {
            $ruta = $request->file('fotografia')->store('vehiculos', 'public');
            $validated['fotografia'] = $ruta;
        }

        Vehiculo::create($validated);

        return redirect()->route('dashboard.chofer')
            ->with('status', 'Vehículo creado correctamente.');
    }

    /**
     * Formulario para editar un vehículo SOLO si pertenece al chofer.
     */
    public function edit(string $id)
    {
        $vehiculo = Vehiculo::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('vehiculos.edit', compact('vehiculo'));
    }

    /**
     * Actualizar vehículo solo si pertenece al chofer.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        // Verificar que el vehículo pertenece al usuario autenticado
        if ($vehiculo->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este vehículo.');
        }

        $validated = $request->validate([
            'placa'      => 'required',
            'marca'      => 'required',
            'modelo'     => 'required',
            'anio'       => 'required',
            'color'      => 'required',
            'capacidad'  => 'required|integer',
            'fotografia' => 'nullable|image'
        ]);

        if ($request->hasFile('fotografia')) {
            $ruta = $request->file('fotografia')->store('vehiculos', 'public');
            $validated['fotografia'] = $ruta;
        }

        $vehiculo->update($validated);

        return redirect()->route('dashboard.chofer')
            ->with('status', 'Vehículo actualizado correctamente.');
    }

    /**
     * Eliminar vehículo solo si pertenece al chofer.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        if ($vehiculo->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar este vehículo.');
        }

        $vehiculo->delete();

        return redirect()->route('dashboard.chofer')
            ->with('status', 'Vehículo eliminado correctamente.');
    }
}
