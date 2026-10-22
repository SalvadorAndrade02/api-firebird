@extends('layouts.app')

@section('title', 'Bóveda documental')

@section('content')

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- ====================================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ====================================================== --}}

        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                    Repositorio documental
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                    Bóveda documental
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    Consulta, filtra y administra los avisos de privacidad
                    generados en el sistema.
                </p>

            </div>


            <a href="{{ route('privacy-notices.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Nuevo aviso

            </a>

        </div>


        {{-- ====================================================== --}}
        {{-- RESUMEN --}}
        {{-- ====================================================== --}}

        <div class="mb-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- TOTAL --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-black text-white">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M6 2h9l3 3v17H6zM9 9h6M9 13h6M9 17h4" />
                    </svg>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                    Total
                </p>

                <p class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ number_format($notices->total()) }}
                </p>

            </div>


            {{-- FIRMADOS --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    ✓
                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                    Estado actual
                </p>

                <p class="mt-1 text-sm font-semibold text-gray-900">
                    {{ $status === 'SIGNED' ? 'Firmados' : 'Todos' }}
                </p>

            </div>


            {{-- FIRMA --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 17l4-1 9-9-3-3-9 9-1 4z" />
                    </svg>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                    Tipo de firma
                </p>

                <p class="mt-1 text-sm font-semibold text-gray-900">
                    @if ($signatureType === 'DIGITAL')
                        Digital
                    @elseif ($signatureType === 'MANUAL')
                        Física
                    @else
                        Todas
                    @endif
                </p>

            </div>


            {{-- EMPRESA --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 21h18M5 21V5h14v16M9 9h2M13 9h2M9 13h2M13 13h2" />
                    </svg>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                    Empresa
                </p>

                <p class="mt-1 truncate text-sm font-semibold text-gray-900">
                    @php
                        $selectedCompany =
                            collect($companies)
                                ->firstWhere('id', $companyId);
                    @endphp

                    {{ $selectedCompany['nombre'] ?? 'Todas' }}
                </p>

            </div>

        </div>


        {{-- ====================================================== --}}
        {{-- FILTROS --}}
        {{-- ====================================================== --}}

        <section class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                        Filtros
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-gray-900">
                        Buscar documentos
                    </h2>

                </div>

                @if (
                        $search !== '' ||
                        $status ||
                        $signatureType ||
                        $companyId
                    )

                    <span class="inline-flex w-fit rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        Filtros activos
                    </span>

                @endif

            </div>


            <form method="GET" action="{{ route('privacy-notices.vault') }}">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

                    {{-- BUSCADOR --}}
                    <div class="xl:col-span-2">

                        <label for="search"
                            class="mb-2 block text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                            Buscar
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                                </svg>

                            </div>

                            <input type="text" id="search" name="search" value="{{ $search }}"
                                placeholder="Cliente, código o RFC..."
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-gray-400 focus:bg-white focus:ring-0">

                        </div>

                    </div>


                    {{-- EMPRESA --}}
                    <div>

                        <label for="company_id"
                            class="mb-2 block text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                            Empresa
                        </label>

                        <select name="company_id" id="company_id"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-3 text-sm outline-none focus:border-gray-400 focus:bg-white focus:ring-0">

                            <option value="">
                                Todas
                            </option>

                            @foreach ($companies as $company)

                                <option value="{{ $company['id'] }}" @selected($companyId == $company['id'])>
                                    {{ $company['nombre'] }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ESTADO --}}
                    <div>

                        <label for="status"
                            class="mb-2 block text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                            Estado
                        </label>

                        <select name="status" id="status"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-3 text-sm outline-none focus:border-gray-400 focus:bg-white focus:ring-0">

                            <option value="">
                                Todos
                            </option>

                            <option value="SIGNED" @selected($status === 'SIGNED')>
                                Firmado
                            </option>

                            <option value="PENDING_MANUAL_SIGNATURE" @selected(
                                $status === 'PENDING_MANUAL_SIGNATURE'
                            )>
                                Pendiente firma
                            </option>

                        </select>

                    </div>


                    {{-- TIPO DE FIRMA --}}
                    <div>

                        <label for="signature_type"
                            class="mb-2 block text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">
                            Firma
                        </label>

                        <select name="signature_type" id="signature_type"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-3 text-sm outline-none focus:border-gray-400 focus:bg-white focus:ring-0">

                            <option value="">
                                Todas
                            </option>

                            <option value="DIGITAL" @selected(
                                $signatureType === 'DIGITAL'
                            )>
                                Digital
                            </option>

                            <option value="MANUAL" @selected(
                                $signatureType === 'MANUAL'
                            )>
                                Física
                            </option>

                        </select>

                    </div>

                </div>


                <div class="mt-5 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('privacy-notices.vault') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-black">
                        Limpiar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-black px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 6h16M7 12h10M10 18h4" />
                        </svg>

                        Aplicar filtros

                    </button>

                </div>

            </form>

        </section>


        {{-- ====================================================== --}}
        {{-- TABLA --}}
        {{-- ====================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-400">
                        Documentos
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ number_format($notices->total()) }}
                        aviso{{ $notices->total() === 1 ? '' : 's' }}
                    </p>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-[#f8f8f8]">

                        <tr class="border-b border-gray-200">

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Aviso
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Cliente
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Empresa
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Origen
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Firma
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Estado
                            </th>

                            <th
                                class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Generado
                            </th>

                            <th
                                class="px-5 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($notices as $notice)

                                            @php
                                                $snapshot =
                                                    $notice->client_snapshot ?? [];

                                                $companySnapshot =
                                                    $notice->company_snapshot ?? [];

                                                $clientName =
                                                    $snapshot['nombre_completo']
                                                    ?? $notice->client?->nombre_completo
                                                    ?? '—';

                                                $clientCode =
                                                    $snapshot['codigo']
                                                    ?? $notice->client?->codigo
                                                    ?? '—';

                                                $clientRfc =
                                                    $snapshot['rfc']
                                                    ?? $notice->client?->rfc
                                                    ?? '—';

                                                $source =
                                                    $snapshot['source']
                                                    ?? 'main';

                                                $sourceLabel =
                                                    $snapshot['source_label']
                                                    ?? (
                                                        $source === 'oric'
                                                        ? 'MMW32_ORIC'
                                                        : 'MMW32'
                                                    );
                                            @endphp


                                            <tr class="transition hover:bg-gray-50/80">

                                                {{-- AVISO --}}
                                                <td class="px-5 py-4">

                                                    <p class="font-semibold text-gray-900">
                                                        #{{ $notice->id }}
                                                    </p>

                                                    <p class="mt-1 font-mono text-xs text-gray-400">
                                                        {{ $clientCode }}
                                                    </p>

                                                </td>


                                                {{-- CLIENTE --}}
                                                <td class="px-5 py-4">

                                                    <div class="max-w-xs">

                                                        <p class="font-semibold text-gray-900">
                                                            {{ $clientName }}
                                                        </p>

                                                        <p class="mt-1 text-xs text-gray-400">
                                                            RFC {{ $clientRfc }}
                                                        </p>

                                                    </div>

                                                </td>


                                                {{-- EMPRESA --}}
                                                <td class="px-5 py-4">

                                                    <div class="max-w-[260px]">

                                                        <p class="text-sm font-medium text-gray-700">
                                                            {{ $companySnapshot['nombre'] ?? '—' }}
                                                        </p>

                                                        <p class="mt-1 text-xs text-gray-400">
                                                            {{ $companySnapshot['rfc'] ?? '—' }}
                                                        </p>

                                                    </div>

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


                                                {{-- FIRMA --}}
                                                <td class="px-5 py-4">

                                                    @if ($notice->signature_type === 'DIGITAL')

                                                        <span
                                                            class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                            Digital
                                                        </span>

                                                    @elseif ($notice->signature_type === 'MANUAL')

                                                        <span
                                                            class="inline-flex rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-700">
                                                            Física
                                                        </span>

                                                    @else

                                                        <span class="text-sm text-gray-400">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- ESTADO --}}
                                                <td class="px-5 py-4">

                                                    @if ($notice->status === 'SIGNED')

                                                        <span
                                                            class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">

                                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                                            Firmado

                                                        </span>

                                                    @elseif (
                                                            $notice->status ===
                                                            'PENDING_MANUAL_SIGNATURE'
                                                        )

                                                        <span
                                                            class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">

                                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                                            Pendiente firma

                                                        </span>

                                                    @elseif ($notice->status === 'CANCELLED')

                                                        <span
                                                            class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                                            Cancelado
                                                        </span>

                                                    @else

                                                        <span
                                                            class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                                            {{ $notice->status }}
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- FECHA --}}
                                                <td class="px-5 py-4">

                                                    <p class="text-sm text-gray-700">
                                                        {{ $notice->created_at?->format('d/m/Y') }}
                                                    </p>

                                                    <p class="mt-1 text-xs text-gray-400">
                                                        {{ $notice->created_at?->format('H:i') }}
                                                    </p>

                                                </td>


                                                {{-- ACCIONES --}}
                                                <td class="px-5 py-4">

                                                    <div class="flex justify-end gap-2">

                                                        <a href="{{ route('privacy-notices.show', $notice) }}"
                                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 hover:text-black">

                                                            Ver

                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 5l7 7-7 7" />
                                                            </svg>

                                                        </a>


                                                        @if ($notice->pdf_path)

                                                            <a href="{{ route('privacy-notices.pdf', $notice) }}" target="_blank"
                                                                class="inline-flex items-center rounded-lg bg-black px-3 py-2 text-xs font-medium text-white transition hover:bg-gray-800">
                                                                PDF
                                                            </a>

                                                        @endif

                                                        <div x-data="{
                                open: false,
                                deleting: false
                            }">

                                                            <button type="button" @click="open = true"
                                                                class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-100">
                                                                Eliminar
                                                            </button>


                                                            {{-- MODAL --}}
                                                            <div x-show="open" x-cloak x-transition.opacity
                                                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 px-4">

                                                                <div @click.outside="open = false" x-transition
                                                                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

                                                                    {{-- ICONO --}}
                                                                    <div
                                                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">

                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="1.8" d="M6 7h12M9 7V4h6v3M8 7l1 13h6l1-13" />
                                                                        </svg>

                                                                    </div>


                                                                    {{-- CONTENIDO --}}
                                                                    <div class="mt-5">

                                                                        <h3 class="text-xl font-semibold text-gray-900">
                                                                            Eliminar aviso
                                                                        </h3>

                                                                        <p class="mt-2 text-sm leading-6 text-gray-500">
                                                                            Estás a punto de eliminar definitivamente el
                                                                            aviso
                                                                            <span class="font-semibold text-gray-800">
                                                                                #{{ $notice->id }}
                                                                            </span>.
                                                                        </p>

                                                                        <p class="mt-2 text-sm leading-6 text-gray-500">
                                                                            También se eliminarán el PDF generado y el
                                                                            documento firmado asociado, si existe.
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


                                                                        <form method="POST"
                                                                            action="{{ route('privacy-notices.destroy', $notice) }}"
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

                                                </td>

                                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="px-6 py-16 text-center">

                                    <div
                                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M4 7h16M5 7l1 13h12l1-13M9 11h6" />
                                        </svg>

                                    </div>

                                    <p class="mt-4 font-semibold text-gray-900">
                                        No se encontraron avisos
                                    </p>

                                    <p class="mt-1 text-sm text-gray-400">
                                        Ajusta los filtros o genera un nuevo aviso.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- PAGINACIÓN --}}
        {{-- ====================================================== --}}

        @if ($notices->hasPages())

        <div class="mt-6">

            {{ $notices->links() }}

        </div>

        @endif

    </div>

@endsection