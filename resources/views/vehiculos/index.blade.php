<h1>Listado de Vehículos</h1> 
<a href="{{ route('vehiculos.create') }}">Crear Vehículo</a> 
<table border="1" cellpadding="8"> 
    <tr> 
        <th>Placa</th> 
        <th>Marca</th> 
        <th>Modelo</th> 
        <th>Año</th> 
        <th>Color</th> 
        <th>Capacidad</th> 
        <th>Foto</th> 
        <th>Acciones</th> 
    </tr> 
 
    @foreach($vehiculos as $v) 
    <tr> 
        <td>{{ $v->placa }}</td> 
        <td>{{ $v->marca }}</td> 
        <td>{{ $v->modelo }}</td> 
        <td>{{ $v->anio }}</td> 
        <td>{{ $v->color }}</td> 
        <td>{{ $v->capacidad }}</td> 
        <td> 
            @if($v->fotografia) 
                <img src="{{ asset('storage/'.$v->fotografia) }}" 
width="80"> 
            @endif 
        </td> 
        <td> 
            <a href="{{ route('vehiculos.edit', $v->id) 
}}">Editar</a>  <form method="POST" action="{{ 
route('vehiculos.destroy', $v->id) }}" style="display:inline"> 
                @csrf 
                @method('DELETE') 
                <button type="submit">Eliminar</button> 
            </form> 
        </td> 
    </tr> 
    @endforeach 
</table>