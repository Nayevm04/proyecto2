<div class="bg-white shadow rounded-lg overflow-hidden mb-10">
    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-3">ID</th>
                <th class="py-2 px-3">Nombre</th>
                <th class="py-2 px-3">Email</th>
                <th class="py-2 px-3">Rol</th>
                <th class="py-2 px-3">Estado</th>
                <th class="py-2 px-3">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($usuarios as $u)
                <tr class="border-b">
                    <td class="py-2 px-3">{{ $u->id }}</td>

                    {{-- NOMBRE --}}
                    <td class="py-2 px-3">
                        {{ $u->nombre }}
                        @if($u->apellido)
                            {{ $u->apellido }}
                        @endif
                    </td>

                    {{-- EMAIL --}}
                    <td class="py-2 px-3">{{ $u->email }}</td>

                    {{-- ROL --}}
                    <td class="py-2 px-3">{{ ucfirst($u->rol) }}</td>

                    {{-- ESTADO --}}
                    <td class="py-2 px-3">
                        @if($u->estado === 'Activo')
                            <span class="text-green-700 font-semibold">Activo</span>
                        @elseif($u->estado === 'Inactivo')
                            <span class="text-red-700 font-semibold">Inactivo</span>
                        @else
                            <span class="text-yellow-700 font-semibold">Pendiente</span>
                        @endif
                    </td>

                    {{-- ACCIONES --}}
                    <td class="py-2 px-3 space-x-2">

                        {{-- ACTIVAR --}}
                        <form action="{{ route('usuarios.activar', $u->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-green-600 hover:underline">
                                Activar
                            </button>
                        </form>

                        {{-- DESACTIVAR --}}
                        <form action="{{ route('usuarios.desactivar', $u->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-red-600 hover:underline">
                                Desactivar
                            </button>
                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center py-3 text-gray-500">
                        No hay usuarios registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
