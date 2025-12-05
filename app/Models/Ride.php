<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'lugar_salida',
        'lugar_llegada',
        'fecha_hora',
        'costo_espacio',
        'cantidad_espacios',
        'vehiculo_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con Vehículo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Relación con Usuario (chofer)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
