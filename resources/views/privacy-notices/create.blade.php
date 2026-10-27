@extends('layouts.app')

@section('title', 'Nuevo aviso')

@section('content')

    @php
        $clientSource = $client->source ?? 'main';

        $clientSourceLabel =
            $clientSource === 'oric'
            ? 'MMW32_ORIC'
            : 'MMW32';
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

        {{-- ====================================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ====================================================== --}}

        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                    Avisos de privacidad
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                    Generar nuevo aviso
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    Selecciona la empresa responsable y el titular para
                    preparar el documento de privacidad.
                </p>

            </div>

            <a href="{{ route('privacy-notices.vault') }}"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 sm:w-auto text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 7h16M5 7l1 13h12l1-13M9 11h6" />
                </svg>

                Ir a bóveda

            </a>

        </div>


        {{-- ====================================================== --}}
        {{-- ERRORES --}}
        {{-- ====================================================== --}}

        @if ($errors->any())

            <div class="mb-7 rounded-2xl border border-red-200 bg-red-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-700">
                        !
                    </div>

                    <div>

                        <p class="font-semibold text-red-800">
                            Hay información que debes revisar
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- ====================================================== --}}
        {{-- PASOS --}}
        {{-- ====================================================== --}}

        <div class="mb-7 grid gap-3 sm:grid-cols-3">

            <div class="rounded-2xl border
                                                            {{ $company ? 'border-black bg-black text-white' : 'border-gray-200 bg-white text-gray-700' }}
                                                            px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg
                                                                    {{ $company ? 'bg-white text-black' : 'bg-gray-100 text-gray-600' }}
                                                                    text-xs font-semibold">
                        01
                    </div>

                    <div>

                        <p class="text-sm font-semibold">
                            Empresa
                        </p>

                        <p
                            class="mt-0.5 text-xs
                                                                        {{ $company ? 'text-white/50' : 'text-gray-400' }}">
                            Responsable del aviso
                        </p>

                    </div>

                </div>

            </div>


            <div class="rounded-2xl border
                                                            {{ $client ? 'border-black bg-black text-white' : 'border-gray-200 bg-white text-gray-700' }}
                                                            px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg
                                                                    {{ $client ? 'bg-white text-black' : 'bg-gray-100 text-gray-600' }}
                                                                    text-xs font-semibold">
                        02
                    </div>

                    <div>

                        <p class="text-sm font-semibold">
                            Cliente
                        </p>

                        <p class="mt-0.5 text-xs
                                                                        {{ $client ? 'text-white/50' : 'text-gray-400' }}">
                            Titular de los datos
                        </p>

                    </div>

                </div>

            </div>


            <div class="rounded-2xl border
                                                            {{ ($client && $company) ? 'border-black bg-black text-white' : 'border-gray-200 bg-white text-gray-700' }}
                                                            px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg
                                                                    {{ ($client && $company) ? 'bg-white text-black' : 'bg-gray-100 text-gray-600' }}
                                                                    text-xs font-semibold">
                        03
                    </div>

                    <div>

                        <p class="text-sm font-semibold">
                            Firma y generación
                        </p>

                        <p
                            class="mt-0.5 text-xs
                                                                        {{ ($client && $company) ? 'text-white/50' : 'text-gray-400' }}">
                            Confirmación del documento
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ====================================================== --}}
        {{-- SELECCIÓN EMPRESA + CLIENTE --}}
        {{-- ====================================================== --}}

        <form id="notice-selection-form" method="GET" action="{{ route('privacy-notices.create') }}">

            <div class="grid gap-6 lg:grid-cols-2">

                {{-- ====================================================== --}}
                {{-- EMPRESA --}}
                {{-- ====================================================== --}}

                <section class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">

                    <div class="mb-5 flex items-start gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-black text-white">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 21h18M5 21V5h14v16M9 9h2M13 9h2M9 13h2M13 13h2M9 17h2M13 17h2" />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Paso 1
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-gray-900">
                                Empresa responsable
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Selecciona la razón social que emitirá el aviso.
                            </p>

                        </div>

                    </div>


                    <select name="company_id" id="company-select" class="w-full" required>

                        <option value="">
                            Seleccionar empresa...
                        </option>

                        @foreach ($companies as $companyOption)

                            <option value="{{ $companyOption['id'] }}" @selected(
                                request('company_id') == $companyOption['id']
                            )>
                                {{ $companyOption['nombre'] }}
                                — {{ $companyOption['rfc'] }}
                            </option>

                        @endforeach

                    </select>


                    @if ($company)

                        <div class="mt-5 rounded-xl bg-gray-50 px-4 py-3">

                            <div class="flex items-center justify-between gap-4">

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                        Seleccionada
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-900">
                                        {{ $company['nombre'] }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        RFC {{ $company['rfc'] ?? '—' }}
                                    </p>

                                </div>

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-black text-white">
                                    ✓
                                </div>

                            </div>

                        </div>

                    @endif

                </section>


                {{-- ====================================================== --}}
                {{-- CLIENTE --}}
                {{-- ====================================================== --}}

                <section class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">

                    <div class="mb-5 flex items-start gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-black text-white">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Paso 2
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-gray-900">
                                Cliente
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Busca por nombre, RFC o código.
                            </p>

                        </div>

                    </div>


                    <div class="flex flex-col gap-3 sm:flex-row">

                        <div class="min-w-0 flex-1">

                            <select name="client_key" id="client-select" class="w-full" required>

                                @if ($client)

                                    <option value="{{ ($client->source ?? 'main') . '|' . $client->codigo }}" selected>
                                        {{ $client->nombre_completo ?? $client->nombre }}
                                    </option>

                                @else

                                    <option value="">
                                        Buscar cliente...
                                    </option>

                                @endif

                            </select>

                        </div>


                        <button type="submit"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                            Seleccionar

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>

                        </button>

                    </div>


                    @if ($client)

                        <div class="mt-5 rounded-xl bg-gray-50 px-4 py-3">

                            <div class="flex items-center justify-between gap-4">

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $client->nombre_completo }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $client->codigo }}
                                        ·
                                        {{ $client->rfc ?? 'Sin RFC' }}
                                        ·
                                        {{ $clientSourceLabel }}
                                    </p>

                                </div>

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-black text-white">
                                    ✓
                                </div>

                            </div>

                        </div>

                    @endif

                </section>

            </div>

        </form>


        {{-- ====================================================== --}}
        {{-- DOCUMENTO + FIRMA --}}
        {{-- ====================================================== --}}

        @if ($client && $company)

            {{-- PREVIEW --}}
            <section class="mt-8">

                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Documento
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-gray-900">
                            Vista previa del aviso
                        </h2>

                    </div>


                    <span
                        class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        Revisión previa
                    </span>

                </div>


                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-100 bg-gray-50 px-5 py-3">

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>

                            <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>

                            <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>

                            <span class="ml-3 text-xs font-medium text-gray-400">
                                Vista del documento
                            </span>

                        </div>

                    </div>


                    <div class="overflow-x-auto p-4 sm:p-6">

                        @include('privacy-notices.template', [
                            'client' => $client,
                            'company' => $company,
                            'digitalSignature' => null,
                            'date' => now()->format('d/m/Y'),
                        ])

                    </div>

                </div>

            </section>


            {{-- FORMULARIO --}}
            <form id="privacy-notice-form" method="POST" action="{{ route('privacy-notices.store') }}" class="mt-8">

                @csrf

                <input type="hidden" name="submission_token" value="{{ $submissionToken }}">

                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <input type="hidden" name="client_source" value="{{ $client->source ?? 'main' }}">

                <input type="hidden" name="company_id" value="{{ $company['id'] }}">

                <input type="hidden" id="digital_signature" name="digital_signature" value="">


                {{-- TIPO DE FIRMA --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">

                    <div class="mb-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Paso 3
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-gray-900">
                            Tipo de firma
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Define cómo será formalizado el aviso.
                        </p>

                    </div>


                    <div class="grid gap-4 md:grid-cols-2">

                        {{-- DIGITAL --}}
                        <label
                            class="signature-option cursor-pointer rounded-2xl border-2 border-black p-5 transition hover:bg-gray-50"
                            data-type="DIGITAL">

                            <div class="flex items-start gap-4">

                                <input type="radio" name="signature_type" value="DIGITAL" class="mt-1" checked>

                                <div>

                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-black text-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M4 17l4-1 9-9-3-3-9 9-1 4zM13 5l3 3" />
                                        </svg>

                                    </div>

                                    <p class="mt-4 font-semibold text-gray-900">
                                        Firma digital
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        El titular firma directamente desde
                                        pantalla táctil, mouse o stylus.
                                    </p>

                                </div>

                            </div>

                        </label>


                        {{-- MANUAL --}}
                        <label
                            class="signature-option cursor-pointer rounded-2xl border-2 border-gray-200 p-5 transition hover:bg-gray-50"
                            data-type="MANUAL">

                            <div class="flex items-start gap-4">

                                <input type="radio" name="signature_type" value="MANUAL" class="mt-1">

                                <div>

                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M6 2h9l3 3v17H6zM9 13h6M9 17h4" />
                                        </svg>

                                    </div>

                                    <p class="mt-4 font-semibold text-gray-900">
                                        Firma física
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        El documento será impreso y firmado
                                        posteriormente de forma autógrafa.
                                    </p>

                                </div>

                            </div>

                        </label>

                    </div>

                </section>


                {{-- FIRMA DIGITAL --}}
                <section id="digital-signature-section" class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Captura
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-gray-900">
                                Firma digital
                            </h2>

                            <p class="mt-2 text-sm text-gray-500">
                                Firma dentro del recuadro y confirma el trazo.
                            </p>

                        </div>


                        <div id="signature-status"
                            class="w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                            Firma pendiente
                        </div>

                    </div>


                    <div class="mt-6 overflow-hidden rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50">

                        <canvas id="signature-pad" width="1000" height="300" class="block h-[180px] w-full bg-white sm:h-[220px]"
                            style="touch-action: none; cursor: crosshair;">
                        </canvas>

                    </div>


                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap">

                        <button type="button" id="clear-signature"
                            class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                            Limpiar
                        </button>

                        <button type="button" id="save-signature"
                            class="rounded-xl bg-black px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">
                            Confirmar firma
                        </button>

                    </div>

                </section>


                {{-- FIRMA MANUAL --}}
                <section id="manual-signature-section"
                    class="hidden mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                        Firma autógrafa
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-gray-900">
                        Firma física
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                        El PDF incluirá el espacio para la firma autógrafa.
                        Después podrá imprimirse, firmarse y cargarse nuevamente
                        a la bóveda.
                    </p>


                    <div class="mt-8 max-w-lg rounded-2xl bg-gray-50 p-6">

                        <div class="h-20 border-b border-black"></div>

                        <div class="mt-3 text-center">

                            <p class="font-semibold text-gray-900">
                                {{ $client->nombre_completo }}
                            </p>

                            <p class="mt-1 text-xs font-medium uppercase tracking-[0.12em] text-gray-400">
                                Firma autógrafa del titular
                            </p>

                        </div>

                    </div>

                </section>


                {{-- CONSENTIMIENTO --}}
                <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <label class="flex cursor-pointer items-start gap-4">

                        <input type="checkbox" id="consent"
                            class="mt-1 h-4 w-4 rounded border-gray-300 text-black focus:ring-black" required>

                        <div>

                            <p class="font-semibold text-gray-900">
                                Consentimiento del titular
                            </p>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Declaro que he leído y entendido el Aviso de
                                Privacidad Integral y otorgo mi consentimiento
                                para que mis datos personales sean objeto de
                                tratamiento y transferencia conforme a las
                                finalidades descritas en el presente aviso.
                            </p>

                        </div>

                    </label>

                </section>


                {{-- ACCIONES --}}
                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

                    <a href="{{ route('clients.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">
                        Cancelar
                    </a>

                    <button type="submit" id="generate-button"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-black px-7 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M6 2h9l3 3v17H6zM9 13h6M9 17h6" />
                        </svg>

                        Generar aviso

                    </button>

                </div>

            </form>

        @endif

    </div>
    @if ($client && $company)

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const canvas =
                    document.getElementById('signature-pad');

                const form =
                    document.getElementById('privacy-notice-form');

                const signatureInput =
                    document.getElementById('digital_signature');

                const signatureStatus =
                    document.getElementById('signature-status');

                const digitalSection =
                    document.getElementById('digital-signature-section');

                const manualSection =
                    document.getElementById('manual-signature-section');

                const generateButton =
                    document.getElementById('generate-button');

                const consent =
                    document.getElementById('consent');


                /*
                |--------------------------------------------------------------------------
                | PROTECCIÓN
                |--------------------------------------------------------------------------
                */

                if (
                    !canvas ||
                    !form ||
                    !signatureInput ||
                    !signatureStatus
                ) {
                    return;
                }


                const ctx =
                    canvas.getContext('2d');


                let drawing = false;
                let hasDrawing = false;
                let signatureConfirmed = false;
                let formSubmitting = false;


                /*
                |--------------------------------------------------------------------------
                | CANVAS
                |--------------------------------------------------------------------------
                */

                ctx.strokeStyle = '#111827';
                ctx.lineWidth = 3;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';


                function getPosition(event) {

                    const rect =
                        canvas.getBoundingClientRect();

                    const point =
                        event.touches
                            ? event.touches[0]
                            : event;

                    return {
                        x:
                            (point.clientX - rect.left)
                            * (canvas.width / rect.width),

                        y:
                            (point.clientY - rect.top)
                            * (canvas.height / rect.height),
                    };
                }


                function startDrawing(event) {

                    event.preventDefault();

                    drawing = true;
                    hasDrawing = true;
                    signatureConfirmed = false;

                    signatureInput.value = '';

                    signatureStatus.textContent =
                        'Firma modificada. Debes confirmarla nuevamente.';

                    signatureStatus.className =
                        'w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700';

                    const position =
                        getPosition(event);

                    ctx.beginPath();

                    ctx.moveTo(
                        position.x,
                        position.y
                    );
                }


                function draw(event) {

                    if (!drawing) {
                        return;
                    }

                    event.preventDefault();

                    const position =
                        getPosition(event);

                    ctx.lineTo(
                        position.x,
                        position.y
                    );

                    ctx.stroke();
                }


                function stopDrawing() {

                    if (!drawing) {
                        return;
                    }

                    drawing = false;

                    ctx.closePath();
                }


                canvas.addEventListener(
                    'mousedown',
                    startDrawing
                );

                canvas.addEventListener(
                    'mousemove',
                    draw
                );

                window.addEventListener(
                    'mouseup',
                    stopDrawing
                );


                canvas.addEventListener(
                    'touchstart',
                    startDrawing,
                    {
                        passive: false
                    }
                );

                canvas.addEventListener(
                    'touchmove',
                    draw,
                    {
                        passive: false
                    }
                );

                canvas.addEventListener(
                    'touchend',
                    stopDrawing
                );


                /*
                |--------------------------------------------------------------------------
                | LIMPIAR FIRMA
                |--------------------------------------------------------------------------
                */

                document
                    .getElementById('clear-signature')
                    .addEventListener(
                        'click',
                        function () {

                            ctx.clearRect(
                                0,
                                0,
                                canvas.width,
                                canvas.height
                            );

                            hasDrawing = false;
                            signatureConfirmed = false;

                            signatureInput.value = '';

                            signatureStatus.textContent =
                                'Firma pendiente';

                            signatureStatus.className =
                                'w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700';
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | CONFIRMAR FIRMA
                |--------------------------------------------------------------------------
                */

                document
                    .getElementById('save-signature')
                    .addEventListener(
                        'click',
                        function () {

                            if (!hasDrawing) {

                                signatureStatus.textContent =
                                    'Debes dibujar una firma antes de confirmarla.';

                                signatureStatus.className =
                                    'w-fit rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700';

                                return;
                            }


                            signatureInput.value =
                                canvas.toDataURL(
                                    'image/png'
                                );

                            signatureConfirmed = true;


                            signatureStatus.textContent =
                                'Firma capturada correctamente';

                            signatureStatus.className =
                                'w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700';
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | TIPO DE FIRMA
                |--------------------------------------------------------------------------
                */

                const signatureTypes =
                    document.querySelectorAll(
                        'input[name="signature_type"]'
                    );

                const signatureOptions =
                    document.querySelectorAll(
                        '.signature-option'
                    );


                function updateSignatureType() {

                    const checked =
                        document.querySelector(
                            'input[name="signature_type"]:checked'
                        );

                    if (!checked) {
                        return;
                    }


                    const selected =
                        checked.value;


                    signatureOptions.forEach(
                        function (option) {

                            if (
                                option.dataset.type ===
                                selected
                            ) {
                                option.classList.remove(
                                    'border-gray-200'
                                );

                                option.classList.add(
                                    'border-black'
                                );

                            } else {

                                option.classList.remove(
                                    'border-black'
                                );

                                option.classList.add(
                                    'border-gray-200'
                                );
                            }
                        }
                    );


                    if (selected === 'DIGITAL') {

                        digitalSection.classList.remove(
                            'hidden'
                        );

                        manualSection.classList.add(
                            'hidden'
                        );

                    } else {

                        digitalSection.classList.add(
                            'hidden'
                        );

                        manualSection.classList.remove(
                            'hidden'
                        );


                        /*
                         * Un aviso manual nunca debe mandar
                         * una firma digital residual.
                         */
                        signatureInput.value = '';

                        signatureConfirmed = false;
                    }
                }


                signatureTypes.forEach(
                    function (radio) {

                        radio.addEventListener(
                            'change',
                            updateSignatureType
                        );
                    }
                );


                updateSignatureType();


                /*
                |--------------------------------------------------------------------------
                | ÚNICO SUBMIT DEL FORMULARIO
                |--------------------------------------------------------------------------
                */

                form.addEventListener(
                    'submit',
                    function (event) {

                        /*
                         * Evitar un segundo POST.
                         */
                        if (formSubmitting) {

                            event.preventDefault();

                            return;
                        }


                        const checked =
                            document.querySelector(
                                'input[name="signature_type"]:checked'
                            );


                        if (!checked) {

                            event.preventDefault();

                            return;
                        }


                        const selectedType =
                            checked.value;


                        /*
                         * Firma digital obligatoria.
                         */
                        if (
                            selectedType === 'DIGITAL'
                            && !signatureConfirmed
                        ) {

                            event.preventDefault();


                            signatureStatus.textContent =
                                'Debes confirmar la firma digital antes de generar el aviso.';

                            signatureStatus.className =
                                'w-fit rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700';


                            digitalSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            return;
                        }


                        /*
                         * Consentimiento obligatorio.
                         */
                        if (
                            !consent ||
                            !consent.checked
                        ) {

                            event.preventDefault();

                            alert(
                                'Debes confirmar que has leído el aviso de privacidad.'
                            );

                            return;
                        }


                        /*
                         * A partir de aquí NO hacemos
                         * preventDefault().
                         *
                         * El POST queda completamente en manos
                         * del navegador/Laravel.
                         */

                        formSubmitting = true;


                        if (generateButton) {

                            generateButton.disabled = true;

                            generateButton.textContent =
                                'Generando aviso...';

                            generateButton.classList.add(
                                'opacity-60',
                                'cursor-not-allowed'
                            );
                        }
                    }
                );

            });
        </script>

    @endif

    @push('scripts')
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function () {

                    /*
                    |--------------------------------------------------------------------------
                    | EMPRESA
                    |--------------------------------------------------------------------------
                    */

                    const companyElement =
                        document.getElementById(
                            'company-select'
                        );


                    if (
                        companyElement &&
                        typeof TomSelect !== 'undefined'
                    ) {

                        new TomSelect(
                            companyElement,
                            {
                                placeholder:
                                    'Seleccionar empresa...',

                                allowEmptyOption: true,

                                create: false
                            }
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CLIENTE
                    |--------------------------------------------------------------------------
                    */

                    const clientElement =
                        document.getElementById(
                            'client-select'
                        );


                    if (
                        !clientElement ||
                        typeof TomSelect === 'undefined'
                    ) {
                        return;
                    }


                    const endpoint =
                        @json(
                            route(
                                'clientes.firebird.search'
                            )
                        );


                    let activeRequest = null;


                    const clientSelect =
                        new TomSelect(
                            clientElement,
                            {
                                valueField: 'key',

                                labelField: 'nombre',

                                searchField: [],

                                maxOptions: 20,

                                loadThrottle: 350,

                                closeAfterSelect: true,


                                shouldLoad:
                                    function (query) {

                                        return (
                                            query
                                                .trim()
                                                .length >= 3
                                        );
                                    },


                                /*
                                |--------------------------------------------------------------------------
                                | ESCRITURA
                                |--------------------------------------------------------------------------
                                */

                                onType:
                                    function (query) {

                                        query =
                                            query.trim();


                                        /*
                                         * Resultados anteriores
                                         * no deben permanecer.
                                         */
                                        this.clearOptions();


                                        /*
                                         * Cancelar petición anterior
                                         * si el usuario modifica
                                         * la búsqueda.
                                         */
                                        if (activeRequest) {

                                            activeRequest.abort();

                                            activeRequest = null;
                                        }


                                        if (
                                            query.length < 3
                                        ) {

                                            this.refreshOptions(
                                                false
                                            );

                                            return;
                                        }
                                    },


                                /*
                                |--------------------------------------------------------------------------
                                | CONSULTA REMOTA
                                |--------------------------------------------------------------------------
                                */

                                load:
                                    function (
                                        query,
                                        callback
                                    ) {

                                        query =
                                            query.trim();


                                        if (
                                            query.length < 3
                                        ) {

                                            this.clearOptions();

                                            callback([]);

                                            return;
                                        }


                                        /*
                                         * La petición anterior
                                         * ya no es relevante.
                                         */
                                        if (activeRequest) {

                                            activeRequest.abort();
                                        }


                                        const controller =
                                            new AbortController();


                                        activeRequest =
                                            controller;


                                        const url =
                                            endpoint
                                            + '?q='
                                            + encodeURIComponent(
                                                query
                                            )
                                            + '&page=1'
                                            + '&limit=20';


                                        fetch(
                                            url,
                                            {
                                                method: 'GET',

                                                headers: {
                                                    'Accept':
                                                        'application/json'
                                                },

                                                signal:
                                                    controller.signal
                                            }
                                        )

                                            .then(
                                                function (
                                                    response
                                                ) {

                                                    if (
                                                        !response.ok
                                                    ) {
                                                        throw new Error(
                                                            'HTTP '
                                                            + response.status
                                                        );
                                                    }


                                                    return response.json();
                                                }
                                            )

                                            .then(
                                                function (
                                                    json
                                                ) {

                                                    /*
                                                     * Ya comenzó otra búsqueda.
                                                     */
                                                    if (
                                                        activeRequest !==
                                                        controller
                                                    ) {
                                                        return;
                                                    }


                                                    clientSelect
                                                        .clearOptions();


                                                    callback(
                                                        json.data
                                                        ?? []
                                                    );
                                                }
                                            )

                                            .catch(
                                                function (
                                                    error
                                                ) {

                                                    if (
                                                        error.name ===
                                                        'AbortError'
                                                    ) {

                                                        /*
                                                         * Cerrar correctamente
                                                         * el loading anterior.
                                                         */
                                                        callback([]);

                                                        return;
                                                    }


                                                    console.error(
                                                        'Error buscando clientes:',
                                                        error
                                                    );


                                                    clientSelect
                                                        .clearOptions();


                                                    callback([]);
                                                }
                                            )

                                            .finally(
                                                function () {

                                                    if (
                                                        activeRequest ===
                                                        controller
                                                    ) {
                                                        activeRequest =
                                                            null;
                                                    }
                                                }
                                            );
                                    },


                                /*
                                |--------------------------------------------------------------------------
                                | PRESENTACIÓN
                                |--------------------------------------------------------------------------
                                */

                                render: {

                                    option:
                                        function (
                                            item,
                                            escape
                                        ) {

                                            return `
                                                            <div class="py-2">

                                                                <div
                                                                    class="font-medium text-gray-900"
                                                                >
                                                                    ${escape(
                                                item.nombre
                                                || ''
                                            )}
                                                                </div>

                                                                <div
                                                                    class="mt-1 text-xs text-gray-500"
                                                                >
                                                                    ${escape(
                                                item.codigo
                                                || ''
                                            )}

                                                                    ·

                                                                    ${escape(
                                                item.rfc
                                                || 'Sin RFC'
                                            )}

                                                                    ·

                                                                    ${escape(
                                                item.sourceLabel
                                                || ''
                                            )}
                                                                </div>

                                                            </div>
                                                        `;
                                        },


                                    item:
                                        function (
                                            item,
                                            escape
                                        ) {

                                            return `
                                                            <div>

                                                                ${escape(
                                                item.nombre
                                                || ''
                                            )}

                                                                <span
                                                                    class="text-xs text-gray-500"
                                                                >
                                                                    ·
                                                                    ${escape(
                                                item.sourceLabel
                                                || ''
                                            )}
                                                                </span>

                                                            </div>
                                                        `;
                                        }
                                }
                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANTE
                    |--------------------------------------------------------------------------
                    |
                    | NO colocar:
                    |
                    | document.addEventListener('click'...)
                    | document.addEventListener('pointerdown'...)
                    | preventDefault() sobre links
                    |
                    | Tom Select no participa en la navegación.
                    |
                    */

                }
            );
        </script>
    @endpush
@endsection