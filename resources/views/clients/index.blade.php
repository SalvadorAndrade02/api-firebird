@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

        {{-- ====================================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ====================================================== --}}

        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                    Directorio
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                    Clientes
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    Consulta clientes disponibles en las bases de datos
                    conectadas al sistema.
                </p>

            </div>


            <a href="{{ route('privacy-notices.create') }}"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-black px-5 py-3 sm:w-auto text-sm font-semibold text-white transition hover:bg-gray-800">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Nuevo aviso

            </a>

        </div>


        {{-- ====================================================== --}}
        {{-- BUSCADOR --}}
        {{-- ====================================================== --}}

        <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('clients.index') }}">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-center">

                    <div class="relative flex-1">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                            </svg>

                        </div>

                        <input type="text" name="buscar" value="{{ $search }}"
                            placeholder="Buscar por nombre, RFC o código..."
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-400 focus:bg-white focus:ring-0">

                    </div>


                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                        Buscar
                    </button>


                    @if ($search !== '')

                        <a href="{{ route('clients.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">
                            Limpiar
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- ====================================================== --}}
        {{-- RESUMEN --}}
        {{-- ====================================================== --}}

        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3 text-sm text-gray-500">

                <span>
                    Total de clientes
                </span>

                <span class="inline-flex items-center rounded-full bg-gray-900 px-3 py-1 text-xs font-semibold text-white">
                    {{ number_format($pagination['total'] ?? 0) }}
                </span>

            </div>


            @if ($search !== '')

                <div class="text-sm text-gray-400">
                    Resultados para
                    <span class="font-medium text-gray-700">
                        “{{ $search }}”
                    </span>
                </div>

            @endif

        </div>


        {{-- ====================================================== --}}
        {{-- TABLA --}}
        {{-- ====================================================== --}}

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[960px]">

                    <thead class="bg-[#f8f8f8]">

                        <tr class="border-b border-gray-200">

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Código
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Cliente
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                RFC
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Tipo
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Origen
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Contacto
                            </th>

                            <th
                                class="px-5 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($clients as $client)

                                            @php
                                                $source = $client['source'] ?? 'main';

                                                $sourceLabel =
                                                    $client['sourceLabel']
                                                    ?? (
                                                        $source === 'oric'
                                                        ? 'MMW32_ORIC'
                                                        : 'MMW32'
                                                    );
                                            @endphp

                                            <tr class="transition hover:bg-gray-50/80">

                                                {{-- CÓDIGO --}}
                                                <td class="px-5 py-4">

                                                    <span class="font-mono text-sm font-medium text-gray-700">
                                                        {{ $client['codigo'] ?? '—' }}
                                                    </span>

                                                </td>


                                                {{-- CLIENTE --}}
                                                <td class="px-5 py-4">

                                                    <div class="max-w-sm">

                                                        <p class="font-semibold text-gray-900">
                                                            {{ $client['nombreCompleto'] ?? $client['nombre'] ?? '—' }}
                                                        </p>

                                                        @if (!empty($client['nombreVisible']))

                                                            <p class="mt-1 truncate text-xs text-gray-400">
                                                                {{ $client['nombreVisible'] }}
                                                            </p>

                                                        @endif

                                                    </div>

                                                </td>


                                                {{-- RFC --}}
                                                <td class="px-5 py-4">

                                                    <span class="text-sm text-gray-600">
                                                        {{ $client['fiscal']['rfc'] ?? '—' }}
                                                    </span>

                                                </td>


                                                {{-- TIPO --}}
                                                <td class="px-5 py-4">

                                                    @if (($client['tipoPersona'] ?? null) === 'FISICA')

                                                        <span
                                                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                            Física
                                                        </span>

                                                    @elseif (($client['tipoPersona'] ?? null) === 'MORAL')

                                                        <span
                                                            class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                                            Moral
                                                        </span>

                                                    @else

                                                        <span class="text-sm text-gray-400">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- ORIGEN --}}
                                                <td class="px-5 py-4">

                                                    @if ($source === 'oric')

                                                        <span
                                                            class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-700">
                                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>

                                                            ORIC
                                                        </span>

                                                    @else

                                                        <span
                                                            class="inline-flex items-center gap-2 rounded-full bg-black px-3 py-1 text-xs font-medium text-white">
                                                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>

                                                            MMW32
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- CONTACTO --}}
                                                <td class="px-5 py-4">

                                                    <div class="max-w-[220px]">

                                                        <p class="truncate text-sm text-gray-700">
                                                            {{ $client['contacto']['email'] ?? '—' }}
                                                        </p>

                                                        @if (!empty($client['contacto']['telefono']))

                                                            <p class="mt-1 text-xs text-gray-400">
                                                                {{ $client['contacto']['telefono'] }}
                                                            </p>

                                                        @endif

                                                    </div>

                                                </td>


                                                {{-- ACCIONES --}}
                                                <td class="px-5 py-4 text-right">

                                                    <a href="{{ route('clients.show', [
                                'codigo' => $client['codigo'],
                                'source' => $source
                            ]) }}"
                                                        class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 hover:text-black">

                                                        Ver

                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>

                                                    </a>

                                                </td>

                                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16 text-center">

                                    <div
                                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>

                                    </div>

                                    <p class="mt-4 font-semibold text-gray-900">
                                        No se encontraron clientes
                                    </p>

                                    <p class="mt-1 text-sm text-gray-400">
                                        Intenta con otro nombre, RFC o código.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ====================================================== --}}
        {{-- PAGINACIÓN --}}
        {{-- ====================================================== --}}

        @if (($pagination['totalPages'] ?? 0) > 1)

            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="text-sm text-gray-500">
                    Página

                    <span class="font-semibold text-gray-900">
                        {{ $pagination['page'] }}
                    </span>

                    de

                    <span class="font-semibold text-gray-900">
                        {{ $pagination['totalPages'] }}
                    </span>
                </div>


                <div class="flex items-center gap-2">

                    @if ($pagination['hasPreviousPage'])

                            <a href="{{ route('clients.index', [
                            'buscar' => $search,
                            'page' => $pagination['page'] - 1
                        ]) }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>

                                Anterior

                            </a>

                    @endif


                    @if ($pagination['hasNextPage'])

                            <a href="{{ route('clients.index', [
                            'buscar' => $search,
                            'page' => $pagination['page'] + 1
                        ]) }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-black px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">

                                Siguiente

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>

                            </a>

                    @endif

                </div>

            </div>

        @endif

    </div>

@endsection