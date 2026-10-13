@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div class="mb-8">

        <h1 class="text-3xl font-bold">
            Panel principal
        </h1>

        <p class="text-gray-500 mt-2">
            Gestión de clientes y avisos de privacidad.
        </p>

    </div>


    <div class="grid md:grid-cols-3 gap-6">

        <a href="{{ route('clients.index') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Clientes
            </p>

            <p class="text-2xl font-bold mt-2">
                Consultar
            </p>

        </a>


        <a href="{{ route('privacy-notices.create') }}"
            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Avisos
            </p>

            <p class="text-2xl font-bold mt-2">
                Nuevo aviso
            </p>

        </a>


        <a href="{{ route('privacy-notices.vault') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Documentos
            </p>

            <p class="text-2xl font-bold mt-2">
                Bóveda
            </p>

        </a>

    </div>

@endsection