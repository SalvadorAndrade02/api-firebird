<x-guest-layout>

    <div>

        {{-- ENCABEZADO --}}
        <div class="mb-8">

            <p
                class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400"
            >
                Seguridad de la cuenta
            </p>

            <h1
                class="mt-2 text-3xl font-semibold tracking-tight text-gray-900"
            >
                Nueva contraseña
            </h1>

            <p
                class="mt-3 text-sm leading-6 text-gray-500"
            >
                Define una nueva contraseña para recuperar el acceso
                a tu cuenta.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('password.store') }}"
            class="space-y-5"
        >

            @csrf


            {{-- TOKEN --}}
            <input
                type="hidden"
                name="token"
                value="{{ $request->route('token') }}"
            >


            {{-- EMAIL --}}
            <div>

                <x-input-label
                    for="email"
                    value="Correo electrónico"
                />

                <x-text-input
                    id="email"
                    class="mt-2 block w-full"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    autocomplete="username"
                />

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2"
                />

            </div>


            {{-- PASSWORD --}}
            <div>

                <x-input-label
                    for="password"
                    value="Nueva contraseña"
                />

                <x-text-input
                    id="password"
                    class="mt-2 block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />

            </div>


            {{-- CONFIRMACIÓN --}}
            <div>

                <x-input-label
                    for="password_confirmation"
                    value="Confirmar contraseña"
                />

                <x-text-input
                    id="password_confirmation"
                    class="mt-2 block w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />

                <x-input-error
                    :messages="$errors->get('password_confirmation')"
                    class="mt-2"
                />

            </div>


            <div class="pt-2">

                <x-primary-button
                    class="w-full justify-center"
                >

                    Actualizar contraseña

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="ml-2 h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </x-primary-button>

            </div>

        </form>


        <div
            class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-4"
        >

            <p
                class="text-sm font-medium text-gray-700"
            >
                Recomendación de seguridad
            </p>

            <p
                class="mt-1 text-xs leading-5 text-gray-400"
            >
                Utiliza una contraseña diferente a las que uses en otros
                servicios y evita compartirla con terceros.
            </p>

        </div>

    </div>

</x-guest-layout>