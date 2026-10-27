<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Seleccionar marca · Grupo Rise
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-[#f5f6f8] text-[#161616] antialiased">

    <main class="flex min-h-screen items-center justify-center px-6 py-12">

        <div class="w-full max-w-5xl">

            {{-- ENCABEZADO --}}
            <div class="text-center">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-200">
                    <img src="{{ asset('images/rise-logo.png') }}" alt="Grupo Rise"
                        class="max-h-full max-w-full object-contain">
                </div>


                <p class="mt-7 text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">
                    Grupo Rise
                </p>


                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                    Selecciona la marca
                </h1>


                <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-gray-500">
                    Elige el servidor con el que deseas trabajar.
                    Esta selección determinará los clientes y empresas
                    disponibles durante tu sesión.
                </p>

            </div>


            @if ($errors->any())

                <div
                    class="mx-auto mt-8 max-w-xl rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>

            @endif


            {{-- MARCAS --}}
            <div class="mt-10 grid gap-6 md:grid-cols-2">

                {{-- POLARIS --}}
                <form method="POST" action="{{ route('server.store') }}">

                    @csrf

                    <input type="hidden" name="server" value="polaris">


                    <button type="submit"
                        class="group w-full overflow-hidden rounded-[28px] border border-gray-200 bg-white p-8 text-left shadow-sm transition duration-200 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                        <div class="flex min-h-44 items-center justify-center rounded-2xl bg-gray-50 p-8">

                            <img src="{{ asset('images/brands/polaris-logo.png') }}" alt="Polaris"
                                class="max-h-24 max-w-[240px] object-contain">

                        </div>


                        <div class="mt-6 flex items-end justify-between gap-5">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                                    Servidor
                                </p>

                                <h2 class="mt-2 text-2xl font-semibold text-gray-900">
                                    Polaris
                                </h2>

                                <p class="mt-2 text-sm text-gray-500">
                                    Acceder a clientes y empresas Polaris.
                                </p>

                            </div>


                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500 transition group-hover:bg-black group-hover:text-white">
                                →
                            </span>

                        </div>

                    </button>

                </form>


                {{-- CAN-AM --}}
                <form method="POST" action="{{ route('server.store') }}">

                    @csrf

                    <input type="hidden" name="server" value="canam">


                    <button type="submit"
                        class="group w-full overflow-hidden rounded-[28px] border border-gray-200 bg-white p-8 text-left shadow-sm transition duration-200 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                        <div class="flex min-h-44 items-center justify-center rounded-2xl bg-gray-50 p-8">

                            <img src="{{ asset('images/brands/canam-logo.png') }}" alt="Can-Am"
                                class="max-h-24 max-w-[240px] object-contain">

                        </div>


                        <div class="mt-6 flex items-end justify-between gap-5">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gray-400">
                                    Servidor
                                </p>

                                <h2 class="mt-2 text-2xl font-semibold text-gray-900">
                                    Can-Am
                                </h2>

                                <p class="mt-2 text-sm text-gray-500">
                                    Acceder a clientes y empresas Can-Am.
                                </p>

                            </div>


                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500 transition group-hover:bg-black group-hover:text-white">
                                →
                            </span>

                        </div>

                    </button>

                </form>

            </div>


            {{-- CERRAR SESIÓN --}}
            <div class="mt-9 text-center">

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="text-sm font-medium text-gray-400 transition hover:text-black">
                        Cerrar sesión
                    </button>

                </form>

            </div>

        </div>

    </main>

</body>

</html>