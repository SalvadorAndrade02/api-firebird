<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Grupo Rise · Avisos de Privacidad')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-[#f5f6f8] text-[#161616] antialiased">

    <div class="min-h-screen lg:grid lg:grid-cols-[1.05fr_0.95fr]">

        {{-- ====================================================== --}}
        {{-- PANEL IZQUIERDO --}}
        {{-- ====================================================== --}}

        <section
            class="relative hidden overflow-hidden bg-[#111111] text-white lg:flex lg:min-h-screen lg:flex-col lg:justify-between">

            {{-- DECORACIÓN --}}
            <div
                class="pointer-events-none absolute -right-40 -top-40 h-[520px] w-[520px] rounded-full border border-white/10">
            </div>

            <div
                class="pointer-events-none absolute -right-20 -top-20 h-[360px] w-[360px] rounded-full border border-white/10">
            </div>

            <div
                class="pointer-events-none absolute bottom-[-180px] left-[-140px] h-[460px] w-[460px] rounded-full border border-white/10">
            </div>


            {{-- MARCA --}}
            <div class="relative z-10 px-12 pt-12 xl:px-16">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2.5 shadow-lg">
                        <img src="{{ asset('images/rise-logo.png') }}" alt="Logo Grupo Rise"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div>

                        <p class="text-xl font-semibold tracking-tight">
                            Grupo Rise
                        </p>

                        <p class="mt-1 text-sm text-white/45">
                            Gestión documental
                        </p>

                    </div>

                </div>

            </div>


            {{-- CONTENIDO PRINCIPAL --}}
            <div class="relative z-10 max-w-2xl px-12 pb-10 xl:px-16">

                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/35">
                    Plataforma interna
                </p>

                <h1 class="mt-5 text-4xl font-semibold leading-tight tracking-tight xl:text-5xl">
                    Gestión segura de
                    avisos de privacidad.
                </h1>

                <p class="mt-6 max-w-xl text-base leading-7 text-white/55">
                    Consulta información de clientes, genera documentos,
                    administra firmas y conserva el expediente histórico
                    desde una sola plataforma.
                </p>


                <div class="mt-10 grid max-w-xl gap-3 sm:grid-cols-3">

                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                        <p class="text-sm font-semibold text-white">
                            Firebird
                        </p>

                        <p class="mt-1 text-xs leading-5 text-white/40">
                            Consulta multibase
                        </p>
                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                        <p class="text-sm font-semibold text-white">
                            Documentos
                        </p>

                        <p class="mt-1 text-xs leading-5 text-white/40">
                            PDF y firma
                        </p>
                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                        <p class="text-sm font-semibold text-white">
                            Bóveda
                        </p>

                        <p class="mt-1 text-xs leading-5 text-white/40">
                            Expediente histórico
                        </p>
                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div
                class="relative z-10 flex items-center justify-between border-t border-white/10 px-12 py-6 text-xs text-white/30 xl:px-16">

                <span>
                    Grupo Rise
                </span>

                <span>
                    Sistema de Avisos de Privacidad
                </span>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- PANEL DERECHO --}}
        {{-- ====================================================== --}}

        <main class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-10 lg:px-14 xl:px-20">

            <div class="w-full max-w-md">

                {{-- LOGO MÓVIL --}}
                <div class="mb-10 flex items-center gap-3 lg:hidden">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200">
                        <img src="{{ asset('images/rise-logo.png') }}" alt="Logo Grupo Rise"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div>

                        <p class="font-semibold text-gray-900">
                            Grupo Rise
                        </p>

                        <p class="text-xs text-gray-400">
                            Avisos de Privacidad
                        </p>

                    </div>

                </div>


                {{-- CONTENIDO --}}
                {{ $slot }}


                {{-- FOOTER MÓVIL / DERECHO --}}
                <p class="mt-10 text-center text-xs text-gray-400">
                    Acceso exclusivo para personal autorizado.
                </p>

            </div>

        </main>

    </div>

</body>

</html>