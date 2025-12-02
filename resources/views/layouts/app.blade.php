<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Aventones') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

@php
    // Determinar dashboard según el rol
    $dashboardUrl = url('/'); // Invitado → home

    if (auth()->check()) {
        $dashboardUrl = match(auth()->user()->rol) {
            'superadmin' => route('dashboard.superadmin'),
            'admin'      => route('dashboard.admin'),
            'chofer'     => route('dashboard.chofer'),
            'pasajero'   => route('dashboard.pasajero'),
            default      => url('/'),
        };
    }
@endphp

<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo / Inicio --}}
            <div class="flex items-center">
                <a href="{{ $dashboardUrl }}" class="text-lg font-bold mr-6">
                    {{ config('app.name', 'Aventones') }}
                </a>

                @auth
                    <a href="{{ $dashboardUrl }}" class="mr-4 text-sm text-gray-700 hover:underline">
                        Inicio
                    </a>
                @endauth
            </div>

            {{-- Links de auth --}}
            <div class="flex items-center">
                @guest
                    <a href="{{ route('login') }}" class="text-sm mr-4 text-gray-700 hover:underline">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">Registrarse</a>
                @else
                    <span class="mr-4 text-sm text-gray-700">
                        Hola, {{ auth()->user()->nombre ?? auth()->user()->email }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">
                            Cerrar sesión
                        </button>
                    </form>
                @endguest
            </div>

        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Mensajes flash --}}
    @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</main>

@stack('scripts')
</body>
</html>
