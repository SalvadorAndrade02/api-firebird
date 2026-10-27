<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PrivacyNoticeController;
use App\Http\Controllers\FirebirdClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FirebirdServerController;
use App\Http\Middleware\EnsureFirebirdServerSelected;


/*
|--------------------------------------------------------------------------
| SELECCIÓN DE SERVIDOR
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/seleccionar-servidor',
        [
            FirebirdServerController::class,
            'create',
        ]
    )->name('server.select');


    Route::post(
        '/seleccionar-servidor',
        [
            FirebirdServerController::class,
            'store',
        ]
    )->name('server.store');

});


/*
|--------------------------------------------------------------------------
| APLICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    EnsureFirebirdServerSelected::class,
])->group(function () {

    Route::get('/', function () {

        $server =
            session('firebird_server');

        $totalNotices =
            \App\Models\PrivacyNotice::where(
                'server',
                $server
            )->count();

        $signedNotices =
            \App\Models\PrivacyNotice::where(
                'server',
                $server
            )
                ->where(
                    'status',
                    'SIGNED'
                )
                ->count();


        $pendingNotices =
            \App\Models\PrivacyNotice::where(
                'server',
                $server
            )
                ->where(
                    'status',
                    'PENDING_MANUAL_SIGNATURE'
                )
                ->count();


        $digitalNotices =
            \App\Models\PrivacyNotice::where(
                'server',
                $server
            )
                ->where(
                    'signature_type',
                    'DIGITAL'
                )
                ->count();


        $recentNotices =
            \App\Models\PrivacyNotice::query()
                ->where(
                    'server',
                    $server
                )
                ->with('client')
                ->latest()
                ->limit(5)
                ->get();

        return view(
            'dashboard',
            compact(
                'totalNotices',
                'signedNotices',
                'pendingNotices',
                'digitalNotices',
                'recentNotices'
            )
        );

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/clientes',
        [ClientController::class, 'index']
    )->name('clients.index');

    Route::get(
        '/clientes/{codigo}',
        [ClientController::class, 'show']
    )->name('clients.show');


    /*
    |--------------------------------------------------------------------------
    | CONSULTA FIREBIRD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/clientes-firebird/buscar',
        [FirebirdClientController::class, 'search']
    )->name('clientes.firebird.search');


    /*
    |--------------------------------------------------------------------------
    | AVISOS DE PRIVACIDAD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/avisos/nuevo',
        [PrivacyNoticeController::class, 'create']
    )->name('privacy-notices.create');

    Route::post(
        '/avisos',
        [PrivacyNoticeController::class, 'store']
    )->name('privacy-notices.store');

    Route::get(
        '/avisos/{privacyNotice}',
        [PrivacyNoticeController::class, 'show']
    )->name('privacy-notices.show');

    Route::get(
        '/avisos/{privacyNotice}/pdf',
        [PrivacyNoticeController::class, 'pdf']
    )->name('privacy-notices.pdf');

    Route::delete(
        '/avisos/{privacyNotice}',
        [PrivacyNoticeController::class, 'destroy']
    )->name('privacy-notices.destroy');

    Route::post(
        '/avisos/{privacyNotice}/firmado',
        [PrivacyNoticeController::class, 'uploadSigned']
    )->name('privacy-notices.upload-signed');


    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | BÓVEDA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/boveda',
        [PrivacyNoticeController::class, 'vault']
    )->name('privacy-notices.vault');

});


/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN DE BREEZE
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';