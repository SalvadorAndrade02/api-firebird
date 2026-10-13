<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientSyncController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validar API Key
        |--------------------------------------------------------------------------
        */

        $receivedApiKey = $request->header('X-SYNC-API-KEY');
        $expectedApiKey = config('services.client_sync.key');

        if (
            !$receivedApiKey ||
            !$expectedApiKey ||
            !hash_equals($expectedApiKey, $receivedApiKey)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'SYNC API Key inválida o no proporcionada',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Validar payload
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'codigo' => [
                'required',
                'string',
                'size:8',
            ],

            'tipoPersona' => [
                'nullable',
                'string',
                'in:FISICA,MORAL',
            ],

            'nombre' => [
                'nullable',
                'string',
                'max:255',
            ],

            'apellido1' => [
                'nullable',
                'string',
                'max:255',
            ],

            'apellido2' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nombreCompleto' => [
                'nullable',
                'string',
                'max:255',
            ],

            'fiscal' => [
                'nullable',
                'array',
            ],

            'fiscal.rfc' => [
                'nullable',
                'string',
                'max:20',
            ],

            'fiscal.numeroRegistroTributario' => [
                'nullable',
                'string',
                'max:255',
            ],

            'fiscal.regimenFiscal' => [
                'nullable',
                'string',
                'max:20',
            ],

            'direccion' => [
                'nullable',
                'array',
            ],

            'direccion.calle' => [
                'nullable',
                'string',
                'max:255',
            ],

            'direccion.numero' => [
                'nullable',
                'string',
                'max:255',
            ],

            'direccion.codigoPostal' => [
                'nullable',
                'string',
                'max:15',
            ],

            'direccion.colonia' => [
                'nullable',
                'string',
                'max:255',
            ],

            'direccion.municipio' => [
                'nullable',
                'string',
                'max:255',
            ],

            'direccion.estado' => [
                'nullable',
                'string',
                'max:255',
            ],

            'direccion.pais' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contacto' => [
                'nullable',
                'array',
            ],

            'contacto.telefono' => [
                'nullable',
                'string',
                'max:50',
            ],

            'contacto.movil' => [
                'nullable',
                'string',
                'max:50',
            ],

            'contacto.email' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | INSERT / UPDATE
        |--------------------------------------------------------------------------
        */

        $client = Client::updateOrCreate(
            [
                'codigo' => $validated['codigo'],
            ],
            [
                'tipo_persona' => $validated['tipoPersona'] ?? null,

                'nombre' => $validated['nombre'] ?? null,
                'apellido1' => $validated['apellido1'] ?? null,
                'apellido2' => $validated['apellido2'] ?? null,
                'nombre_completo' => $validated['nombreCompleto'] ?? null,

                'rfc' => data_get($validated, 'fiscal.rfc'),
                'numero_registro_tributario' => data_get(
                    $validated,
                    'fiscal.numeroRegistroTributario'
                ),
                'regimen_fiscal' => data_get(
                    $validated,
                    'fiscal.regimenFiscal'
                ),

                'calle' => data_get(
                    $validated,
                    'direccion.calle'
                ),

                'numero' => data_get(
                    $validated,
                    'direccion.numero'
                ),

                'codigo_postal' => data_get(
                    $validated,
                    'direccion.codigoPostal'
                ),

                'colonia' => data_get(
                    $validated,
                    'direccion.colonia'
                ),

                'municipio' => data_get(
                    $validated,
                    'direccion.municipio'
                ),

                'estado' => data_get(
                    $validated,
                    'direccion.estado'
                ),

                'pais' => data_get(
                    $validated,
                    'direccion.pais'
                ),

                'telefono' => data_get(
                    $validated,
                    'contacto.telefono'
                ),

                'movil' => data_get(
                    $validated,
                    'contacto.movil'
                ),

                'email' => data_get(
                    $validated,
                    'contacto.email'
                ),

                'synced_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => $client->wasRecentlyCreated
                ? 'Cliente creado correctamente'
                : 'Cliente actualizado correctamente',
            'data' => [
                'id' => $client->id,
                'codigo' => $client->codigo,
            ],
        ], $client->wasRecentlyCreated ? 201 : 200);
    }
}