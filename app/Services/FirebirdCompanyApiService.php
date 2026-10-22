<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebirdCompanyApiService
{
    private function client()
    {
        return Http::withHeaders([
            'X-API-KEY' => config('services.firebird_api.key'),
        ])
            ->acceptJson()
            ->timeout(15)
            ->connectTimeout(5);
    }

    public function list(): array
    {
        $response = $this->client()->get(
            config('services.firebird_api.url') . '/api/v1/empresas'
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'No fue posible consultar las empresas en Firebird.'
            );
        }

        return $response->json();
    }

    public function find(int $id): array
    {
        $response = $this->client()->get(
            config('services.firebird_api.url') . '/api/v1/empresas/' . $id
        );

        if ($response->status() === 404) {
            return [];
        }

        if ($response->failed()) {
            throw new RuntimeException(
                'No fue posible consultar la empresa en Firebird.'
            );
        }

        return $response->json();
    }
}