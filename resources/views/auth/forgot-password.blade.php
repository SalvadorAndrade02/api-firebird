<x-guest-layout>

    <div>

        {{-- ENCABEZADO --}}
        <div class="mb-8">

            <a href="{{ route('login') }}"
                class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-gray-400 transition hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>

                Regresar al inicio de sesión
            </a>


            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                Recuperación de acceso
            </p>

            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                Recuperar contraseña
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-500">
                Ingresa el correo electrónico asociado a tu cuenta.
                Te enviaremos un enlace para definir una nueva contraseña.
            </p>

        </div>


        {{-- ESTADO --}}
        <x-auth-session-status class="mb-6" :status="session('status')" />


        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">

            @csrf


            <div>

                <x-input-label for="email" value="Correo electrónico" />

                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="email" placeholder="usuario@empresa.com" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />

            </div>


            <div class="pt-2">

                <x-primary-button class="w-full justify-center">

                    Enviar enlace de recuperación

                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>

                </x-primary-button>

            </div>

        </form>


        {{-- INFORMACIÓN --}}
        <div class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-4">

            <div class="flex items-start gap-3">

                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm ring-1 ring-gray-200">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z" />
                    </svg>

                </div>

                <div>

                    <p class="text-sm font-medium text-gray-700">
                        Enlace temporal
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-400">
                        El enlace de recuperación tendrá una vigencia limitada
                        y solo podrá utilizarse para restablecer la contraseña.
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>