<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebirdCompanyApiService
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


    public function list(): array
    {
        $connection =
            $this->connection();


        $response =
            $this->client($connection)
                ->get(
                    $connection['url']
                    . '/api/v1/empresas'
                );


        if ($response->failed()) {

            throw new RuntimeException(
                'No fue posible consultar las empresas en '
                . $connection['label']
                . '.'
            );
        }


        $json =
            $response->json();


        if (!is_array($json)) {

            throw new RuntimeException(
                'La API de empresas devolvió una respuesta inválida.'
            );
        }


        return $json;
    }


    public function find(
        int $id
    ): array {

        $connection =
            $this->connection();


        $response =
            $this->client($connection)
                ->get(
                    $connection['url']
                    . '/api/v1/empresas/'
                    . $id
                );


        if ($response->status() === 404) {
            return [];
        }


        if ($response->failed()) {

            throw new RuntimeException(
                'No fue posible consultar la empresa en '
                . $connection['label']
                . '.'
            );
        }


        $json =
            $response->json();


        return is_array($json)
            ? $json
            : [];
    }
}