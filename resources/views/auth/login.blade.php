<x-guest-layout>

    <div>

        {{-- ====================================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ====================================================== --}}

        <div class="mb-8">

            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">
                Acceso al sistema
            </p>

            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
                Iniciar sesión
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-500">
                Ingresa tus credenciales para acceder a la plataforma
                de gestión de avisos de privacidad.
            </p>

        </div>


        {{-- ====================================================== --}}
        {{-- ESTADO DE SESIÓN --}}
        {{-- ====================================================== --}}

        <x-auth-session-status class="mb-6" :status="session('status')" />


        {{-- ====================================================== --}}
        {{-- FORMULARIO --}}
        {{-- ====================================================== --}}

        <form method="POST" action="{{ route('login') }}" class="space-y-5">

            @csrf


            {{-- EMAIL --}}
            <div>

                <x-input-label for="email" value="Correo electrónico" />

                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="usuario@empresa.com" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />

            </div>


            {{-- PASSWORD --}}
            <div>

                <div class="flex items-center justify-between gap-4">

                    <x-input-label for="password" value="Contraseña" />

                    @if (Route::has('password.request'))

                        <a href="{{ route('password.request') }}"
                            class="text-xs font-medium text-gray-500 transition hover:text-black">
                            ¿Olvidaste tu contraseña?
                        </a>

                    @endif

                </div>


                <x-text-input id="password" class="mt-2 block w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />

            </div>


            {{-- RECORDAR SESIÓN --}}
            <div>

                <label for="remember_me" class="inline-flex cursor-pointer items-center gap-3">

                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-black focus:ring-black">

                    <span class="text-sm text-gray-600">
                        Mantener sesión iniciada
                    </span>

                </label>

            </div>


            {{-- BOTÓN --}}
            <div class="pt-2">

                <x-primary-button class="w-full justify-center">

                    <span>
                        Ingresar
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>

                </x-primary-button>

            </div>

        </form>


        {{-- ====================================================== --}}
        {{-- INFORMACIÓN --}}
        {{-- ====================================================== --}}

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
                        Acceso protegido
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-400">
                        El acceso y las acciones realizadas dentro de la
                        plataforma están restringidos a usuarios autorizados.
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>