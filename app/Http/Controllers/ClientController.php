<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\FirebirdClientApiService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE CLIENTES
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request,
        FirebirdClientApiService $firebird
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


            $clients =
                $response['data']
                ?? [];


            $pagination =
                $response['pagination']
                ?? [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => 0,
                    'totalPages' => 0,
                    'hasNextPage' => false,
                    'hasPreviousPage' => false,
                ];


            return view(
                'clients.index',
                compact(
                    'clients',
                    'pagination',
                    'search'
                )
            );

        } catch (\Throwable $e) {

            report($e);

            return view(
                'clients.index',
                [
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
                ]
            )->withErrors([
                        'clientes' =>
                            'No fue posible consultar los clientes de Firebird.',
                    ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DETALLE DEL CLIENTE
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        string $codigo,
        FirebirdClientApiService $firebird
    ) {
        /*
         * La base principal sigue siendo el origen por defecto
         * para mantener compatibilidad con enlaces anteriores.
         */
        $source = strtolower(
            trim(
                (string) $request->query(
                    'source',
                    'main'
                )
            )
        );


        /*
         * No permitir cualquier valor como origen.
         */
        if (
            !in_array(
                $source,
                ['main', 'oric'],
                true
            )
        ) {
            abort(
                400,
                'Origen de cliente inválido.'
            );
        }


        try {

            /*
             * IMPORTANTE:
             *
             * FirebirdClientApiService::find()
             * YA devuelve directamente los datos
             * del cliente.
             */
            $client = $firebird->find(
                $codigo,
                $source
            );


            if (!$client) {
                abort(
                    404,
                    'Cliente no encontrado.'
                );
            }


            return view(
                'clients.show',
                compact('client')
            );

        } catch (
            \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e
        ) {

            /*
             * Si nosotros lanzamos 404/400,
             * Laravel debe conservar ese código.
             *
             * No convertirlo en 503.
             */
            throw $e;

        } catch (\Throwable $e) {

            report($e);

            abort(
                503,
                'No fue posible consultar el cliente en Firebird.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BÚSQUEDA LOCAL
    |--------------------------------------------------------------------------
    |
    | Este método consulta la caché MySQL local.
    | El buscador principal remoto utiliza FirebirdClientController.
    |
    */

    public function search(Request $request)
    {
        $term = trim(
            $request->get('q', '')
        );


        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }


        $server =
            session('firebird_server');

        $clients =
            Client::query()

                ->where(
                    'server',
                    $server
                )

                ->where(
                    function ($query) use ($term) {

                        $query
                            ->where(
                                'codigo',
                                'like',
                                "%{$term}%"
                            )

                            ->orWhere(
                                'nombre_completo',
                                'like',
                                "%{$term}%"
                            )

                            ->orWhere(
                                'rfc',
                                'like',
                                "%{$term}%"
                            );
                    }
                )

                ->orderBy(
                    'nombre_completo'
                )

                ->limit(10)

                ->get([
                    'id',
                    'server',
                    'codigo',
                    'source',
                    'nombre_completo',
                    'rfc',
                ]);


        return response()->json(
            $clients
        );
    }
}