@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">
                        Aviso #{{ $notice->id }}
                    </p>
                    <h1 class="text-2xl font-bold mt-1">
                        {{ $notice->client->nombre_completo }}
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Estado: {{ $notice->status }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('privacy-notices.create', ['client' => $notice->client_id]) }}"
                        class="px-5 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                        Regresar
                    </a>
                    @if ($notice->pdf_path)
                        <a href="{{ route('privacy-notices.pdf', $notice) }}" target="_blank"
                            class="px-5 py-3 rounded-lg bg-black text-white hover:bg-gray-800">
                            Ver PDF
                        </a>
                        <a href="{{ route('privacy-notices.pdf', $notice) }}?download=1"
                            class="px-5 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                            Descargar PDF
                        </a>
                        <button type="button" onclick="printPdf()"
                            class="px-5 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                            Imprimir
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">
                Documento generado
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">
                        Código del cliente
                    </p>
                    <p class="font-medium">
                        {{ $notice->client->codigo }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">
                        Tipo de firma
                    </p>
                    <p class="font-medium">
                        {{ $notice->signature_type }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">
                        Generado
                    </p>
                    <p class="font-medium">
                        {{ $notice->created_at?->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">
                        Firmado
                    </p>
                    <p class="font-medium">
                        {{ $notice->signed_at?->format('d/m/Y H:i') ?? 'Pendiente' }}
                    </p>
                </div>
            </div>
        </div>
        @if ($notice->signature_type === 'MANUAL')
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-2">
                    Firma física
                </h2>
                <p class="text-gray-500 mb-4">
                    Imprime el aviso, solicita la firma autógrafa y posteriormente
                    sube el documento firmado.
                </p>
                <form method="POST" action="{{ route('privacy-notices.upload-signed', $notice) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="signed_pdf" accept="application/pdf" required
                        class="block w-full rounded-lg border border-gray-300 p-3">
                    <button type="submit" class="mt-4 px-5 py-3 rounded-lg bg-black text-white">
                        Subir PDF firmado
                    </button>
                </form>
            </div>
        @endif
    </div>
    <script>
        function printPdf() {
            const url = @json(route('privacy-notices.pdf', $notice));
            const printWindow = window.open(
                url,
                '_blank'
            );
            if (!printWindow) {
                alert('El navegador bloqueó la ventana de impresión.');
                return;
            }
            printWindow.addEventListener('load', () => {
                printWindow.print();
            });
        }
    </script>
@endsection