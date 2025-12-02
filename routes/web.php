<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ChoferDashboardController;
use App\Http\Controllers\PasajeroDashboardController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Auth;


// PÁGINA PRINCIPAL
Route::get('/', function () {
    return view('welcome');
});

// PERFIL (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth de Breeze
require __DIR__.'/auth.php';

// ACTIVACIÓN DE CUENTA
Route::get('/activar/{token}', [ActivationController::class, 'activarCuenta'])
    ->name('activar.cuenta');

// DASHBOARD GENERAL (redirige por rol)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->rol) {
        case 'superadmin':
            return redirect()->route('dashboard.superadmin');

        case 'admin':
            return redirect()->route('dashboard.admin');

        case 'chofer':
            return redirect()->route('dashboard.chofer');

        case 'pasajero':
            return redirect()->route('dashboard.pasajero');

        default:
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu cuenta no tiene un rol válido.',
            ]);
    }
})->middleware('auth')->name('dashboard');

// SUPERADMIN
Route::middleware(['auth', 'rol.superadmin'])->group(function () {
    Route::get('/dashboard/superadmin', [SuperadminDashboardController::class, 'index'])
        ->name('dashboard.superadmin');
});

// ADMIN
Route::middleware(['auth', 'rol.admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');
});

// CHOFER
Route::middleware(['auth', 'rol.chofer'])->group(function () {

    Route::get('/dashboard/chofer', [ChoferDashboardController::class, 'index'])
        ->name('dashboard.chofer');

    // CRUD de vehículos SOLO para chofer
    Route::resource('vehiculos', VehiculoController::class)
        ->names([
            'index' => 'vehiculos.index',
            'create' => 'vehiculos.create',
            'store' => 'vehiculos.store',
            'edit' => 'vehiculos.edit',
            'update' => 'vehiculos.update',
            'destroy' => 'vehiculos.destroy',
        ]);

        // CRUD de rides solo para chofer
Route::resource('rides', \App\Http\Controllers\RideController::class)
    ->names([
        'index' => 'rides.index',
        'create' => 'rides.create',
        'store' => 'rides.store',
        'edit' => 'rides.edit',
        'update' => 'rides.update',
        'destroy' => 'rides.destroy',
    ]);

});

// PASAJERO
Route::middleware(['auth', 'rol.pasajero'])->group(function () {
    Route::get('/dashboard/pasajero', [PasajeroDashboardController::class, 'index'])
        ->name('dashboard.pasajero');
});



