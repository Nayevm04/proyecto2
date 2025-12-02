@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Título --}}
    <h1 class="text-3xl font-bold mb-6">Dashboard del Chofer</h1>

    {{-- Mensaje de éxito --}}
    @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- Botón para crear vehículo --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('vehiculos.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + Agregar Vehículo
        </a>
    </div>

    {{-- Tabla de vehículos --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Placa</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Marca</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Modelo</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Año</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Color</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Capacidad</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Foto</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vehiculos as $v)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $v->placa }}</td>
                        <td class="py-3 px-4">{{ $v->marca }}</td>
                        <td class="py-3 px-4">{{ $v->modelo }}</td>
                        <td class="py-3 px-4">{{ $v->anio }}</td>
                        <td class="py-3 px-4">{{ $v->color }}</td>
                        <td class="py-3 px-4">{{ $v->capacidad }}</td>

                        <td class="py-3 px-4">
                            @if($v->fotografia)
                                <img src="{{ asset('storage/'.$v->fotografia) }}" class="h-16 rounded shadow">
                            @else
                                <span class="text-gray-500">Sin foto</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-sm space-x-2">
                            <a href="{{ route('vehiculos.edit', $v->id) }}"
                               class="text-blue-600 hover:underline">Editar</a>

                            <form action="{{ route('vehiculos.destroy', $v->id) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('¿Eliminar este vehículo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            No has registrado ningún vehículo aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

/{{-- Tabla de rides --}}
<h2 class="text-2xl font-bold mt-10 mb-4">Mis Rides</h2>

{{-- Botón para crear un ride --}}
<div class="flex justify-end mb-4">
    <a href="{{ route('rides.create') }}"
       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        + Crear Ride
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nombre</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Salida</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Llegada</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Fecha & Hora</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Costo</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Espacios</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Vehículo</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rides as $r)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $r->nombre }}</td>
                    <td class="py-3 px-4">{{ $r->lugar_salida }}</td>
                    <td class="py-3 px-4">{{ $r->lugar_llegada }}</td>
                    <td class="py-3 px-4">
                        {{ \Carbon\Carbon::parse($r->fecha_hora)->format('d/m/Y H:i') }}
                    </td>
                    <td class="py-3 px-4">₡{{ number_format($r->costo_espacio, 2) }}</td>
                    <td class="py-3 px-4">{{ $r->cantidad_espacios }}</td>
                    <td class="py-3 px-4">
                        {{ $r->vehiculo->placa ?? 'Sin vehículo' }}
                    </td>

                    <td class="py-3 px-4 space-x-2 text-sm">
                        <a href="{{ route('rides.edit', $r->id) }}"
                           class="text-blue-600 hover:underline">
                            Editar
                        </a>

                        <form action="{{ route('rides.destroy', $r->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:underline"
                                    onclick="return confirm('¿Eliminar este ride?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        No has registrado rides aún.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>


</div>

@endsection

