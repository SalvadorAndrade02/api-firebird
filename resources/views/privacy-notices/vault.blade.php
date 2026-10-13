@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold">
                    Bóveda documental
                </h1>
                <p class="text-gray-500 mt-2">
                    Avisos de privacidad generados y firmados.
                </p>
            </div>
            <a href="{{ route('privacy-notices.create') }}"
                class="rounded-lg bg-black px-5 py-3 text-white hover:bg-gray-800">
                Nuevo aviso
            </a>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('privacy-notices.vault') }}" class="grid lg:grid-cols-4 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium mb-2">
                        Buscar
                    </label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Código, nombre o RFC..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Estado
                    </label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-4 py-3">
                        <option value="">
                            Todos
                        </option>
                        <option value="SIGNED" @selected($status === 'SIGNED')>
                            Firmado
                        </option>
                        <option value="PENDING_MANUAL_SIGNATURE" @selected($status === 'PENDING_MANUAL_SIGNATURE')>
                            Pendiente firma física
                        </option>
                        <option value="GENERATED" @selected($status === 'GENERATED')>
                            Generado
                        </option>
                        <option value="CANCELLED" @selected($status === 'CANCELLED')>
                            Cancelado
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Tipo de firma
                    </label>
                    <select name="signature_type" class="w-full rounded-lg border border-gray-300 px-4 py-3">
                        <option value="">
                            Todos
                        </option>
                        <option value="DIGITAL" @selected($signatureType === 'DIGITAL')>
                            Digital
                        </option>
                        <option value="MANUAL" @selected($signatureType === 'MANUAL')>
                            Física
                        </option>
                    </select>
                </div>
                <div class="lg:col-span-4 flex gap-3">
                    <button type="submit" class="rounded-lg bg-black px-5 py-3 text-white hover:bg-gray-800">
                        Filtrar
                    </button>
                    <a href="{{ route('privacy-notices.vault') }}"
                        class="rounded-lg border border-gray-300 px-5 py-3 hover:bg-gray-50">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left px-5 py-4">
                                Aviso
                            </th>
                            <th class="text-left px-5 py-4">
                                Cliente
                            </th>
                            <th class="text-left px-5 py-4">
                                RFC
                            </th>
                            <th class="text-left px-5 py-4">
                                Firma
                            </th>
                            <th class="text-left px-5 py-4">
                                Estado
                            </th>
                            <th class="text-left px-5 py-4">
                                Generado
                            </th>
                            <th class="text-right px-5 py-4">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($notices as $notice)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <div class="font-semibold">
                                        #{{ $notice->id }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $notice->client->codigo }}
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-medium">
                                        {{ $notice->client->nombre_completo }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $notice->client->tipo_persona }}
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    {{ $notice->client->rfc ?: '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    @if ($notice->signature_type === 'DIGITAL')
                                        <span
                                            class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                            Digital
                                        </span>
                                    @elseif ($notice->signature_type === 'MANUAL')
                                        <span
                                            class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-700">
                                            Física
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($notice->status === 'SIGNED')
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Firmado
                                        </span>
                                    @elseif ($notice->status === 'PENDING_MANUAL_SIGNATURE')
                                        <span
                                            class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                            Pendiente firma
                                        </span>
                                    @elseif ($notice->status === 'CANCELLED')
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Cancelado
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                            {{ $notice->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div>
                                        {{ $notice->created_at?->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $notice->created_at?->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('privacy-notices.show', $notice) }}"
                                            class="text-blue-600 hover:underline">
                                            Ver
                                        </a>
                                        @if ($notice->pdf_path)
                                            <a href="{{ route('privacy-notices.pdf', $notice) }}" target="_blank"
                                                class="text-gray-700 hover:underline">
                                                PDF
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    No se encontraron avisos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-6">
            {{ $notices->links() }}
        </div>
    </div>
@endsection