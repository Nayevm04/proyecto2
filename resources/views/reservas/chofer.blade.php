@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

   <h2 class="text-2xl font-bold mt-10 mb-4">Reservas Recibidas</h2>

<div class="bg-white shadow-md rounded-lg overflow-hidden mb-12">
    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="py-3 px-4">Ride</th>
                <th class="py-3 px-4">Pasajero</th>
                <th class="py-3 px-4">Fecha</th>
                <th class="py-3 px-4">Estado</th>
                <th class="py-3 px-4">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reservas as $reserva)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $reserva->ride->nombre }}</td>

                    <td class="py-3 px-4">
                        {{ $reserva->pasajero->nombre ?? $reserva->pasajero->email }}
                    </td>

                    <td class="py-3 px-4">
                        {{ \Carbon\Carbon::parse($reserva->ride->fecha_hora)->format('d/m/Y H:i') }}
                    </td>

                    <td class="py-3 px-4 font-semibold">
                        @switch($reserva->estado)
                            @case('Pendiente')
                                <span class="text-yellow-600">Pendiente</span>
                                @break

                            @case('Aceptada')
                                <span class="text-green-600">Aceptada</span>
                                @break

                            @case('Rechazada')
                                <span class="text-red-600">Rechazada</span>
                                @break

                            @case('Cancelada')
                                <span class="text-gray-600">Cancelada</span>
                                @break
                        @endswitch
                    </td>

                    <td class="py-3 px-4 space-x-2 text-sm">

                        {{-- SOLO si está pendiente --}}
                        @if($reserva->estado === 'Pendiente')

                            <form action="{{ route('reservas.aceptar', $reserva->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">
                                    Aceptar
                                </button>
                            </form>

                            <form action="{{ route('reservas.rechazar', $reserva->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button class="text-red-600 hover:underline">
                                    Rechazar
                                </button>
                            </form>

                        @endif

                        {{-- Cancelar SIEMPRE (excepto si ya está cancelada o rechazada) --}}
                        @if(!in_array($reserva->estado, ['Cancelada','Rechazada']))
                            <form action="{{ route('reservas.cancelar', $reserva->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button class="text-gray-600 hover:underline"
                                        onclick="return confirm('¿Cancelar esta reserva?')">
                                    Cancelar
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">
                        No tienes reservas aún.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>

</div>

@endsection
