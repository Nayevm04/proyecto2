@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">

    <h1 class="text-2xl font-bold mb-4">Crear nuevo Administrador</h1>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            <p class="font-semibold mb-2">Por favor corrige los siguientes errores:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('superadmin.admins.guardar') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @csrf

        {{-- Nombre --}}
        <div>
            <label class="block font-semibold mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Apellido --}}
        <div>
            <label class="block font-semibold mb-1">Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Cédula --}}
        <div>
            <label class="block font-semibold mb-1">Cédula</label>
            <input type="text" name="cedula" value="{{ old('cedula') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Fecha de nacimiento --}}
        <div>
            <label class="block font-semibold mb-1">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Teléfono --}}
        <div>
            <label class="block font-semibold mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-semibold mb-1">Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Contraseña --}}
        <div>
            <label class="block font-semibold mb-1">Contraseña</label>
            <input type="password" name="password"
                   class="w-full border rounded p-2">
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label class="block font-semibold mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded p-2">
        </div>

        {{-- Fotografía (opcional) --}}
        <div class="sm:col-span-2">
            <label class="block font-semibold mb-1">Fotografía (opcional)</label>
            <input type="file" name="fotografia"
                   class="w-full border rounded p-2">
        </div>

        {{-- Botones --}}
        <div class="sm:col-span-2 flex justify-between mt-4">
            <a href="{{ route('dashboard.superadmin') }}"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Crear Administrador
            </button>
        </div>

    </form>

</div>

@endsection
