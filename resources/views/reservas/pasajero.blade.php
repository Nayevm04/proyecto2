@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Mis Reservas</h2>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded">

        <table class="min-w-full border">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-2 px-3 text-left">Ride</th>
                    <th class="py-2 px-3 text-left">Salida</th>
                    <th class="py-2 px-3 text-left">Llegada</th>
                    <th class="py-2 px-3 text-left">Fecha</th>
                    <th class="py-2 px-3 text-left">Estado</th>
                    <th class="py-2 px-3"></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reservas as $reserva)
                    <tr class="border-b">
                        <td class="py-2 px-3">{{ $reserva->ride->nombre }}</td>
                        <td class="py-2 px-3">{{ $reserva->ride->lugar_salida }}</td>
                        <td class="py-2 px-3">{{ $reserva->ride->lugar_llegada }}</td>
                        <td class="py-2 px-3">{{ $reserva->ride->fecha_hora }}</td>

                        <td class="py-2 px-3">
                            @if($reserva->estado === 'pendiente')
                                <span class="text-yellow-600 font-semibold">Pendiente</span>
                            @elseif($reserva->estado === 'aceptada')
                                <span class="text-green-600 font-semibold">Aceptada</span>
                            @else
                                <span class="text-red-600 font-semibold">Rechazada</span>
                            @endif
                        </td>

                        <td class="py-2 px-3">
                            {{-- El pasajero siempre puede cancelar --}}
                            <form action="{{ route('reservas.cancelar', $reserva->id) }}" 
                                method="POST" onsubmit="return confirm('¿Cancelar reserva?')">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No tienes reservas creadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
