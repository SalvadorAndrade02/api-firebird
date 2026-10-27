<?php

namespace App\Services;

use RuntimeException;

class FirebirdApiConnectionResolver
{
    public function resolve(): array
    {
        $server = session(
            'firebird_server'
        );

        if (!$server) {
            throw new RuntimeException(
                'No se ha seleccionado un servidor Firebird.'
            );
        }

        $config = config(
            "services.firebird_api.servers.{$server}"
        );

        if (
            !is_array($config)
            || empty($config['url'])
            || empty($config['key'])
        ) {
            throw new RuntimeException(
                "La configuración de Firebird para {$server} está incompleta."
            );
        }

        return [
            'server' => $server,

            'label' =>
                $config['label']
                ?? ucfirst($server),

            'url' =>
                rtrim(
                    $config['url'],
                    '/'
                ),

            'key' =>
                $config['key'],
        ];
    }
}