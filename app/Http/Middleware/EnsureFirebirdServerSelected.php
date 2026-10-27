<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFirebirdServerSelected
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (
            !session()->has(
                'firebird_server'
            )
        ) {

            return redirect()
                ->route(
                    'server.select'
                );
        }


        return $next(
            $request
        );
    }
}