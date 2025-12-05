@extends('layouts.app')

@section('content')

<div class="max-w-lg mx-auto bg-white shadow p-6 rounded">

    <h2 class="text-2xl font-bold mb-4">Confirmar Reserva</h2>

    <div class="mb-4">
        <p><strong>Ride:</strong> {{ $ride->nombre }}</p>
        <p><strong>Salida:</strong> {{ $ride->lugar_salida }}</p>
        <p><strong>Llegada:</strong> {{ $ride->lugar_llegada }}</p>
        <p><strong>Fecha y hora:</strong> {{ $ride->fecha_hora }}</p>
        <p><strong>Costo por espacio:</strong> ₡{{ $ride->costo_espacio }}</p>
        <p><strong>Vehículo:</strong> {{ $ride->vehiculo->marca }} {{ $ride->vehiculo->modelo }}</p>
    </div>

    <form method="POST" action="{{ route('reservas.store', $ride->id) }}">
        @csrf

        <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Confirmar Reserva
        </button>

        <a href="{{ route('rides.public') }}" class="px-4 py-2 bg-gray-300 rounded ml-2">
            Cancelar
        </a>
    </form>
</div>

@endsection
