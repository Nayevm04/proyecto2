@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-md p-6 rounded-lg">

    <h2 class="text-2xl font-bold mb-4">Registrar Vehículo</h2>

    <form action="{{ route('vehiculos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-4">

            <div>
                <label class="font-semibold">Placa</label>
                <input type="text" name="placa" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Marca</label>
                <input type="text" name="marca" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Modelo</label>
                <input type="text" name="modelo" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Año</label>
                <input type="number" name="anio" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Color</label>
                <input type="text" name="color" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Capacidad</label>
                <input type="number" name="capacidad" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="font-semibold">Fotografía</label>
                <input type="file" name="fotografia" class="w-full border rounded p-2">
            </div>

        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('dashboard.chofer') }}"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Guardar Vehículo
            </button>
        </div>

    </form>

</div>

@endsection


