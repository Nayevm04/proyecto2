<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    protected $fillable = [ 
    'placa', 
        'marca', 
        'modelo', 
        'anio', 
        'color', 
        'capacidad', 
        'fotografia',
        'user_id'
 
];
public function chofer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
