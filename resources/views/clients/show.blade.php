@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">
            ← Regresar a clientes
        </a>
        <div class="bg-white rounded-xl shadow-sm p-8 mt-6">
            <div class="mb-8">
                <p class="text-sm font-mono text-gray-500">
                    Cliente {{ $client['codigo'] ?? '—' }}
                </p>
                <h1 class="text-3xl font-bold mt-1">
                    {{ $client['nombreCompleto'] ?? $client['nombre'] ?? '—' }}
                </h1>
                <div class="mt-3">
                    <span
                        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                        {{ $client['tipoPersona'] === 'FISICA' ? 'Persona física' : 'Persona moral' }}
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">RFC</p>
                    <p class="font-medium">
                        {{ $client['fiscal']['rfc'] ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Régimen fiscal</p>
                    <p class="font-medium">
                        {{ $client['fiscal']['regimenFiscal'] ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Teléfono</p>
                    <p class="font-medium">
                        {{ $client['contacto']['telefono'] ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Móvil</p>
                    <p class="font-medium">
                        {{ $client['contacto']['movil'] ?? '—' }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Correo</p>
                    <p class="font-medium">
                        {{ $client['contacto']['email'] ?? '—' }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">
                        Dirección
                    </p>
                    <p class="font-medium">
                        {{ $client['direccion']['calle'] ?? '—' }},
                        {{ $client['direccion']['numero'] ?? '' }},
                        {{ $client['direccion']['colonia'] ?? '—' }},
                        {{ $client['direccion']['municipio'] ?? '—' }},
                        {{ $client['direccion']['estado'] ?? '—' }},
                        CP {{ $client['direccion']['codigoPostal'] ?? '—' }}
                    </p>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end">
                <a href="{{ route('privacy-notices.create', [
        'client_code' => $client['codigo']
    ]) }}" class="inline-flex items-center gap-2 rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.232 5.232l3.536 3.536M9 11l6.232-6.232a2.5 2.5 0 013.536 3.536L12.536 14.536A4 4 0 019.707 15.7L7 16l.3-2.707A4 4 0 018.464 10.464L9 11z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h6M5 9h2M5 19h14" />
                    </svg>

                    Generar aviso de privacidad
                </a>
            </div>
        </div>
    </div>
@endsection