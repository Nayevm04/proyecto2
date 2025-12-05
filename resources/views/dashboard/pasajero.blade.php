@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Dashboard del Pasajero</h1>

    {{-- LINK A PÁGINA PÚBLICA DE RIDES --}}
    <div class="mb-6">
        <a href="{{ route('rides.public') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Ver Rides Disponibles
        </a>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- ========================= --}}
    {{-- RESERVAS ACTIVAS          --}}
    {{-- ========================= --}}
    <h2 class="text-2xl font-bold mb-3">Reservas Activas</h2>

    <div class="bg-white shadow-md rounded mb-8 overflow-hidden">

        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Ride</th>
                    <th class="px-4 py-3 text-left">Salida</th>
                    <th class="px-4 py-3 text-left">Llegada</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservas_activas as $reserva)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $reserva->ride->nombre }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->lugar_salida }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->lugar_llegada }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->fecha_hora }}</td>
                        <td class="px-4 py-3 capitalize">
                            <strong class="
                                {{ $reserva->estado == 'pendiente' ? 'text-yellow-600' : '' }}
                                {{ $reserva->estado == 'aceptada' ? 'text-green-600' : '' }}
                                {{ $reserva->estado == 'rechazada' ? 'text-red-600' : '' }}
                            ">
                                {{ $reserva->estado }}
                            </strong>
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{-- CANCELAR — disponible SIEMPRE --}}
                            <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST"
                                  onsubmit="return confirm('¿Cancelar esta reserva?')">
                                @csrf
                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-gray-500">No tienes reservas activas.</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- ========================= --}}
    {{-- HISTORIAL DE RESERVAS    --}}
    {{-- ========================= --}}
    <h2 class="text-2xl font-bold mb-3">Historial de Reservas</h2>

    <div class="bg-white shadow-md rounded overflow-hidden">

        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Ride</th>
                    <th class="px-4 py-3 text-left">Salida</th>
                    <th class="px-4 py-3 text-left">Llegada</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservas_historial as $reserva)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $reserva->ride->nombre }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->lugar_salida }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->lugar_llegada }}</td>
                        <td class="px-4 py-3">{{ $reserva->ride->fecha_hora }}</td>
                        <td class="px-4 py-3 capitalize">
                            <strong class="
                                {{ $reserva->estado == 'pendiente' ? 'text-yellow-600' : '' }}
                                {{ $reserva->estado == 'aceptada' ? 'text-green-600' : '' }}
                                {{ $reserva->estado == 'rechazada' ? 'text-red-600' : '' }}
                                {{ $reserva->estado == 'cancelada' ? 'text-gray-500' : '' }}
                            ">
                                {{ $reserva->estado }}
                            </strong>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-gray-500">No hay reservas en el historial.</td></tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection

