@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-md p-6 rounded-lg">

    <h2 class="text-2xl font-bold mb-4">Crear Nuevo Ride</h2>

    {{-- Mostrar mensajes de error personalizados --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rides.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-4">

            <div>
                <label class="font-semibold">Nombre del Ride</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" value="{{ old('nombre') }}" required>
            </div>

            <div>
                <label class="font-semibold">Lugar de salida</label>
                <input type="text" name="lugar_salida" class="w-full border rounded p-2" value="{{ old('lugar_salida') }}" required>
            </div>

            <div>
                <label class="font-semibold">Lugar de llegada</label>
                <input type="text" name="lugar_llegada" class="w-full border rounded p-2" value="{{ old('lugar_llegada') }}" required>
            </div>

            <div>
                <label class="font-semibold">Día y Hora</label>
                <input type="datetime-local" name="fecha_hora"
                       class="w-full border rounded p-2"
                       value="{{ old('fecha_hora') }}" required>
            </div>

            <div>
                <label class="font-semibold">Costo por espacio</label>
                <input type="number" step="0.01" name="costo_espacio"
                       class="w-full border rounded p-2"
                       value="{{ old('costo_espacio') }}" required>
            </div>

            <div>
                <label class="font-semibold">Cantidad de espacios</label>
                <input type="number" name="cantidad_espacios"
                       class="w-full border rounded p-2"
                       value="{{ old('cantidad_espacios') }}" required>
            </div>

            <div>
                <label class="font-semibold">Vehículo asociado</label>
                <select name="vehiculo_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar vehículo</option>

                    @foreach ($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}"
                            {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                            {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                            (Capacidad: {{ $vehiculo->capacidad }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('dashboard.chofer') }}"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Crear Ride
            </button>
        </div>

    </form>

</div>

@endsection
