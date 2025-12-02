@php
    // Dashboard correcto según el rol
    if (auth()->check()) {
        $dashboardUrl = match(auth()->user()->rol) {
            'superadmin' => route('dashboard.superadmin'),
            'admin'      => route('dashboard.admin'),
            'chofer'     => route('dashboard.chofer'),
            'pasajero'   => route('dashboard.pasajero'),
            default      => url('/'),
        };
    } else {
        $dashboardUrl = url('/'); // Invitado
    }

    // Nombre visible
    $displayName = auth()->check()
        ? (auth()->user()->nombre ?? auth()->user()->email)
        : '';
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $dashboardUrl }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardUrl" :active="false">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endauth
            </div>

            <!-- Settings -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                            <div>{{ $displayName }}</div>

                            <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M5.5 7l4.5 4 4.5-4" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

            </div>

        </div>
    </div>
</nav>
