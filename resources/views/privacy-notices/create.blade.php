@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">
        {{-- ENCABEZADO --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold">
                Aviso de Privacidad
            </h1>
            <p class="text-gray-500 mt-2">
                Selecciona un cliente, revisa el aviso y define el tipo de firma.
            </p>
        </div>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <p class="font-semibold text-red-700 mb-2">
                    Hay información que debes revisar:
                </p>
                <ul class="list-disc pl-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ====================================================== --}}
        {{-- SELECTOR DE CLIENTE --}}
        {{-- ====================================================== --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('privacy-notices.create') }}">
                <label for="client" class="block font-medium mb-2">
                    Cliente
                </label>
                <div class="flex gap-3">
                    <select name="client_code" id="client-select" class="w-full" required>
                        <option value="">Buscar cliente...</option>
                    </select>

                    <button type="submit" class="rounded-lg bg-black px-6 py-3 text-white hover:bg-gray-800">
                        Seleccionar
                    </button>
                </div>
            </form>
        </div>
        @if ($client)

            {{-- ====================================================== --}}
            {{-- PLANTILLA DEL AVISO --}}
            {{-- ====================================================== --}}

            <div class="mb-8">
                @include('privacy-notices.template', [
                    'client' => $client,
                    'digitalSignature' => null,
                    'date' => now()->format('d/m/Y'),
                ])
            </div>

            {{-- ====================================================== --}}
            {{-- FORMULARIO PARA GENERAR AVISO --}}
            {{-- ====================================================== --}}

            <form id="privacy-notice-form" method="POST" action="{{ route('privacy-notices.store') }}">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="hidden" id="digital_signature" name="digital_signature" value="">

                {{-- ================================================== --}}
                {{-- TIPO DE FIRMA --}}
                {{-- ================================================== --}}

                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-2">
                        Tipo de firma
                    </h2>
                    <p class="text-gray-500 mb-6">
                        Selecciona cómo será firmado el aviso de privacidad.
                    </p>
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- DIGITAL --}}
                        <label class="signature-option cursor-pointer rounded-xl border-2 border-black p-5" data-type="DIGITAL">
                            <div class="flex items-start gap-3">

                                <input type="radio" name="signature_type" value="DIGITAL" class="mt-1" checked>
                                <div>
                                    <p class="font-semibold">
                                        Firma digital
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        El titular firma directamente con mouse,
                                        pantalla táctil o stylus.
                                    </p>
                                </div>
                            </div>
                        </label>

                        {{-- MANUAL --}}

                        <label class="signature-option cursor-pointer rounded-xl border-2 border-gray-200 p-5"
                            data-type="MANUAL">
                            <div class="flex items-start gap-3">
                                <input type="radio" name="signature_type" value="MANUAL" class="mt-1">
                                <div>
                                    <p class="font-semibold">
                                        Firma física
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        El documento será generado para imprimirlo
                                        y firmarlo de manera manual.
                                    </p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- FIRMA DIGITAL --}}
                {{-- ================================================== --}}

                <div id="digital-signature-section" class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-2">
                        Firma digital
                    </h2>
                    <p class="text-gray-500 mb-5">
                        Firma dentro del recuadro utilizando el mouse,
                        touch o stylus.
                    </p>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl overflow-hidden bg-white">
                        <canvas id="signature-pad" width="1000" height="300" class="block w-full"
                            style="touch-action: none; height: 220px; cursor: crosshair;">
                        </canvas>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-4">
                        <button type="button" id="clear-signature"
                            class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                            Limpiar
                        </button>
                        <button type="button" id="save-signature"
                            class="px-4 py-2 rounded-lg bg-black text-white hover:bg-gray-800">
                            Confirmar firma
                        </button>
                    </div>
                    <div id="signature-status" class="mt-4 text-sm text-amber-600">
                        Firma pendiente
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- FIRMA FÍSICA --}}
                {{-- ================================================== --}}

                <div id="manual-signature-section" class="hidden bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-2">
                        Firma física
                    </h2>
                    <p class="text-gray-500">
                        El PDF se generará con el espacio destinado a la
                        firma autógrafa. Después podrá imprimirse, firmarse
                        físicamente y posteriormente almacenarse el documento
                        firmado.
                    </p>
                    <div class="mt-6 max-w-md">
                        <div class="h-24 border-b border-black"></div>
                        <div class="text-center mt-2">
                            <p class="font-semibold">
                                {{ $client->nombre_completo }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                FIRMA AUTÓGRAFA DEL TITULAR
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- CONSENTIMIENTO --}}
                {{-- ================================================== --}}

                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <label class="flex items-start gap-3">

                        <input type="checkbox" id="consent" class="mt-1" required>

                        <span class="text-sm leading-6">
                            Declaro que he leído y entendido el Aviso de Privacidad Integral
                            y otorgo mi consentimiento para que mis datos personales sean
                            objeto de tratamiento y transferencia conforme a las finalidades
                            descritas en el presente aviso.
                        </span>

                    </label>
                </div>

                {{-- ================================================== --}}
                {{-- ACCIONES --}}
                {{-- ================================================== --}}

                <div class="flex justify-end gap-3">
                    <a href="{{ route('clients.index') }}"
                        class="px-6 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" id="generate-button"
                        class="px-6 py-3 rounded-lg bg-black text-white hover:bg-gray-800">
                        Generar aviso
                    </button>
                </div>
            </form>
        @endif
    </div>
    @if ($client)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                /*
                |--------------------------------------------------------------------------
                | ELEMENTOS
                |--------------------------------------------------------------------------
                */
                const canvas = document.getElementById('signature-pad');
                const ctx = canvas.getContext('2d');
                const signatureInput =
                    document.getElementById('digital_signature');
                const signatureStatus =
                    document.getElementById('signature-status');
                const digitalSection =
                    document.getElementById('digital-signature-section');
                const manualSection =
                    document.getElementById('manual-signature-section');
                const form =
                    document.getElementById('privacy-notice-form');
                /*
                |--------------------------------------------------------------------------
                | ESTADO
                |--------------------------------------------------------------------------
                */
                let drawing = false;
                let hasDrawing = false;
                let signatureConfirmed = false;
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
                    const rect = canvas.getBoundingClientRect();
                    const point =
                        event.touches
                            ? event.touches[0]
                            : event;
                    return {
                        x:
                            (point.clientX - rect.left) *
                            (canvas.width / rect.width),
                        y:
                            (point.clientY - rect.top) *
                            (canvas.height / rect.height),
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
                        'mt-4 text-sm text-amber-600';
                    const position = getPosition(event);
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
                    const position = getPosition(event);
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
                /*
                |--------------------------------------------------------------------------
                | MOUSE
                |--------------------------------------------------------------------------
                */
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
                /*
                |--------------------------------------------------------------------------
                | TOUCH
                |--------------------------------------------------------------------------
                */
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
                | LIMPIAR
                |--------------------------------------------------------------------------
                */
                document
                    .getElementById('clear-signature')
                    .addEventListener('click', () => {
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
                            'mt-4 text-sm text-amber-600';
                    });
                /*
                |--------------------------------------------------------------------------
                | CONFIRMAR
                |--------------------------------------------------------------------------
                */
                document
                    .getElementById('save-signature')
                    .addEventListener('click', () => {
                        if (!hasDrawing) {
                            signatureStatus.textContent =
                                'Debes dibujar una firma antes de confirmarla.';
                            signatureStatus.className =
                                'mt-4 text-sm text-red-600';
                            return;
                        }
                        const signature =
                            canvas.toDataURL('image/png');
                        signatureInput.value =
                            signature;
                        signatureConfirmed =
                            true;
                        signatureStatus.textContent =
                            'Firma capturada correctamente';
                        signatureStatus.className =
                            'mt-4 text-sm text-green-600';
                    });
                /*
                |--------------------------------------------------------------------------
                | CAMBIO DE TIPO
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
                    const selected =
                        document.querySelector(
                            'input[name="signature_type"]:checked'
                        ).value;
                    signatureOptions.forEach(option => {
                        const type =
                            option.dataset.type;
                        if (type === selected) {
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
                    });
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
                         * Firma manual no necesita
                         * imagen digital.
                         */
                        signatureInput.value = '';
                    }
                }
                signatureTypes.forEach(radio => {
                    radio.addEventListener(
                        'change',
                        updateSignatureType
                    );
                });
                updateSignatureType();
                /*
                |--------------------------------------------------------------------------
                | VALIDACIÓN ANTES DE ENVIAR
                |--------------------------------------------------------------------------
                */
                form.addEventListener(
                    'submit',
                    event => {
                        const selectedType =
                            document.querySelector(
                                'input[name="signature_type"]:checked'
                            ).value;
                        if (
                            selectedType === 'DIGITAL' &&
                            !signatureConfirmed
                        ) {
                            event.preventDefault();
                            signatureStatus.textContent =
                                'Debes confirmar la firma digital antes de generar el aviso.';
                            signatureStatus.className =
                                'mt-4 text-sm text-red-600';
                            digitalSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            return;
                        }
                        const consent =
                            document.getElementById(
                                'consent'
                            );
                        if (!consent.checked) {
                            event.preventDefault();
                            alert(
                                'Debes confirmar que has leído el aviso de privacidad.'
                            );
                        }
                    }
                );
            });
        </script>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const select = document.getElementById('client-select');

                if (!select) {
                    return;
                }

                const endpoint = '{{ route('clientes.firebird.search') }}';

                new TomSelect('#client-select', {

                    valueField: 'codigo',
                    labelField: 'nombre',
                    searchField: [],

                    placeholder: 'Escribe nombre, código o RFC...',

                    plugins: ['virtual_scroll'],

                    preload: false,

                    loadThrottle: 300,

                    shouldLoad: function (query) {
                        return query.trim().length >= 2;
                    },

                    firstUrl: function (query) {
                        return endpoint
                            + '?q=' + encodeURIComponent(query.trim())
                            + '&page=1'
                            + '&limit=50';
                    },

                    load: function (query, callback) {

                        const url = this.getUrl(query);

                        if (!url) {
                            callback();
                            return;
                        }

                        fetch(url)
                            .then(response => {

                                if (!response.ok) {
                                    throw new Error(
                                        'Error consultando clientes'
                                    );
                                }

                                return response.json();
                            })
                            .then(json => {

                                const pagination =
                                    json.pagination ?? {};

                                const currentPage =
                                    Number(pagination.page ?? 1);

                                const hasNextPage =
                                    Boolean(pagination.hasNextPage);

                                /*
                                 * Le indicamos a Tom Select cuál será
                                 * la siguiente URL.
                                 */
                                if (hasNextPage) {

                                    const nextPage =
                                        currentPage + 1;

                                    this.setNextUrl(
                                        query,
                                        endpoint
                                        + '?q='
                                        + encodeURIComponent(
                                            query.trim()
                                        )
                                        + '&page='
                                        + nextPage
                                        + '&limit=50'
                                    );

                                } else {

                                    this.setNextUrl(
                                        query,
                                        false
                                    );
                                }

                                callback(
                                    json.data ?? []
                                );
                            })
                            .catch(error => {

                                console.error(
                                    'Error Firebird:',
                                    error
                                );

                                callback();
                            });
                    },

                    render: {

                        option: function (item, escape) {

                            return `
                                    <div>
                                        <div style="font-weight:600">
                                            ${escape(item.nombre)}
                                        </div>

                                        <div style="
                                            font-size:12px;
                                            opacity:.7;
                                        ">
                                            ${escape(item.codigo)}

                                            ${item.rfc
                                    ? ' · RFC: '
                                    + escape(item.rfc)
                                    : ''
                                }
                                        </div>
                                    </div>
                                `;
                        },

                        item: function (item, escape) {

                            return `
                                    <div>
                                        ${escape(item.codigo)}
                                        -
                                        ${escape(item.nombre)}
                                    </div>
                                `;
                        },

                        no_results: function (data, escape) {

                            return `
                                    <div class="no-results">
                                        No se encontraron clientes
                                        para "${escape(data.input)}"
                                    </div>
                                `;
                        }
                    }
                });

            });
        </script>
    @endpush
@endsection