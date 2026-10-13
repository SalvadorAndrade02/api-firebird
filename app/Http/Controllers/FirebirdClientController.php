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
    ): JsonResponse {
        $term = trim((string) $request->query('q', ''));

        $page = max(1, (int) $request->query('page', 1));
        $limit = max(1, min(
            (int) $request->query('limit', 50),
            100
        ));

        if (mb_strlen($term) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => 0,
                    'totalPages' => 0,
                    'hasNextPage' => false,
                ],
            ]);
        }

        try {
            $response = $firebird->search(
                term: $term,
                page: $page,
                limit: $limit
            );

            $clientes = collect($response['data'] ?? [])
                ->map(function (array $cliente) {
                    return [
                        'codigo' => $cliente['codigo'] ?? null,
                        'nombre' => $cliente['nombreCompleto']
                            ?? $cliente['nombre']
                            ?? '',
                        'rfc' => $cliente['fiscal']['rfc'] ?? '',
                        'tipoPersona' => $cliente['tipoPersona'] ?? '',
                    ];
                })
                ->filter(fn($cliente) => !empty($cliente['codigo']))
                ->values();

            return response()->json([
                'success' => true,
                'data' => $clientes,
                'pagination' => $response['pagination'] ?? [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => count($clientes),
                    'totalPages' => 1,
                    'hasNextPage' => false,
                ],
            ]);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'No fue posible consultar los clientes.',
            ], 500);
        }
    }
}
