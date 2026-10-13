@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

    <div class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold">
                Clientes
            </h1>

            <p class="text-gray-500 mt-2">
                Consulta los clientes sincronizados desde el sistema principal.
            </p>
        </div>

        <form method="GET" action="{{ route('clients.index') }}" class="mb-6">
            <div class="flex gap-3">

                <input type="text" name="buscar" value="{{ $search }}" placeholder="Buscar por nombre, RFC o código..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <button type="submit" class="rounded-lg bg-black px-6 py-3 text-white">
                    Buscar
                </button>

                @if ($search !== '')
                    <a href="{{ route('clients.index') }}" class="rounded-lg border border-gray-300 px-6 py-3">
                        Limpiar
                    </a>
                @endif

            </div>
        </form>


        <div class="mb-4 text-sm text-gray-500">

            Total de clientes:
            <strong>
                {{ number_format($pagination['total'] ?? 0) }}
            </strong>

        </div>


        <div class="overflow-x-auto bg-white rounded-xl shadow-sm">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-4 py-3 text-left">
                            Código
                        </th>

                        <th class="px-4 py-3 text-left">
                            Cliente
                        </th>

                        <th class="px-4 py-3 text-left">
                            RFC
                        </th>

                        <th class="px-4 py-3 text-left">
                            Tipo
                        </th>

                        <th class="px-4 py-3 text-left">
                            Contacto
                        </th>

                        <th class="px-4 py-3 text-right">
                            Acciones
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y">

                    @forelse ($clients as $client)

                        <tr>

                            <td class="px-4 py-3 font-mono text-sm">
                                {{ $client['codigo'] ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium">
                                    {{ $client['nombreCompleto'] ?? $client['nombre'] ?? '—' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                {{ $client['fiscal']['rfc'] ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $client['tipoPersona'] ?? '—' }}
                            </td>

                            <td class="px-4 py-3">

                                <div class="text-sm">
                                    {{ $client['contacto']['email'] ?? '—' }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $client['contacto']['telefono'] ?? '' }}
                                </div>

                            </td>

                            <td class="px-4 py-3 text-right">

                                <a href="{{ route('clients.show', $client['codigo']) }}" class="text-sm font-medium underline">
                                    Ver
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                No se encontraron clientes.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if (($pagination['totalPages'] ?? 0) > 1)

            <div class="mt-6 flex items-center justify-between">

                <div class="text-sm text-gray-500">

                    Página
                    {{ $pagination['page'] }}
                    de
                    {{ $pagination['totalPages'] }}

                </div>

                <div class="flex gap-2">

                    @if ($pagination['hasPreviousPage'])

                            <a href="{{ route('clients.index', [
                            'buscar' => $search,
                            'page' => $pagination['page'] - 1
                        ]) }}" class="rounded-lg border px-4 py-2">
                                Anterior
                            </a>

                    @endif


                    @if ($pagination['hasNextPage'])

                            <a href="{{ route('clients.index', [
                            'buscar' => $search,
                            'page' => $pagination['page'] + 1
                        ]) }}" class="rounded-lg border px-4 py-2">
                                Siguiente
                            </a>

                    @endif

                </div>

            </div>

        @endif

    </div>

@endsection