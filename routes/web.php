<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PrivacyNoticeController;
use App\Http\Controllers\FirebirdClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clientes', [ClientController::class, 'index'])
    ->name('clients.index');

Route::get('/clientes/{codigo}', [ClientController::class, 'show'])
    ->name('clients.show');

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

Route::post(
    '/avisos/{privacyNotice}/firmado',
    [PrivacyNoticeController::class, 'uploadSigned']
)->name('privacy-notices.upload-signed');

Route::get(
    '/boveda',
    [PrivacyNoticeController::class, 'vault']
)->name('privacy-notices.vault');

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get(
    '/clientes-firebird/buscar',
    [FirebirdClientController::class, 'search']
)->name('clientes.firebird.search');
