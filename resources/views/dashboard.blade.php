@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- ====================================================== --}}
        {{-- HERO / BIENVENIDA --}}
        {{-- ====================================================== --}}

        <section
            class="relative overflow-hidden rounded-[28px] bg-[#111111] px-8 py-9 lg:px-10 lg:py-10 text-white shadow-sm">

            {{-- DECORACIÓN --}}
            <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full border border-white/10"></div>

            <div class="absolute -right-8 -bottom-24 h-56 w-56 rounded-full border border-white/10"></div>

            <div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                <div class="max-w-2xl">

                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-white/70">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>

                        Sistema activo
                    </div>

                    <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl">
                        Gestión de Avisos de Privacidad
                    </h1>

                    <p class="mt-4 max-w-xl text-sm leading-6 text-white/55 sm:text-base">
                        Consulta clientes, genera avisos de privacidad y
                        resguarda documentos firmados desde una sola plataforma.
                    </p>

                </div>


                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('privacy-notices.create') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-black transition hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>

                        Nuevo aviso

                    </a>


                    <a href="{{ route('privacy-notices.vault') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">

                        Ver bóveda

                    </a>

                </div>

            </div>

        </section>

        {{-- ====================================================== --}}
        {{-- MÉTRICAS --}}
        {{-- ====================================================== --}}

        <section class="mt-8">

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                                Total
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                                {{ number_format($totalNotices) }}
                            </p>

                            <p class="mt-1 text-sm text-gray-400">
                                Avisos generados
                            </p>

                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-black text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M6 2h9l3 3v17H6zM9 9h6M9 13h6" />
                            </svg>
                        </div>

                    </div>

                </div>


                {{-- FIRMADOS --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                        Firmados
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-emerald-700">
                        {{ number_format($signedNotices) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Documentos completos
                    </p>

                </div>


                {{-- PENDIENTES --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                        Pendientes
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-amber-600">
                        {{ number_format($pendingNotices) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Firma física pendiente
                    </p>

                </div>


                {{-- DIGITALES --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                        Firma digital
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                        {{ number_format($digitalNotices) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Avisos digitales
                    </p>

                </div>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- ACCESOS PRINCIPALES --}}
        {{-- ====================================================== --}}

        <section class="mt-10">

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                    Accesos principales
                </p>

                <h2 class="mt-2 text-xl font-semibold text-gray-900">
                    ¿Qué deseas hacer?
                </h2>

            </div>


            <div class="grid gap-5 md:grid-cols-3">

                {{-- CLIENTES --}}
                <a href="{{ route('clients.index') }}"
                    class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg">

                    <div class="flex items-start justify-between gap-6">

                        <div>

                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-900 transition group-hover:bg-black group-hover:text-white">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                                </svg>

                            </div>

                            <p class="text-sm font-medium text-gray-400">
                                Clientes
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-gray-900">
                                Consultar clientes
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-gray-500">
                                Busca información directamente en las bases
                                operativas conectadas.
                            </p>

                        </div>


                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0 text-gray-300 transition group-hover:translate-x-1 group-hover:text-black"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" />
                        </svg>

                    </div>

                </a>


                {{-- NUEVO AVISO --}}
                <a href="{{ route('privacy-notices.create') }}"
                    class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg">

                    <div class="flex items-start justify-between gap-6">

                        <div>

                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-900 transition group-hover:bg-black group-hover:text-white">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 4v16m8-8H4" />
                                </svg>

                            </div>

                            <p class="text-sm font-medium text-gray-400">
                                Avisos
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-gray-900">
                                Generar nuevo aviso
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-gray-500">
                                Selecciona empresa, cliente y método de firma
                                para generar un nuevo documento.
                            </p>

                        </div>


                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0 text-gray-300 transition group-hover:translate-x-1 group-hover:text-black"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" />
                        </svg>

                    </div>

                </a>


                {{-- BÓVEDA --}}
                <a href="{{ route('privacy-notices.vault') }}"
                    class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg">

                    <div class="flex items-start justify-between gap-6">

                        <div>

                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-900 transition group-hover:bg-black group-hover:text-white">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 7h16M5 7l1 13h12l1-13M9 11h6" />
                                </svg>

                            </div>

                            <p class="text-sm font-medium text-gray-400">
                                Documentos
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-gray-900">
                                Consultar bóveda
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-gray-500">
                                Consulta avisos generados, pendientes y
                                documentos firmados.
                            </p>

                        </div>


                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0 text-gray-300 transition group-hover:translate-x-1 group-hover:text-black"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" />
                        </svg>

                    </div>

                </a>

            </div>

        </section>

        {{-- ====================================================== --}}
        {{-- ÚLTIMOS AVISOS --}}
        {{-- ====================================================== --}}

        <section class="mt-10">

            <div class="mb-5 flex items-end justify-between gap-4">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                        Actividad reciente
                    </p>

                    <h2 class="mt-2 text-xl font-semibold text-gray-900">
                        Últimos avisos
                    </h2>

                </div>


                <a href="{{ route('privacy-notices.vault') }}"
                    class="text-sm font-medium text-gray-500 transition hover:text-black">
                    Ver todos
                </a>

            </div>


            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                @forelse ($recentNotices as $notice)

                        @php
                            $snapshot =
                                $notice->client_snapshot ?? [];

                            $name =
                                $snapshot['nombre_completo']
                                ?? $notice->client?->nombre_completo
                                ?? '—';

                            $code =
                                $snapshot['codigo']
                                ?? $notice->client?->codigo
                                ?? '—';

                            $source =
                                $snapshot['source']
                                ?? 'main';
                        @endphp


                        <a href="{{ route('privacy-notices.show', $notice) }}"
                            class="flex items-center justify-between gap-5 border-b border-gray-100 px-6 py-4 transition last:border-b-0 hover:bg-gray-50">

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="text-sm font-semibold text-gray-900">
                                        Aviso #{{ $notice->id }}
                                    </span>

                                    @if ($notice->status === 'SIGNED')

                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">
                                            Firmado
                                        </span>

                                    @else

                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-medium text-amber-700">
                                            Pendiente
                                        </span>

                                    @endif

                                </div>


                                <p class="mt-1 truncate text-sm text-gray-600">
                                    {{ $name }}
                                </p>


                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $code }}
                                    ·
                                    {{ $source === 'oric'
                    ? 'MMW32_ORIC'
                    : 'MMW32' }}
                                </p>

                            </div>


                            <div class="shrink-0 text-right">

                                <p class="text-xs text-gray-400">
                                    {{ $notice->created_at?->format('d/m/Y') }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $notice->created_at?->format('H:i') }}
                                </p>

                            </div>

                        </a>

                @empty

                    <div class="px-6 py-12 text-center">

                        <p class="font-medium text-gray-700">
                            Aún no existen avisos
                        </p>

                        <p class="mt-1 text-sm text-gray-400">
                            Los avisos generados aparecerán aquí.
                        </p>

                    </div>

                @endforelse

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- PARTE INFERIOR --}}
        {{-- ====================================================== --}}

        <section class="mt-10 grid gap-6 lg:grid-cols-[1.35fr_.65fr]">

            {{-- FLUJO --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-7">

                <div class="flex items-start justify-between gap-6">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                            Proceso
                        </p>

                        <h2 class="mt-2 text-xl font-semibold text-gray-900">
                            Flujo de trabajo
                        </h2>

                    </div>

                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">
                        3 etapas
                    </span>

                </div>


                <div class="mt-8">

                    {{-- PASO 1 --}}
                    <div class="relative flex gap-5 pb-8">

                        <div class="absolute left-[19px] top-10 h-[calc(100%-20px)] w-px bg-gray-200"></div>

                        <div
                            class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-black text-sm font-semibold text-white">
                            01
                        </div>

                        <div class="pt-1">

                            <p class="font-semibold text-gray-900">
                                Buscar cliente
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Localiza al titular directamente en las bases
                                de datos conectadas.
                            </p>

                        </div>

                    </div>


                    {{-- PASO 2 --}}
                    <div class="relative flex gap-5 pb-8">

                        <div class="absolute left-[19px] top-10 h-[calc(100%-20px)] w-px bg-gray-200"></div>

                        <div
                            class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700">
                            02
                        </div>

                        <div class="pt-1">

                            <p class="font-semibold text-gray-900">
                                Generar aviso
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Verifica información, selecciona la empresa
                                responsable y define el tipo de firma.
                            </p>

                        </div>

                    </div>


                    {{-- PASO 3 --}}
                    <div class="flex gap-5">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700">
                            03
                        </div>

                        <div class="pt-1">

                            <p class="font-semibold text-gray-900">
                                Resguardar documento
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                El aviso queda disponible para consulta y
                                seguimiento desde la bóveda documental.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- SESIÓN --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-7">

                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                    Sesión
                </p>

                <h2 class="mt-2 text-xl font-semibold text-gray-900">
                    Usuario actual
                </h2>


                <div class="mt-7 flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-black text-base font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <p class="truncate font-semibold text-gray-900">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="mt-1 truncate text-sm text-gray-400">
                            {{ auth()->user()->email }}
                        </p>

                    </div>

                </div>


                <div class="mt-7 border-t border-gray-100 pt-6">

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500">
                            Estado de sesión
                        </span>

                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                            Activa
                        </span>

                    </div>

                </div>


                <div class="mt-6">

                    <a href="{{ route('privacy-notices.create') }}"
                        class="flex w-full items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:border-gray-300 hover:bg-gray-50">

                        <span>
                            Crear nuevo aviso
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>

                    </a>

                </div>

            </div>

        </section>

    </div>

@endsection