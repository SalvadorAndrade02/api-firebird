<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(
        \Illuminate\Http\Request $request,
        \App\Services\FirebirdClientApiService $firebird
    ) {
        $search = trim(
            (string) $request->query('buscar', '')
        );

        $page = max(
            1,
            (int) $request->query('page', 1)
        );

        $limit = 25;

        try {

            if ($search !== '') {
                $response = $firebird->search(
                    term: $search,
                    page: $page,
                    limit: $limit
                );
            } else {
                $response = $firebird->list(
                    page: $page,
                    limit: $limit
                );
            }

            $clients = $response['data'] ?? [];

            $pagination = $response['pagination'] ?? [
                'page' => $page,
                'limit' => $limit,
                'total' => 0,
                'totalPages' => 0,
                'hasNextPage' => false,
                'hasPreviousPage' => false,
            ];

            return view('clients.index', compact(
                'clients',
                'pagination',
                'search'
            ));

        } catch (\Throwable $e) {

            report($e);

            return view('clients.index', [
                'clients' => [],
                'pagination' => [
                    'page' => 1,
                    'limit' => $limit,
                    'total' => 0,
                    'totalPages' => 0,
                    'hasNextPage' => false,
                    'hasPreviousPage' => false,
                ],
                'search' => $search,
            ])->withErrors([
                        'clientes' => 'No fue posible consultar los clientes de Firebird.'
                    ]);
        }
    }

    public function show(
        string $codigo,
        \App\Services\FirebirdClientApiService $firebird
    ) {
        try {

            $response = $firebird->find($codigo);

            $client = $response['data'] ?? null;

            abort_if(
                !$client,
                404,
                'Cliente no encontrado.'
            );

            return view(
                'clients.show',
                compact('client')
            );

        } catch (\Throwable $e) {

            report($e);

            abort(
                503,
                'No fue posible consultar el cliente en Firebird.'
            );
        }
    }

    public function search(Request $request)
    {
        $term = trim($request->get('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $clients = Client::query()
            ->where(function ($query) use ($term) {
                $query
                    ->where('codigo', 'like', "%{$term}%")
                    ->orWhere('nombre_completo', 'like', "%{$term}%")
                    ->orWhere('rfc', 'like', "%{$term}%");
            })
            ->orderBy('nombre_completo')
            ->limit(10)
            ->get([
                'id',
                'codigo',
                'nombre_completo',
                'rfc',
            ]);

        return response()->json($clients);
    }
}