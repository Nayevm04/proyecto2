<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ChoferDashboardController;
use App\Http\Controllers\PasajeroDashboardController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\PublicRidesController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\GestionUsuariosController;


// ============================
// PÁGINA PRINCIPAL
// ============================
Route::get('/', function () {
    return view('welcome');
});


// ============================
// PERFIL (Breeze)
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// ============================
// ACTIVACIÓN DE CUENTA
// ============================
Route::get('/activar/{token}', [ActivationController::class, 'activarCuenta'])
    ->name('activar.cuenta');


// ============================
// DASHBOARD GENERAL (redirige)
// ============================
Route::get('/dashboard', function () {

    $user = Auth::user();
    if (!$user) return redirect()->route('login');

    return match($user->rol) {
        'superadmin' => redirect()->route('dashboard.superadmin'),
        'admin'      => redirect()->route('dashboard.admin'),
        'chofer'     => redirect()->route('dashboard.chofer'),
        'pasajero'   => redirect()->route('dashboard.pasajero'),
        default      => redirect()->route('login')
            ->withErrors(['email' => 'Tu cuenta no tiene un rol válido.']),
    };

})->middleware('auth')->name('dashboard');

// ============================
// RUTAS GLOBALES DE ACTIVAR / DESACTIVAR USUARIOS
// (superadmin y admin las usan)
// ============================
Route::middleware(['auth'])->group(function () {
    Route::post('/usuarios/{id}/activar',
        [GestionUsuariosController::class, 'activar']
    )->name('usuarios.activar');

    Route::post('/usuarios/{id}/desactivar',
        [GestionUsuariosController::class, 'desactivar']
    )->name('usuarios.desactivar');
});

// ============================
// SUPERADMIN
// ============================
Route::middleware(['auth', 'rol.superadmin'])->group(function () {

    // Dashboard principal del superadmin (gestión de usuarios)
    Route::get('/dashboard/superadmin', [GestionUsuariosController::class, 'index'])
        ->name('dashboard.superadmin');

    // Formulario para crear admin
    Route::get('/dashboard/superadmin/admins/crear',
        [GestionUsuariosController::class, 'formularioCrearAdmin']
    )->name('superadmin.admins.crear');

    // Guardar admin
    Route::post('/dashboard/superadmin/admins',
        [GestionUsuariosController::class, 'guardarAdmin']
    )->name('superadmin.admins.guardar');

    // Ejecutar script manualmente (recordatorio reservas)
    Route::post('/script/recordatorio', function () {
        Artisan::call('reservas:recordatorio');
        return back()->with('success', 'Script ejecutado manualmente.');
    })->name('script.recordatorio');
});


// ============================
// ADMIN
// ============================
Route::middleware(['auth', 'rol.admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');
});


// ============================
// RUTA COMPARTIDA PARA CANCELAR
// (Chofer y Pasajero usan la misma)
// ============================
Route::post('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])
    ->middleware('auth')
    ->name('reservas.cancelar');


// ============================
// CHOFER
// ============================
Route::middleware(['auth', 'rol.chofer'])->group(function () {

    Route::get('/dashboard/chofer', [ChoferDashboardController::class, 'index'])
        ->name('dashboard.chofer');

    // Vehículos
    Route::resource('vehiculos', VehiculoController::class);

    // Rides
    Route::resource('rides', RideController::class);

    // Aceptar / rechazar reservas
    Route::post('/reservas/{id}/aceptar',  [ReservaController::class, 'aceptar'])
        ->name('reservas.aceptar');

    Route::post('/reservas/{id}/rechazar', [ReservaController::class, 'rechazar'])
        ->name('reservas.rechazar');
});


// ============================
// PASAJERO
// ============================
Route::middleware(['auth', 'rol.pasajero'])->group(function () {

    Route::get('/dashboard/pasajero', [PasajeroDashboardController::class, 'index'])
        ->name('dashboard.pasajero');

    // Crear reserva
    Route::get('/reservar/{ride}', [ReservaController::class, 'crear'])
        ->name('reservas.crear');

    Route::post('/reservar/{ride}', [ReservaController::class, 'store'])
        ->name('reservas.store');
});


// ============================
// PÁGINA PÚBLICA DE RIDES
// ============================
Route::get('/rides', [PublicRidesController::class, 'index'])
    ->name('rides.public');

