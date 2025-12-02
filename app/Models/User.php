<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'fotografia',
        'email',
        'password',
        'rol',
        'estado',
        'activation_token', //Necesario para ACTIVAR por correo
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'activation_token', //lo ocultamos en JSON, NO en la BD
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
