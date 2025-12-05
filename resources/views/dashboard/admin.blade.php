@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Dashboard del Administrador</h1>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3 mb-4 bg-red-200 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif


    {{-- ====================== --}}
    {{-- TABLA DE CHOFERES --}}
    {{-- ====================== --}}
    <h2 class="text-2xl font-semibold mb-3">Choferes</h2>

    @include('dashboard.tabla_usuarios', [
        'usuarios' => $choferes,
        'rutaActivar' => 'admin.usuarios.activar',
        'rutaDesactivar' => 'admin.usuarios.desactivar'
    ])


    {{-- ====================== --}}
    {{-- TABLA DE PASAJEROS --}}
    {{-- ====================== --}}
    <h2 class="text-2xl font-semibold mt-10 mb-3">Pasajeros</h2>

    @include('dashboard.tabla_usuarios', [
        'usuarios' => $pasajeros,
        'rutaActivar' => 'admin.usuarios.activar',
        'rutaDesactivar' => 'admin.usuarios.desactivar'
    ])

</div>

@endsection


