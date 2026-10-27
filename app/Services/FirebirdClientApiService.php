<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebirdClientApiService
{
    public function __construct(
        private FirebirdApiConnectionResolver $resolver
    ) {
    }


    private function connection(): array
    {
        return $this->resolver->resolve();
    }


    private function client(
        array $connection
    ) {
        return Http::withHeaders([
            'X-API-KEY' =>
                $connection['key'],
        ])
            ->acceptJson()
            ->timeout(15)
            ->connectTimeout(5);
    }


    public function search(
        string $term,
        int $page = 1,
        int $limit = 20
    ): array {

        $connection =
            $this->connection();


        $response =
            $this->client($connection)
                ->get(
                    $connection['url']
                    . '/api/v1/clientes',
                    [
                        'buscar' => $term,
                        'page' => $page,
                        'limit' => $limit,
                    ]
                );


        if ($response->failed()) {

            throw new RuntimeException(
                'No fue posible consultar clientes en '
                . $connection['label']
                . '.'
            );
        }


        $json =
            $response->json();


        if (!is_array($json)) {

            throw new RuntimeException(
                'La API de clientes devolvió una respuesta inválida.'
            );
        }


        return $json;
    }


    public function find(
        string $codigo,
        string $source = 'main'
    ): array {

        $connection =
            $this->connection();


        $response =
            $this->client($connection)
                ->get(
                    $connection['url']
                    . '/api/v1/clientes/'
                    . urlencode($codigo),
                    [
                        'source' => $source,
                    ]
                );


        if ($response->failed()) {

            throw new RuntimeException(
                'No fue posible consultar el cliente en '
                . $connection['label']
                . '.'
            );
        }


        $json =
            $response->json();


        if (
            !is_array($json)
            || !($json['success'] ?? false)
            || !isset($json['data'])
        ) {

            throw new RuntimeException(
                'Respuesta inválida al consultar el cliente.'
            );
        }


        return $json['data'];
    }


    public function health(): array
    {
        $connection =
            $this->connection();


        $response =
            Http::acceptJson()
                ->timeout(10)
                ->connectTimeout(5)
                ->get(
                    $connection['url']
                    . '/api/v1/health'
                );


        if ($response->failed()) {

            throw new RuntimeException(
                'La API '
                . $connection['label']
                . ' no está disponible.'
            );
        }


        return $response->json();
    }


    public function list(
        int $page = 1,
        int $limit = 25
    ): array {

        $connection =
            $this->connection();


        $response =
            $this->client($connection)
                ->get(
                    $connection['url']
                    . '/api/v1/clientes',
                    [
                        'page' => $page,
                        'limit' => $limit,
                    ]
                );


        if ($response->failed()) {

            throw new RuntimeException(
                'No fue posible consultar el listado de clientes en '
                . $connection['label']
                . '.'
            );
        }


        $json =
            $response->json();


        if (!is_array($json)) {

            throw new RuntimeException(
                'Respuesta inválida al consultar el listado de clientes.'
            );
        }


        return $json;
    }
}