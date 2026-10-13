<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Avisos de Privacidad')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen">
            <div class="p-6 border-b">
                <h1 class="text-xl font-bold">
                    Grupo Rise
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Avisos de Privacidad
                </p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-4 py-3
                    {{ request()->routeIs('dashboard')
    ? 'bg-black text-white'
    : 'text-gray-700 hover:bg-gray-100' }}">
                    Inicio
                </a>
                <a href="{{ route('clients.index') }}" class="block rounded-lg px-4 py-3
                    {{ request()->routeIs('clients.*')
    ? 'bg-black text-white'
    : 'text-gray-700 hover:bg-gray-100' }}">
                    Clientes
                </a>
                <a href="{{ route('privacy-notices.create') }}" class="block rounded-lg px-4 py-3
                    {{ request()->routeIs('privacy-notices.create')
    ? 'bg-black text-white'
    : 'text-gray-700 hover:bg-gray-100' }}">
                    Nuevo aviso
                </a>
                <a href="{{ route('privacy-notices.vault') }}" class="block rounded-lg px-4 py-3
                    {{ request()->routeIs('privacy-notices.vault')
    ? 'bg-black text-white'
    : 'text-gray-700 hover:bg-gray-100' }}">
                    Bóveda
                </a>
            </nav>
        </aside>

        {{-- CONTENIDO --}}
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-6 py-10">
                @if (session('success'))

                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>