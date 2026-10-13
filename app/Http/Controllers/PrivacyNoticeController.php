<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\FirebirdClientApiService;
use App\Models\PrivacyNotice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PrivacyNoticeController extends Controller
{
    public function create(
        Request $request,
        FirebirdClientApiService $firebird
    ) {
        $client = null;

        $clientCode = trim(
            (string) $request->query('client_code', '')
        );

        if ($clientCode !== '') {

            /*
            |--------------------------------------------------------------------------
            | 1. CONSULTAR CLIENTE DIRECTAMENTE EN FIREBIRD
            |--------------------------------------------------------------------------
            */

            $response = $firebird->find($clientCode);

            $remote = $response['data'] ?? null;

            if (!$remote) {
                return redirect()
                    ->route('privacy-notices.create')
                    ->withErrors([
                        'client_code' =>
                            'No fue posible encontrar el cliente seleccionado.'
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 2. GUARDAR / ACTUALIZAR CLIENTE LOCAL
            |--------------------------------------------------------------------------
            |
            | No estamos sincronizando el catálogo.
            | Solo guardamos el cliente que realmente fue seleccionado.
            |
            */

            $client = Client::updateOrCreate(
                [
                    'codigo' => $remote['codigo'],
                ],
                [
                    'tipo_persona' =>
                        $remote['tipoPersona'] ?? null,

                    'nombre' =>
                        $remote['nombre'] ?? null,

                    'apellido1' =>
                        $remote['apellido1'] ?? null,

                    'apellido2' =>
                        $remote['apellido2'] ?? null,

                    'nombre_completo' =>
                        $remote['nombreCompleto']
                        ?? $remote['nombre']
                        ?? null,

                    'rfc' =>
                        $remote['fiscal']['rfc'] ?? null,

                    'numero_registro_tributario' =>
                        $remote['fiscal']['numeroRegistroTributario']
                        ?? null,

                    'regimen_fiscal' =>
                        $remote['fiscal']['regimenFiscal']
                        ?? null,

                    'calle' =>
                        $remote['direccion']['calle']
                        ?? null,

                    'numero' =>
                        $remote['direccion']['numero']
                        ?? null,

                    'codigo_postal' =>
                        $remote['direccion']['codigoPostal']
                        ?? null,

                    'colonia' =>
                        $remote['direccion']['colonia']
                        ?? null,

                    'municipio' =>
                        $remote['direccion']['municipio']
                        ?? null,

                    'estado' =>
                        $remote['direccion']['estado']
                        ?? null,

                    'pais' =>
                        $remote['direccion']['pais']
                        ?? null,

                    'telefono' =>
                        $remote['contacto']['telefono']
                        ?? null,

                    'movil' =>
                        $remote['contacto']['movil']
                        ?? null,

                    'email' =>
                        $remote['contacto']['email']
                        ?? null,

                    'synced_at' => now(),
                ]
            );
        }

        return view(
            'privacy-notices.create',
            compact('client')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'digital_signature' => [
                'nullable',
                'string',
            ],

            'signature_type' => [
                'required',
                'in:DIGITAL,MANUAL',
            ],
        ]);

        $client = Client::findOrFail(
            $validated['client_id']
        );

        $snapshot = [
            'codigo' => $client->codigo,
            'tipo_persona' => $client->tipo_persona,
            'nombre' => $client->nombre,
            'apellido1' => $client->apellido1,
            'apellido2' => $client->apellido2,
            'nombre_completo' => $client->nombre_completo,
            'rfc' => $client->rfc,
            'regimen_fiscal' => $client->regimen_fiscal,

            'direccion' => [
                'calle' => $client->calle,
                'numero' => $client->numero,
                'codigo_postal' => $client->codigo_postal,
                'colonia' => $client->colonia,
                'municipio' => $client->municipio,
                'estado' => $client->estado,
                'pais' => $client->pais,
            ],

            'contacto' => [
                'telefono' => $client->telefono,
                'movil' => $client->movil,
                'email' => $client->email,
            ],
        ];

        $notice = PrivacyNotice::create([
            'client_id' => $client->id,

            'status' => $validated['signature_type'] === 'DIGITAL'
                ? 'SIGNED'
                : 'PENDING_MANUAL_SIGNATURE',

            'client_snapshot' => $snapshot,

            'signature_type' => $validated['signature_type'],

            'digital_signature' =>
                $validated['digital_signature'] ?? null,

            'signed_at' =>
                $validated['signature_type'] === 'DIGITAL'
                ? now()
                : null,
        ]);

        $pdf = Pdf::loadView(
            'privacy-notices.pdf',
            [
                'notice' => $notice,
                'client' => $client,

                'digitalSignature' =>
                    $notice->digital_signature,

                'date' =>
                    now()->format('d/m/Y'),
            ]
        );

        $path = 'privacy-notices/'
            . $client->codigo
            . '/aviso-'
            . $notice->id
            . '.pdf';

        Storage::disk('local')->put(
            $path,
            $pdf->output()
        );

        $notice->update([
            'pdf_path' => $path,
        ]);

        return redirect()
            ->route('privacy-notices.show', $notice)
            ->with(
                'success',
                'Aviso generado correctamente'
            );
    }

    public function show(PrivacyNotice $privacyNotice)
    {
        $privacyNotice->load('client');

        return view('privacy-notices.show', [
            'notice' => $privacyNotice,
        ]);
    }

    public function pdf(
        Request $request,
        PrivacyNotice $privacyNotice
    ) {
        if (!$privacyNotice->pdf_path) {
            abort(404, 'El PDF no está disponible.');
        }

        if (!Storage::disk('local')->exists($privacyNotice->pdf_path)) {
            abort(404, 'El archivo PDF no existe.');
        }

        $filename =
            'aviso-privacidad-' .
            $privacyNotice->client->codigo .
            '.pdf';

        if ($request->boolean('download')) {
            return Storage::disk('local')->download(
                $privacyNotice->pdf_path,
                $filename
            );
        }

        return Storage::disk('local')->response(
            $privacyNotice->pdf_path,
            $filename
        );
    }

    public function uploadSigned(
        Request $request,
        PrivacyNotice $privacyNotice
    ) {
        $request->validate([
            'signed_pdf' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ]);

        $path = $request
            ->file('signed_pdf')
            ->store(
                'privacy-notices/' .
                $privacyNotice->client->codigo .
                '/signed',
                'local'
            );

        $privacyNotice->update([
            'signed_pdf_path' => $path,
            'status' => 'SIGNED',
            'signed_at' => now(),
        ]);

        return back()->with(
            'success',
            'Documento firmado cargado correctamente.'
        );
    }

    public function vault(Request $request)
    {
        $search = trim($request->get('search', ''));
        $status = $request->get('status');
        $signatureType = $request->get('signature_type');

        $notices = PrivacyNotice::query()
            ->with('client')

            ->when($search !== '', function ($query) use ($search) {

                $query->whereHas('client', function ($clientQuery) use ($search) {

                    $clientQuery->where(function ($q) use ($search) {

                        $q->where('codigo', 'like', "%{$search}%")
                            ->orWhere('nombre_completo', 'like', "%{$search}%")
                            ->orWhere('rfc', 'like', "%{$search}%");

                    });

                });

            })

            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            ->when($signatureType, function ($query) use ($signatureType) {
                $query->where('signature_type', $signatureType);
            })

            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('privacy-notices.vault', [
            'notices' => $notices,
            'search' => $search,
            'status' => $status,
            'signatureType' => $signatureType,
        ]);
    }
}