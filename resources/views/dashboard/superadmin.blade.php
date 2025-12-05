@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Título --}}
    <h1 class="text-3xl font-bold mb-6">Dashboard del Superadmin</h1>

    {{-- Mensajes de éxito o error --}}
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


    {{-- ===================================================== --}}
    {{-- BOTONES SUPERIORES --}}
    {{-- ===================================================== --}}
    <div class="flex items-center gap-4 mb-8">

        {{-- Crear Admin --}}
        <a href="{{ route('superadmin.admins.crear') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Crear nuevo Administrador
    </a>

        {{-- Ejecutar comando manualmente --}}
        <form action="{{ route('script.recordatorio') }}" method="POST">
            @csrf
            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Ejecutar Script de Recordatorios
            </button>
        </form>
    </div>


    {{-- ===================================================== --}}
    {{-- TABLA DE ADMINS --}}
    {{-- ===================================================== --}}
    <h2 class="text-2xl font-semibold mb-3">Administradores</h2>

    @include('dashboard.tabla_usuarios', ['usuarios' => $admins])


    {{-- ===================================================== --}}
    {{-- TABLA DE CHOFERES --}}
    {{-- ===================================================== --}}
    <h2 class="text-2xl font-semibold mt-10 mb-3">Choferes</h2>

    @include('dashboard.tabla_usuarios', ['usuarios' => $choferes])


    {{-- ===================================================== --}}
    {{-- TABLA DE PASAJEROS --}}
    {{-- ===================================================== --}}
    <h2 class="text-2xl font-semibold mt-10 mb-3">Pasajeros</h2>

    @include('dashboard.tabla_usuarios', ['usuarios' => $pasajeros])


</div>

@endsection


