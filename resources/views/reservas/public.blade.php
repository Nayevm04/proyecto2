@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-6 text-center">Rides Disponibles</h1>

    {{-- BOTÓN LOGIN SOLO SI EL USUARIO NO ESTÁ AUTENTICADO --}}
    @guest
        <div class="flex justify-center mb-6">
            <a href="{{ route('login') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Iniciar Sesión para Reservar
            </a>
        </div>
    @endguest


    {{-- =============================== --}}
    {{-- FORMULARIO DE FILTROS           --}}
    {{-- =============================== --}}
    <form method="GET" action="{{ route('rides.public') }}"
          class="bg-white p-4 rounded shadow mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">

        <input type="text" name="origen" placeholder="Filtrar por salida"
               value="{{ request('origen') }}"
               class="border p-2 rounded">

        <input type="text" name="destino" placeholder="Filtrar por llegada"
               value="{{ request('destino') }}"
               class="border p-2 rounded">

        <input type="date" name="fecha"
               value="{{ request('fecha') }}"
               class="border p-2 rounded">

        <select name="orden" class="border p-2 rounded">
            <option value="">Ordenar por</option>
            <option value="fecha"   {{ request('orden')=='fecha' ? 'selected':'' }}>Fecha</option>
            <option value="origen"  {{ request('orden')=='origen' ? 'selected':'' }}>Origen</option>
            <option value="destino" {{ request('orden')=='destino' ? 'selected':'' }}>Destino</option>
        </select>

        <button class="px-4 py-2 bg-gray-700 text-white rounded col-span-full">
            Aplicar Filtros
        </button>
    </form>


    {{-- =============================== --}}
    {{-- LISTA DE RIDES DISPONIBLES     --}}
    {{-- =============================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @forelse($rides as $ride)
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-xl font-bold mb-2">{{ $ride->nombre }}</h2>

            <p><strong>Salida:</strong> {{ $ride->lugar_salida }}</p>
            <p><strong>Llegada:</strong> {{ $ride->lugar_llegada }}</p>
            <p><strong>Fecha:</strong> {{ $ride->fecha_hora }}</p>
            <p><strong>Costo:</strong> ₡{{ $ride->costo_espacio }}</p>
            <p><strong>Espacios:</strong> {{ $ride->cantidad_espacios }}</p>

            <div class="mt-3">

                {{-- =============================== --}}
                {{-- USUARIO AUTENTICADO             --}}
                {{-- =============================== --}}
                @auth

                    {{-- SOLO PASAJEROS PUEDEN RESERVAR --}}
                    @if(auth()->user()->rol === 'pasajero')
                        <a href="{{ route('reservas.crear', $ride->id) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Reservar
                        </a>
                    @else
                        <p class="text-gray-600 text-sm">
                            Solo los pasajeros pueden reservar.
                        </p>
                    @endif

                @endauth

                {{-- =============================== --}}
                {{-- USUARIO NO AUTENTICADO          --}}
                {{-- =============================== --}}
                @guest
                    <p class="text-red-600 text-sm mt-2">
                        Debes iniciar sesión para reservar.
                    </p>
                @endguest

            </div>
        </div>

        @empty
            <p class="text-gray-500 text-center col-span-2">
                No hay rides disponibles.
            </p>
        @endforelse

    </div>

</div>

@endsection
