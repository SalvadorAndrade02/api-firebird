<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Avisos de Privacidad')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#f5f6f8] text-[#161616] antialiased">

    <div class="min-h-screen flex">

        {{-- ====================================================== --}}
        {{-- SIDEBAR --}}
        {{-- ====================================================== --}}

        <aside class="w-72 bg-[#111111] text-white min-h-screen flex flex-col border-r border-white/10">

            {{-- LOGO / IDENTIDAD --}}
            <div class="px-7 py-7 border-b border-white/10">

                <div class="flex items-center gap-3">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white p-2 shadow-sm">
                        <img src="{{ asset('images/rise-logo.png') }}" alt="Logo Grupo Rise"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div>
                        <div class="text-lg font-semibold tracking-tight">
                            Grupo Rise
                        </div>

                        <div class="text-xs text-white/50 mt-0.5">
                            Avisos de Privacidad
                        </div>
                    </div>

                </div>

            </div>


            {{-- MENÚ --}}
            <nav class="flex-1 px-4 py-6">

                <p class="px-3 mb-3 text-[11px] uppercase tracking-[0.18em] text-white/35 font-semibold">
                    Navegación
                </p>

                <div class="space-y-1.5">

                    {{-- INICIO --}}
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
    ? 'bg-white text-black shadow-sm'
    : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                        </svg>

                        <span>
                            Inicio
                        </span>

                    </a>


                    {{-- CLIENTES --}}
                    <a href="{{ route('clients.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('clients.*')
    ? 'bg-white text-black shadow-sm'
    : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>

                        <span>
                            Clientes
                        </span>

                    </a>


                    {{-- NUEVO AVISO --}}
                    <a href="{{ route('privacy-notices.create') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('privacy-notices.create')
    ? 'bg-white text-black shadow-sm'
    : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 5v14M5 12h14" />
                        </svg>

                        <span>
                            Nuevo aviso
                        </span>

                    </a>


                    {{-- BÓVEDA --}}
                    <a href="{{ route('privacy-notices.vault') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('privacy-notices.vault')
    ? 'bg-white text-black shadow-sm'
    : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 7h16M5 7l1 13h12l1-13M9 11h6" />
                        </svg>

                        <span>
                            Bóveda
                        </span>

                    </a>

                </div>

            </nav>


            {{-- FOOTER SIDEBAR --}}
            <div class="px-5 py-5 border-t border-white/10">

                <div class="rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                    <p class="text-xs font-medium text-white/80">
                        Sistema documental
                    </p>

                    <p class="text-[11px] text-white/40 mt-1">
                        Desarrollado por: Nantli Soluciones
                    </p>
                </div>

            </div>

        </aside>


        {{-- ====================================================== --}}
        {{-- CONTENIDO PRINCIPAL --}}
        {{-- ====================================================== --}}

        <main class="flex-1 min-w-0">

            {{-- ================================================== --}}
            {{-- HEADER --}}
            {{-- ================================================== --}}

            <header
                class="h-[72px] bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-40">

                <div>

                    <p class="text-xs uppercase tracking-[0.14em] text-gray-400 font-semibold">
                        Grupo Rise
                    </p>

                    <p class="text-sm font-medium text-gray-700 mt-0.5">
                        Gestión de Avisos de Privacidad
                    </p>

                </div>


                @auth

                    <div class="relative" x-data="{ open: false }">

                        <button type="button" @click="open = !open"
                            class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-gray-50 transition">

                            <div class="text-right hidden sm:block">

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ auth()->user()->email }}
                                </p>

                            </div>

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#111111] text-sm font-semibold text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>


                        {{-- DROPDOWN --}}
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 z-50 mt-2 w-64 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
                            style="display: none;">

                            <div class="px-4 py-4 border-b border-gray-100">

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-gray-400 truncate mt-1">
                                    {{ auth()->user()->email }}
                                </p>

                            </div>

                            <form method="POST" action="{{ route('logout') }}" class="p-2">
                                @csrf

                                <button type="submit"
                                    class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                    Cerrar sesión
                                </button>

                            </form>

                        </div>

                    </div>

                @endauth

            </header>


            {{-- ================================================== --}}
            {{-- MENSAJES --}}
            {{-- ================================================== --}}

            @if (session('success'))

                <div
                    class="mx-8 mt-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100">
                        ✓
                    </div>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if (session('error'))

                <div
                    class="mx-8 mt-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100">
                        !
                    </div>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            {{-- ================================================== --}}
            {{-- CONTENIDO --}}
            {{-- ================================================== --}}

            <div class="min-h-[calc(100vh-72px)]">
                @yield('content')
            </div>

        </main>

    </div>

    @stack('scripts')

</body>

</html>