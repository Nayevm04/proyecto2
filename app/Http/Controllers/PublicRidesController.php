<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;

class PublicRidesController extends Controller
{
    public function index(Request $request)
    {
        // Filtros recibidos
        $origen  = $request->input('origen');
        $destino = $request->input('destino');
        $fecha   = $request->input('fecha');
        $orden   = $request->input('orden');

        // Consulta inicial: rides con espacios disponibles
        $query = Ride::where('cantidad_espacios', '>', 0);

        // Filtro por origen
        if ($origen) {
            $query->where('lugar_salida', 'LIKE', "%$origen%");
        }

        // Filtro por destino
        if ($destino) {
            $query->where('lugar_llegada', 'LIKE', "%$destino%");
        }

        // Filtro por fecha
        if ($fecha) {
            $query->whereDate('fecha_hora', $fecha);
        }

        // Ordenamiento
        if ($orden === 'fecha') {
            $query->orderBy('fecha_hora', 'asc');
        } elseif ($orden === 'origen') {
            $query->orderBy('lugar_salida', 'asc');
        } elseif ($orden === 'destino') {
            $query->orderBy('lugar_llegada', 'asc');
        } else {
            // Orden por defecto
            $query->orderBy('fecha_hora', 'asc');
        }

        // Obtener los resultados finales
        $rides = $query->get();

        return view('reservas.public', compact('rides', 'origen', 'destino', 'fecha', 'orden'));
    }
}



