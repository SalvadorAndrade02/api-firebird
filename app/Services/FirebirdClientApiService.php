<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebirdClientApiService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('services.firebird_api.url'),
            '/'
        );

        $this->apiKey = config(
            'services.firebird_api.key'
        );

        if (!$this->baseUrl || !$this->apiKey) {
            throw new RuntimeException(
                'La configuración de la API Firebird está incompleta.'
            );
        }
    }

    private function client()
    {
        return Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
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
        $response = $this->client()->get(
            "{$this->baseUrl}/api/v1/clientes",
            [
                'buscar' => $term,
                'page' => $page,
                'limit' => $limit,
            ]
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'No fue posible consultar clientes en Firebird.'
            );
        }

        return $response->json();
    }

    public function find(string $codigo, string $source = 'main'): array
    {
        $response = $this->client()->get(
            config('services.firebird_api.url')
            . '/api/v1/clientes/'
            . urlencode($codigo),
            [
                'source' => $source,
            ]
        );

        if ($response->failed()) {
            throw new \RuntimeException(
                'No se pudo consultar el cliente en Firebird.'
            );
        }

        $json = $response->json();

        if (
            !is_array($json)
            || !($json['success'] ?? false)
            || !isset($json['data'])
        ) {
            throw new \RuntimeException(
                'Respuesta inválida al consultar el cliente.'
            );
        }

        return $json['data'];
    }

    public function health(): array
    {
        $response = Http::acceptJson()
            ->timeout(10)
            ->get(
                "{$this->baseUrl}/api/v1/health"
            );

        if ($response->failed()) {
            throw new RuntimeException(
                'La API Firebird no está disponible.'
            );
        }

        return $response->json();
    }

    public function list(
        int $page = 1,
        int $limit = 25
    ): array {
        $response = $this->client()->get(
            config('services.firebird_api.url') . '/api/v1/clientes',
            [
                'page' => $page,
                'limit' => $limit,
            ]
        );

        if ($response->failed()) {
            throw new \RuntimeException(
                'Error consultando listado de clientes en Firebird.'
            );
        }

        return $response->json();
    }
}
