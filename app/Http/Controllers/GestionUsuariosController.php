<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class GestionUsuariosController extends Controller
{
    /**
     * Mostrar el panel de gestión de usuarios para el Superadmin
     */
    public function index()
    {
        $admins    = User::where('rol', 'admin')->get();
        $choferes  = User::where('rol', 'chofer')->get();
        $pasajeros = User::where('rol', 'pasajero')->get();

        return view('dashboard.superadmin', compact(
            'admins',
            'choferes',
            'pasajeros'
        ));
    }

    /**
     * Mostrar formulario para crear un nuevo administrador
     */
    public function formularioCrearAdmin()
    {
        return view('dashboard.crear_admin');
    }

    /**
     * Guardar un nuevo administrador en la base de datos
     */
    public function guardarAdmin(Request $request)
    {
        $request->validate(
            [
                'nombre'             => 'required|string|max:255',
                'apellido'         => 'required|string|max:255',
                'cedula'           => 'required|string|max:50|unique:users,cedula',
                'fecha_nacimiento' => 'required|date',
                'telefono'         => 'required|string|max:50',
                'email'            => 'required|email|max:255|unique:users,email',
                'password'         => 'required|string|min:8|confirmed',
                'fotografia'       => 'nullable|image|max:2048',
            ]
        );

        $datos = $request->only([
            'nombre',
            'apellido',
            'cedula',
            'fecha_nacimiento',
            'telefono',
            'email',
        ]);

        // Manejo de fotografía
        if ($request->hasFile('fotografia')) {
            $ruta = $request->file('fotografia')->store('usuarios', 'public');
            $datos['fotografia'] = $ruta;
        }

        // Campos fijos para admin
        $datos['rol']    = 'admin';
        $datos['estado'] = 'Activo';
        $datos['password'] = Hash::make($request->input('password'));

        User::create($datos);

        return redirect()
            ->route('dashboard.superadmin')
            ->with('success', 'Administrador creado correctamente.');
    }


    /**
     * Activar usuario
     */
    public function activar($id)
{
    $usuario = User::findOrFail($id);
    $actual  = auth()->user();

    // Un admin NO puede modificar al superadmin
    if ($actual->rol === 'admin' && $usuario->rol === 'superadmin') {
        return back()->with('error', 'No puedes modificar al Superadmin.');
    }

    $usuario->estado = 'Activo';
    $usuario->save();

    return back()->with('success', 'El usuario fue activado correctamente.');
}


    /**
     * Desactivar usuario
     */
    public function desactivar($id)
{
    $usuario = User::findOrFail($id);
    $actual  = auth()->user();

    if ($actual->rol === 'admin' && $usuario->rol === 'superadmin') {
        return back()->with('error', 'No puedes modificar al Superadmin.');
    }

    $usuario->estado = 'Inactivo';
    $usuario->save();

    return back()->with('success', 'El usuario fue desactivado correctamente.');
}

}

