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

<body class="bg-[#f5f6f8] text-[#161616] antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen lg:flex">

        {{-- ====================================================== --}}
        {{-- SIDEBAR --}}
        {{-- ====================================================== --}}

        {{-- OVERLAY MÓVIL --}}
        <div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-[1px] lg:hidden"></div>

        <aside class="
        fixed inset-y-0 left-0 z-50
        w-72
        bg-[#111111] text-white
        flex flex-col
        border-r border-white/10

        transform transition-transform duration-300 ease-out

        lg:static
        lg:z-auto
        lg:min-h-screen
        lg:translate-x-0
        lg:shrink-0
    " :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

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
                <button type="button" @click="sidebarOpen = false" class="
        flex h-9 w-9 items-center justify-center
        rounded-lg
        text-white/50
        hover:bg-white/10
        hover:text-white
        transition
        lg:hidden
    " aria-label="Cerrar menú">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>


            {{-- MENÚ --}}

            {{-- SERVIDOR ACTIVO --}}
            <div class="px-4 pt-5">

                <div class="rounded-xl border border-white/10 bg-white/5 p-4">

                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-white/35">
                        Marca activa
                    </p>


                    <div class="mt-2 flex items-center justify-between gap-3">

                        <div class="flex items-center gap-2">

                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                            <span class="text-sm font-semibold text-white">
                                {{ session('firebird_server_label') }}
                            </span>

                        </div>


                        <a href="{{ route('server.select') }} " @click="sidebarOpen = false"
                            class="text-xs font-medium text-white/40 transition hover:text-white">
                            Cambiar
                        </a>

                    </div>

                </div>

            </div>
            <nav class="flex-1 px-4 py-6">

                <p class="px-3 mb-3 text-[11px] uppercase tracking-[0.18em] text-white/35 font-semibold">
                    Navegación
                </p>

                <div class="space-y-1.5">

                    {{-- INICIO --}}
                    <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
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
                    <a href="{{ route('clients.index') }}" @click="sidebarOpen = false" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
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
                    <a href="{{ route('privacy-notices.create') }}" @click="sidebarOpen = false" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
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
                    <a href="{{ route('privacy-notices.vault') }}" @click="sidebarOpen = false" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
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

        <main class="min-w-0 flex-1 lg:flex-1">

            {{-- ================================================== --}}
            {{-- HEADER --}}
            {{-- ================================================== --}}

            <header class="
        sticky top-0 z-30
        flex h-[64px] sm:h-[72px]
        items-center justify-between
        border-b border-gray-200
        bg-white
        px-4 sm:px-6 lg:px-8
    ">

                <div class="flex items-center gap-3">

                    {{-- HAMBURGUESA --}}
                    <button type="button" @click="sidebarOpen = true" class="
            flex h-10 w-10 shrink-0
            items-center justify-center
            rounded-xl
            border border-gray-200
            bg-white
            text-gray-600
            transition
            hover:bg-gray-50
            lg:hidden
        " aria-label="Abrir menú">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>


                    <div>

                        <p class="hidden sm:block text-xs uppercase tracking-[0.14em] text-gray-400 font-semibold">
                            Grupo Rise
                        </p>

                        <p class="text-sm font-medium text-gray-700 sm:mt-0.5">
                            Gestión de Avisos de Privacidad
                        </p>

                    </div>

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
                                        <div x-show="open" @click.outside="open = false" x-transition class="
                        absolute right-0 z-50 mt-2
                        w-[calc(100vw-2rem)]
                        max-w-64
                        overflow-hidden
                        rounded-2xl
                        border border-gray-200
                        bg-white
                        shadow-xl
                    ">

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
                    class="mx-4 mt-4 sm:mx-6 sm:mt-6 lg:mx-8 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">

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
                    class="mx-4 mt-4 sm:mx-6 sm:mt-6 lg:mx-8 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">

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