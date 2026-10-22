@extends('layouts.app')

@section('title', 'Detalle del cliente')

@section('content')

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

    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-10">

        {{-- ====================================================== --}}
        {{-- REGRESAR --}}
        {{-- ====================================================== --}}

        <div class="mb-6">

            <a href="{{ route('clients.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-black">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>

                Regresar a clientes

            </a>

        </div>


        {{-- ====================================================== --}}
        {{-- ENCABEZADO PRINCIPAL --}}
        {{-- ====================================================== --}}

        <div class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 bg-[#111111] px-8 py-8 text-white">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <span
                                class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-white/70">
                                Cliente {{ $client['codigo'] ?? '—' }}
                            </span>


                            @if ($source === 'oric')

                                <span
                                    class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium text-white">
                                    MMW32_ORIC
                                </span>

                            @else

                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-black">
                                    MMW32
                                </span>

                            @endif

                        </div>


                        <h1 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight sm:text-4xl">
                            {{ $client['nombreCompleto'] ?? $client['nombre'] ?? '—' }}
                        </h1>


                        <div class="mt-4">

                            @if (($client['tipoPersona'] ?? null) === 'FISICA')

                                <span
                                    class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80">
                                    Persona física
                                </span>

                            @else

                                <span
                                    class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80">
                                    Persona moral
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- ACCIÓN PRINCIPAL --}}
                    <a href="{{ route('privacy-notices.create', [
        'client_key' =>
            ($client['source'] ?? 'main')
            . '|'
            . $client['codigo'],
    ]) }}"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-black transition hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                        </svg>

                        Generar aviso

                    </a>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- CONTENIDO --}}
            {{-- ====================================================== --}}

            <div class="p-8">

                {{-- DATOS FISCALES --}}
                <section>

                    <div class="mb-5">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                            Información fiscal
                        </p>

                        <h2 class="mt-2 text-xl font-semibold text-gray-900">
                            Datos del cliente
                        </h2>

                    </div>


                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        {{-- RFC --}}
                        <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-5">

                            <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                RFC
                            </p>

                            <p class="mt-2 font-semibold text-gray-900">
                                {{ $client['fiscal']['rfc'] ?? '—' }}
                            </p>

                        </div>


                        {{-- RÉGIMEN --}}
                        <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-5">

                            <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Régimen fiscal
                            </p>

                            <p class="mt-2 font-semibold text-gray-900">
                                {{ $client['fiscal']['regimenFiscal'] ?? '—' }}
                            </p>

                        </div>


                        {{-- TIPO --}}
                        <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-5">

                            <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Tipo de persona
                            </p>

                            <p class="mt-2 font-semibold text-gray-900">
                                {{ ($client['tipoPersona'] ?? null) === 'FISICA'
        ? 'Persona física'
        : 'Persona moral' }}
                            </p>

                        </div>

                    </div>

                </section>


                {{-- ====================================================== --}}
                {{-- CONTACTO --}}
                {{-- ====================================================== --}}

                <section class="mt-10">

                    <div class="mb-5">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                            Contacto
                        </p>

                        <h2 class="mt-2 text-xl font-semibold text-gray-900">
                            Información de contacto
                        </h2>

                    </div>


                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        {{-- TELÉFONO --}}
                        <div class="rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 5a2 2 0 012-2h3l2 5-2 1a11 11 0 005 5l1-2 5 2v3a2 2 0 01-2 2h-1C8.82 19 3 13.18 3 6V5z" />
                                </svg>

                            </div>

                            <p class="mt-4 text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Teléfono
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $client['contacto']['telefono'] ?? '—' }}
                            </p>

                        </div>


                        {{-- MÓVIL --}}
                        <div class="rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <rect x="7" y="2" width="10" height="20" rx="2" stroke-width="1.8" />

                                    <path stroke-linecap="round" stroke-width="1.8" d="M11 18h2" />
                                </svg>

                            </div>

                            <p class="mt-4 text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Móvil
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $client['contacto']['movil'] ?? '—' }}
                            </p>

                        </div>


                        {{-- CORREO --}}
                        <div class="rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 6h18v12H3zM3 7l9 6 9-6" />
                                </svg>

                            </div>

                            <p class="mt-4 text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Correo
                            </p>

                            <p class="mt-1 break-all font-semibold text-gray-900">
                                {{ $client['contacto']['email'] ?? '—' }}
                            </p>

                        </div>

                    </div>

                </section>


                {{-- ====================================================== --}}
                {{-- DIRECCIÓN --}}
                {{-- ====================================================== --}}

                <section class="mt-10">

                    <div class="mb-5">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                            Ubicación
                        </p>

                        <h2 class="mt-2 text-xl font-semibold text-gray-900">
                            Dirección registrada
                        </h2>

                    </div>


                    <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-6">

                        <div class="flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-black text-white">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 21s7-5.25 7-12a7 7 0 10-14 0c0 6.75 7 12 7 12z" />

                                    <circle cx="12" cy="9" r="2" stroke-width="1.8" />
                                </svg>

                            </div>


                            <div>

                                <p class="font-semibold leading-7 text-gray-900">
                                    {{ $client['direccion']['calle'] ?? '—' }}

                                    @if (!empty($client['direccion']['numero']))
                                        {{ $client['direccion']['numero'] }}
                                    @endif
                                </p>

                                <p class="mt-1 text-sm leading-6 text-gray-500">
                                    {{ $client['direccion']['colonia'] ?? '—' }},
                                    {{ $client['direccion']['municipio'] ?? '—' }},
                                    {{ $client['direccion']['estado'] ?? '—' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-400">
                                    C.P.
                                    {{ $client['direccion']['codigoPostal'] ?? '—' }}

                                    @if (!empty($client['direccion']['pais']))
                                        · {{ $client['direccion']['pais'] }}
                                    @endif
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ====================================================== --}}
                {{-- ACCIONES --}}
                {{-- ====================================================== --}}

                <div
                    class="mt-10 flex flex-col gap-3 border-t border-gray-100 pt-7 sm:flex-row sm:items-center sm:justify-between">

                    <a href="{{ route('clients.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">
                        Regresar
                    </a>


                    <a href="{{ route('privacy-notices.create', [
        'client_key' =>
            ($client['source'] ?? 'main')
            . '|'
            . $client['codigo'],
    ]) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>

                        Generar aviso de privacidad

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection