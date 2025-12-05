<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ride_id',
        'estado',
    ];

    // Pasajero que hizo la reserva
    public function pasajero()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Ride reservado
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
