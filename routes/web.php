<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController; 


Route::get('/', function () {
    return view('welcome');
});


Route::resource('vehiculos', VehiculoController::class); 