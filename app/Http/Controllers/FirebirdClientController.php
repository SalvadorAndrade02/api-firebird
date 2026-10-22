<?php

namespace App\Http\Controllers;

use App\Services\FirebirdClientApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class FirebirdClientController extends Controller
{
    public function search(
        Request $request,
        FirebirdClientApiService $firebird
    ) {
        $term = trim(
            (string) $request->query('q', '')
        );

        $page = max(
            1,
            (int) $request->query('page', 1)
        );

        $limit = max(
            1,
            min(
                (int) $request->query('limit', 50),
                100
            )
        );

        $response = $term !== ''
            ? $firebird->search(
                $term,
                $page,
                $limit
            )
            : $firebird->list(
                $page,
                $limit
            );

        $data = collect(
            $response['data'] ?? []
        )
            ->map(function (array $client) {

                $codigo = trim(
                    (string) (
                        $client['codigo']
                        ?? ''
                    )
                );

                $source = trim(
                    (string) (
                        $client['source']
                        ?? 'main'
                    )
                );

                $sourceLabel =
                    $client['sourceLabel']
                    ?? (
                        $source === 'oric'
                        ? 'MMW32_ORIC'
                        : 'MMW32'
                    );

                return [
                    'codigo' =>
                        $codigo,

                    'nombre' =>
                        $client['nombreCompleto']
                        ?? $client['nombre']
                        ?? '',

                    'rfc' =>
                        $client['fiscal']['rfc']
                        ?? '',

                    'tipoPersona' =>
                        $client['tipoPersona']
                        ?? null,

                    'source' =>
                        $source,

                    'sourceLabel' =>
                        $sourceLabel,

                    'key' =>
                        $source
                        . '|'
                        . $codigo,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,

            'data' =>
                $data,

            'pagination' =>
                $response['pagination']
                ?? [],
        ]);
    }
}
