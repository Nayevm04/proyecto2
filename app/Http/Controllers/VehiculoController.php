<?php

namespace App\Http\Controllers;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = Vehiculo::all(); 
        return view('vehiculos.index', compact('vehiculos')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehiculos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $validated = $request->validate([ 
            'placa' => 'required', 
            'marca' => 'required', 
            'modelo' => 'required', 
            'anio' => 'required', 
            'color' => 'required', 
            'capacidad' => 'required|integer', 
            'fotografia' => 'nullable|image' 
    ]); 
    if ($request->hasFile('fotografia')) { 
        $ruta = $request->file('fotografia')->store('vehiculos', 
'public'); 
        $validated['fotografia'] = $ruta; 
    } 
    Vehiculo::create($validated); 
    return redirect()->route('vehiculos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id); 
        return view('vehiculos.edit', compact('vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehiculo $vehiculo)

    {
        $validated = $request->validate([ 
        'placa' => 'required', 
        'marca' => 'required', 
        'modelo' => 'required', 
        'anio' => 'required', 
        'color' => 'required', 
        'capacidad' => 'required|integer', 
        'fotografia' => 'nullable|image' 
    ]); 
    if ($request->hasFile('fotografia')) { 
        $ruta = $request->file('fotografia')->store('vehiculos', 
'public'); 
        $validated['fotografia'] = $ruta; 
    } 
    $vehiculo->update($validated); 
    return redirect()->route('vehiculos.index');
    }

    /**
     * Remove the specified resource from storages.
     */
    public function destroy(Vehiculo $vehiculo)

    {
         $vehiculo->delete();
         return redirect()->route('vehiculos.index'); 
    }
}
