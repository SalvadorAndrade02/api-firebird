@php
    $clientSnapshot = $clientSnapshot ?? [];
    $companySnapshot = $companySnapshot ?? [];

    $clientName =
        $clientSnapshot['nombre_completo']
        ?? $notice->client?->nombre_completo
        ?? '—';

    $clientCode =
        $clientSnapshot['codigo']
        ?? $notice->client?->codigo
        ?? '—';

    $clientRfc =
        $clientSnapshot['rfc']
        ?? $notice->client?->rfc
        ?? '—';

    $source =
        $clientSnapshot['source']
        ?? 'main';

    $sourceLabel =
        $clientSnapshot['source_label']
        ?? (
            $source === 'oric'
            ? 'MMW32_ORIC'
            : 'MMW32'
        );

    $isSigned =
        $notice->status === 'SIGNED';

    $isManual =
        $notice->signature_type === 'MANUAL';
@endphp


@extends('layouts.app')

@section('title', 'Aviso #' . $notice->id)

@section('content')

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- REGRESAR --}}
        <div class="mb-6">

            <a href="{{ route('privacy-notices.vault') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-black">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>

                Regresar a bóveda

            </a>

        </div>


        {{-- ====================================================== --}}
        {{-- HERO --}}
        {{-- ====================================================== --}}

        <section class="relative overflow-hidden rounded-[28px] bg-[#111111] px-8 py-8 text-white shadow-sm lg:px-10">

            <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full border border-white/10"></div>

            <div class="pointer-events-none absolute -bottom-28 right-20 h-56 w-56 rounded-full border border-white/10">
            </div>


            <div class="relative z-10 flex flex-col gap-7 lg:flex-row lg:items-start lg:justify-between">

                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <span
                            class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-white/70">
                            Aviso #{{ $notice->id }}
                        </span>


                        @if ($isSigned)

                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-medium text-emerald-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>

                                Firmado
                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-amber-500/15 px-3 py-1 text-xs font-medium text-amber-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>

                                Pendiente firma
                            </span>

                        @endif


                        <span
                            class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-white/70">
                            {{ $sourceLabel }}
                        </span>

                    </div>


                    <h1 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight sm:text-4xl">
                        {{ $clientName }}
                    </h1>


                    <p class="mt-3 text-sm text-white/50">
                        Código {{ $clientCode }}
                        ·
                        RFC {{ $clientRfc }}
                    </p>

                </div>


                {{-- ACCIONES --}}
                <div class="flex flex-wrap gap-3">

                    @if ($notice->pdf_path)

                        <a href="{{ route('privacy-notices.pdf', $notice) }}" target="_blank"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-black transition hover:bg-gray-100">
                            Ver PDF
                        </a>


                        <a href="{{ route('privacy-notices.pdf', $notice) }}?download=1"
                            class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            Descargar
                        </a>


                        <button type="button" onclick="printPdf()"
                            class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            Imprimir
                        </button>

                    @endif

                    <div x-data="{
            open: false,
            deleting: false
        }">

                        <button type="button" @click="open = true"
                            class="inline-flex items-center gap-2 rounded-xl border border-red-300 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M6 7h12M9 7V4h6v3M8 7l1 13h6l1-13" />
                            </svg>

                            Eliminar aviso

                        </button>


                        {{-- MODAL --}}
                        <div x-show="open" x-cloak x-transition.opacity
                            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 px-4">

                            <div @click.outside="open = false" x-transition
                                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

                                {{-- ICONO --}}
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M6 7h12M9 7V4h6v3M8 7l1 13h6l1-13" />
                                    </svg>

                                </div>


                                {{-- CONTENIDO --}}
                                <div class="mt-5">

                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Eliminar aviso
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-gray-500">
                                        Estás a punto de eliminar definitivamente el aviso
                                        <span class="font-semibold text-gray-800">
                                            #{{ $notice->id }}
                                        </span>.
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-gray-500">
                                        También se eliminarán el PDF generado y el documento
                                        firmado asociado, si existe.
                                    </p>

                                </div>


                                {{-- ALERTA --}}
                                <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                                    <p class="text-sm font-medium text-red-700">
                                        Esta acción no se puede deshacer.
                                    </p>

                                </div>


                                {{-- ACCIONES --}}
                                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                    <button type="button" @click="open = false"
                                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">
                                        Cancelar
                                    </button>


                                    <form method="POST" action="{{ route('privacy-notices.destroy', $notice) }}"
                                        @submit="deleting = true">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" :disabled="deleting"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60">

                                            <span x-show="!deleting">
                                                Eliminar definitivamente
                                            </span>

                                            <span x-show="deleting">
                                                Eliminando...
                                            </span>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- INFORMACIÓN PRINCIPAL --}}
        {{-- ====================================================== --}}

        <div class="mt-8 grid gap-6 lg:grid-cols-2">

            {{-- EMPRESA --}}
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-black text-white">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 21h18M5 21V5h14v16M9 9h2M13 9h2M9 13h2M13 13h2" />
                        </svg>

                    </div>


                    <div class="min-w-0">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Empresa responsable
                        </p>

                        <h2 class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $companySnapshot['nombre'] ?? '—' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            RFC {{ $companySnapshot['rfc'] ?? '—' }}
                        </p>

                    </div>

                </div>


                @if (!empty($companySnapshot['direccion']))

                    <div class="mt-6 rounded-xl bg-gray-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                            Dirección
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-700">
                            {{ $companySnapshot['direccion']['calle'] ?? '' }}

                            @if (!empty($companySnapshot['direccion']['numero']))
                                #{{ $companySnapshot['direccion']['numero'] }}
                            @endif

                            @if (!empty($companySnapshot['direccion']['colonia']))
                                , {{ $companySnapshot['direccion']['colonia'] }}
                            @endif

                            @if (!empty($companySnapshot['direccion']['municipio']))
                                , {{ $companySnapshot['direccion']['municipio'] }}
                            @endif

                            @if (!empty($companySnapshot['direccion']['estado']))
                                , {{ $companySnapshot['direccion']['estado'] }}
                            @endif

                            @if (!empty($companySnapshot['direccion']['codigoPostal']))
                                · C.P. {{ $companySnapshot['direccion']['codigoPostal'] }}
                            @endif
                        </p>

                    </div>

                @endif

            </section>


            {{-- CLIENTE --}}
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>

                    </div>


                    <div class="min-w-0">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Titular
                        </p>

                        <h2 class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $clientName }}
                        </h2>

                    </div>

                </div>


                <div class="mt-6 grid gap-3 sm:grid-cols-2">

                    <div class="rounded-xl bg-gray-50 p-4">

                        <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                            Código
                        </p>

                        <p class="mt-2 font-mono text-sm font-semibold text-gray-900">
                            {{ $clientCode }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-gray-50 p-4">

                        <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                            RFC
                        </p>

                        <p class="mt-2 text-sm font-semibold text-gray-900">
                            {{ $clientRfc }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-gray-50 p-4">

                        <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                            Origen
                        </p>

                        <p class="mt-2 text-sm font-semibold text-gray-900">
                            {{ $sourceLabel }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-gray-50 p-4">

                        <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                            Tipo de persona
                        </p>

                        <p class="mt-2 text-sm font-semibold text-gray-900">
                            @if (
                                    ($clientSnapshot['tipo_persona'] ?? null)
                                    === 'FISICA'
                                )
                                Persona física
                            @elseif (
                                    ($clientSnapshot['tipo_persona'] ?? null)
                                    === 'MORAL'
                                )
                                Persona moral
                            @else
                                —
                            @endif
                        </p>

                    </div>

                </div>

            </section>

        </div>


        {{-- ====================================================== --}}
        {{-- DOCUMENTO --}}
        {{-- ====================================================== --}}

        <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                        Documento
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-gray-900">
                        Información del aviso
                    </h2>

                </div>


                @if ($notice->pdf_path)

                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        PDF disponible
                    </span>

                @endif

            </div>


            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">

                    <p class="text-xs text-gray-400">
                        Tipo de firma
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $notice->signature_type === 'DIGITAL'
        ? 'Digital'
        : 'Física' }}
                    </p>

                </div>


                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">

                    <p class="text-xs text-gray-400">
                        Estado
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $isSigned
        ? 'Firmado'
        : 'Pendiente de firma' }}
                    </p>

                </div>


                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">

                    <p class="text-xs text-gray-400">
                        Generado
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $notice->created_at?->format('d/m/Y H:i') }}
                    </p>

                </div>


                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">

                    <p class="text-xs text-gray-400">
                        Firmado
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $notice->signed_at?->format('d/m/Y H:i')
        ?? 'Pendiente' }}
                    </p>

                </div>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- TIMELINE --}}
        {{-- ====================================================== --}}

        <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                Seguimiento
            </p>

            <h2 class="mt-1 text-xl font-semibold text-gray-900">
                Historial del documento
            </h2>


            <div class="mt-7">

                {{-- CREADO --}}
                <div class="relative flex gap-4 pb-7">

                    <div class="absolute left-[15px] top-8 h-[calc(100%-10px)] w-px bg-gray-200"></div>

                    <div
                        class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-black text-xs font-semibold text-white">
                        ✓
                    </div>

                    <div>

                        <p class="font-semibold text-gray-900">
                            Aviso generado
                        </p>

                        <p class="mt-1 text-sm text-gray-400">
                            {{ $notice->created_at?->format('d/m/Y H:i') }}
                        </p>

                    </div>

                </div>


                {{-- PDF --}}
                <div class="relative flex gap-4 pb-7">

                    <div class="absolute left-[15px] top-8 h-[calc(100%-10px)] w-px bg-gray-200"></div>

                    <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                    {{ $notice->pdf_path
        ? 'bg-black text-white'
        : 'border border-gray-200 bg-white text-gray-400' }}">
                        ✓
                    </div>

                    <div>

                        <p class="font-semibold text-gray-900">
                            PDF generado
                        </p>

                        <p class="mt-1 text-sm text-gray-400">
                            {{ $notice->pdf_path
        ? 'Documento almacenado en la bóveda.'
        : 'No disponible.' }}
                        </p>

                    </div>

                </div>


                {{-- FIRMA --}}
                <div class="flex gap-4">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                    {{ $isSigned
        ? 'bg-emerald-600 text-white'
        : 'border border-gray-200 bg-white text-gray-400' }}">
                        {{ $isSigned ? '✓' : '3' }}
                    </div>

                    <div>

                        <p class="font-semibold text-gray-900">
                            {{ $isSigned
        ? 'Documento firmado'
        : 'Firma pendiente' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-400">

                            @if ($isSigned)

                                {{ $notice->signed_at?->format('d/m/Y H:i') }}

                            @elseif ($isManual)

                                Pendiente de cargar el documento con firma autógrafa.

                            @else

                                Firma pendiente.

                            @endif

                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- FIRMA MANUAL --}}
        {{-- ====================================================== --}}

        @if ($isManual)

            <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                    <div class="max-w-xl">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Firma autógrafa
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-gray-900">
                            Documento firmado
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Imprime el aviso, solicita la firma del titular
                            y carga posteriormente el archivo PDF firmado.
                        </p>

                    </div>

                </div>


                <form method="POST" action="{{ route('privacy-notices.upload-signed', $notice) }}" enctype="multipart/form-data"
                    class="mt-6">

                    @csrf


                    <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-5">

                        <label for="signed_pdf" class="block text-sm font-medium text-gray-700">
                            Archivo PDF firmado
                        </label>

                        <input id="signed_pdf" type="file" name="signed_pdf" accept="application/pdf" required
                            class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-black file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800">

                        <p class="mt-3 text-xs text-gray-400">
                            Formato permitido: PDF · Máximo 10 MB
                        </p>

                    </div>


                    <div class="mt-4 flex justify-end">

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                            Subir PDF firmado
                        </button>

                    </div>

                </form>

            </section>

        @endif

    </div>


    <script>
        function printPdf() {

            const url =
                @json(
                    route(
                        'privacy-notices.pdf',
                        $notice
                    )
                );

            const printWindow =
                window.open(
                    url,
                    '_blank'
                );

            if (!printWindow) {

                alert(
                    'El navegador bloqueó la ventana de impresión.'
                );

                return;
            }

            printWindow.addEventListener(
                'load',
                function () {
                    printWindow.print();
                }
            );
        }
    </script>

@endsection