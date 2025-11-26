<h1>Editar Vehículo</h1>

<form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    Placa:
    <input type="text" name="placa" value="{{ $vehiculo->placa }}"><br>

    Marca:
    <input type="text" name="marca" value="{{ $vehiculo->marca }}"><br>

    Modelo:
    <input type="text" name="modelo" value="{{ $vehiculo->modelo }}"><br>

    Año:
    <input type="number" name="anio" value="{{ $vehiculo->anio }}"><br>

    Color:
    <input type="text" name="color" value="{{ $vehiculo->color }}"><br>

    Capacidad:
    <input type="number" name="capacidad" value="{{ $vehiculo->capacidad }}"><br>

    <br>
    Fotografía actual:<br>

    @if($vehiculo->fotografia)
        <img src="{{ asset('storage/'.$vehiculo->fotografia) }}" width="100"><br><br>
    @else
        <p>No hay fotografía registrada.</p>
    @endif

    Cambiar fotografía:
    <input type="file" name="fotografia"><br><br>

    <button type="submit">Actualizar</button>
</form>
