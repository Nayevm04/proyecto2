<h1>Crear Vehículo</h1> 
<form action="{{ route('vehiculos.store') }}" method="POST" 
enctype="multipart/form-data"> 
    @csrf 
    Placa: <input type="text" name="placa"><br> 
    Marca: <input type="text" name="marca"><br> 
    Modelo: <input type="text" name="modelo"><br> 
    Año: <input type="number" name="anio"><br> 
    Color: <input type="text" name="color"><br> 
    Capacidad: <input type="number" name="capacidad"><br> 
    Fotografía: <input type="file" name="fotografia"><br><br> 
 
    <button type="submit">Guardar</button> 
</form>