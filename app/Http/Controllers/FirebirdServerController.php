<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class FirebirdServerController extends Controller
{
    public function create()
    {
        return view(
            'server-select'
        );
    }


    public function store(
        Request $request
    ) {
        $validated =
            $request->validate([
                'server' => [
                    'required',

                    Rule::in([
                        'polaris',
                        'canam',
                    ]),
                ],
            ]);


        $server =
            $validated['server'];


        $config =
            config(
                "services.firebird_api.servers.{$server}"
            );


        if (
            !$config
            || empty($config['url'])
            || empty($config['key'])
        ) {

            return back()
                ->withErrors([
                    'server' =>
                        'La configuración del servidor seleccionado está incompleta.',
                ]);
        }


        /*
         * Antes de seleccionar la marca
         * comprobamos que su API responda.
         */
        try {

            $response =
                Http::acceptJson()
                    ->timeout(8)
                    ->connectTimeout(5)
                    ->get(
                        rtrim(
                            $config['url'],
                            '/'
                        )
                        . '/api/v1/health'
                    );


            if (
                $response->failed()
                || !(
                    $response->json(
                        'success'
                    )
                    ?? false
                )
            ) {

                return back()
                    ->withErrors([
                        'server' =>
                            'El servidor seleccionado no está disponible.',
                    ]);
            }

        } catch (\Throwable $e) {

            report($e);


            return back()
                ->withErrors([
                    'server' =>
                        'No fue posible conectar con el servidor seleccionado.',
                ]);
        }


        session([
            'firebird_server' =>
                $server,

            'firebird_server_label' =>
                $config['label'],
        ]);


        return redirect()
            ->route('dashboard');
    }
}