<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middlewares de rol para rutas individuales
    $middleware->alias([
        'rol.superadmin' => \App\Http\Middleware\RolSuperadmin::class,
        'rol.admin'      => \App\Http\Middleware\RolAdmin::class,
        'rol.chofer'     => \App\Http\Middleware\RolChofer::class,
        'rol.pasajero'   => \App\Http\Middleware\RolPasajero::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
