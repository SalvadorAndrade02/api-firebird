<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\FirebirdClientApiService;
use App\Models\PrivacyNotice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\FirebirdCompanyApiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PrivacyNoticeController extends Controller
{
    public function create(
        Request $request,
        FirebirdClientApiService $firebirdClients,
        FirebirdCompanyApiService $firebirdCompanies
    ) {
        $client = null;
        $clientKey = $request->query('client_key');
        $company = null;

        /*
        |--------------------------------------------------------------------------
        | EMPRESAS DISPONIBLES
        |--------------------------------------------------------------------------
        */

        try {
            $companyResponse = $firebirdCompanies->list();

            $companies = $companyResponse['data'] ?? [];
        } catch (\Throwable $e) {
            report($e);

            $companies = [];
        }


        /*
        |--------------------------------------------------------------------------
        | EMPRESA SELECCIONADA
        |--------------------------------------------------------------------------
        */

        $companyId = (int) $request->query(
            'company_id',
            0
        );

        if ($companyId > 0) {

            try {
                $response =
                    $firebirdCompanies->find(
                        $companyId
                    );

                $company =
                    $response['data'] ?? null;

            } catch (\Throwable $e) {
                report($e);

                return redirect()
                    ->route('privacy-notices.create')
                    ->withErrors([
                        'company_id' =>
                            'No fue posible consultar la empresa seleccionada.'
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CLIENTE SELECCIONADO
        |--------------------------------------------------------------------------
        */

        if ($clientKey) {
            [$source, $codigo] = array_pad(
                explode('|', $clientKey, 2),
                2,
                null
            );

            if (
                !$source ||
                !$codigo ||
                !in_array($source, ['main', 'oric'], true)
            ) {
                abort(400, 'Cliente seleccionado inválido.');
            }

            $remote = $firebirdClients->find(
                $codigo,
                $source
            );

            /*
            |--------------------------------------------------------------------------
            | CACHE LOCAL DEL CLIENTE
            |--------------------------------------------------------------------------
            */

            $client = Client::updateOrCreate(
                [
                    'source' => $source,
                    'codigo' => $codigo,
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
                        $remote['fiscal']['rfc']
                        ?? null,

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

        $submissionToken = (string) Str::uuid();

        return view(
            'privacy-notices.create',
            compact(
                'client',
                'clientKey',
                'company',
                'companies',
                'submissionToken'
            )
        );
    }

    public function store(
        Request $request,
        FirebirdCompanyApiService $firebirdCompanies
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN BÁSICA
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'submission_token' => [
                'required',
                'uuid',
            ],

            'client_id' => [
                'required',
                'integer',
                'exists:clients,id',
            ],

            'client_source' => [
                'required',
                'in:main,oric',
            ],

            'company_id' => [
                'required',
                'integer',
            ],

            'signature_type' => [
                'required',
                'in:DIGITAL,MANUAL',
            ],

            'digital_signature' => [
                'nullable',
                'string',
            ],
        ]);

        $existingNotice =
            PrivacyNotice::where(
                'submission_token',
                $validated['submission_token']
            )->first();

        if ($existingNotice) {

            return redirect()->route(
                'privacy-notices.show',
                [
                    'privacyNotice' =>
                        $existingNotice->getKey(),
                ]
            )->with(
                    'success',
                    'Este aviso ya había sido generado.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CLIENTE LOCAL
        |--------------------------------------------------------------------------
        */

        $client = Client::findOrFail(
            $validated['client_id']
        );


        /*
         * Protección adicional:
         * el origen recibido debe coincidir con
         * el cliente que tenemos almacenado.
         */
        if (
            $client->source !==
            $validated['client_source']
        ) {
            abort(
                422,
                'El origen del cliente no coincide.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN DE FIRMA
        |--------------------------------------------------------------------------
        */

        if (
            $validated['signature_type'] === 'DIGITAL'
        ) {

            if (
                empty($validated['digital_signature'])
            ) {
                throw ValidationException::withMessages([
                    'digital_signature' =>
                        'Debes confirmar la firma digital antes de generar el aviso.',
                ]);
            }


            /*
             * La firma debe venir realmente como
             * una imagen PNG generada por el canvas.
             */
            if (
                !str_starts_with(
                    $validated['digital_signature'],
                    'data:image/png;base64,'
                )
            ) {
                throw ValidationException::withMessages([
                    'digital_signature' =>
                        'La firma digital recibida no tiene un formato válido.',
                ]);
            }

        } else {

            /*
             * Firma manual:
             * nunca almacenamos una firma digital residual.
             */
            $validated['digital_signature'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPRESA
        |--------------------------------------------------------------------------
        |
        | Consultamos Firebird ANTES de abrir la transacción.
        | No tiene sentido mantener MySQL bloqueado mientras esperamos
        | una llamada HTTP externa.
        |--------------------------------------------------------------------------
        */

        try {

            $companyResponse =
                $firebirdCompanies->find(
                    (int) $validated['company_id']
                );

            $company =
                $companyResponse['data']
                ?? null;

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput(
                    $request->except(
                        'digital_signature'
                    )
                )
                ->withErrors([
                    'company_id' =>
                        'No fue posible consultar la empresa seleccionada.',
                ]);
        }


        if (!$company) {

            return back()
                ->withInput(
                    $request->except(
                        'digital_signature'
                    )
                )
                ->withErrors([
                    'company_id' =>
                        'No fue posible consultar la empresa seleccionada.',
                ]);
        }


        /*
         * No generar documentos con información
         * fiscal incompleta.
         */
        if (
            !(
                $company['datosFiscalesDisponibles']
                ?? false
            )
        ) {

            return back()
                ->withInput(
                    $request->except(
                        'digital_signature'
                    )
                )
                ->withErrors([
                    'company_id' =>
                        'La empresa seleccionada no cuenta con datos fiscales completos para generar el aviso.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SNAPSHOT DEL CLIENTE
        |--------------------------------------------------------------------------
        */

        $snapshot = [

            'source' =>
                $client->source
                ?? 'main',

            'source_label' =>
                ($client->source ?? 'main') === 'oric'
                ? 'MMW32_ORIC'
                : 'MMW32',

            'codigo' =>
                $client->codigo,

            'tipo_persona' =>
                $client->tipo_persona,

            'nombre' =>
                $client->nombre,

            'apellido1' =>
                $client->apellido1,

            'apellido2' =>
                $client->apellido2,

            'nombre_completo' =>
                $client->nombre_completo,

            'rfc' =>
                $client->rfc,

            'regimen_fiscal' =>
                $client->regimen_fiscal,


            'direccion' => [

                'calle' =>
                    $client->calle,

                'numero' =>
                    $client->numero,

                'codigo_postal' =>
                    $client->codigo_postal,

                'colonia' =>
                    $client->colonia,

                'municipio' =>
                    $client->municipio,

                'estado' =>
                    $client->estado,

                'pais' =>
                    $client->pais,
            ],


            'contacto' => [

                'telefono' =>
                    $client->telefono,

                'movil' =>
                    $client->movil,

                'email' =>
                    $client->email,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | SNAPSHOT DE EMPRESA
        |--------------------------------------------------------------------------
        */

        $companySnapshot = [

            'id' =>
                $company['id']
                ?? null,

            'nombre' =>
                $company['nombre']
                ?? null,

            'rfc' =>
                $company['rfc']
                ?? null,

            'telefono' =>
                $company['telefono']
                ?? null,

            'codigo' =>
                $company['codigo']
                ?? null,

            'email' =>
                $company['email']
                ?? null,


            'direccion' => [

                'calle' =>
                    $company['direccion']['calle']
                    ?? null,

                'numero' =>
                    $company['direccion']['numero']
                    ?? null,

                'colonia' =>
                    $company['direccion']['colonia']
                    ?? null,

                'municipio' =>
                    $company['direccion']['municipio']
                    ?? null,

                'estado' =>
                    $company['direccion']['estado']
                    ?? null,

                'pais' =>
                    $company['direccion']['pais']
                    ?? null,

                'codigoPostal' =>
                    $company['direccion']['codigoPostal']
                    ?? null,
            ],


            'fiscal' => [

                'nombre' =>
                    $company['fiscal']['nombre']
                    ?? null,

                'rfc' =>
                    $company['fiscal']['rfc']
                    ?? $company['rfc']
                    ?? null,

                'fechaFuente' =>
                    $company['fiscal']['fechaFuente']
                    ?? null,

                'fuente' =>
                    $company['fiscal']['fuente']
                    ?? null,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | DATOS PARA EL PDF
        |--------------------------------------------------------------------------
        */

        $pdfClient = (object) [

            'codigo' =>
                $snapshot['codigo']
                ?? null,

            'tipo_persona' =>
                $snapshot['tipo_persona']
                ?? null,

            'nombre' =>
                $snapshot['nombre']
                ?? null,

            'apellido1' =>
                $snapshot['apellido1']
                ?? null,

            'apellido2' =>
                $snapshot['apellido2']
                ?? null,

            'nombre_completo' =>
                $snapshot['nombre_completo']
                ?? null,

            'rfc' =>
                $snapshot['rfc']
                ?? null,

            'regimen_fiscal' =>
                $snapshot['regimen_fiscal']
                ?? null,

            'calle' =>
                $snapshot['direccion']['calle']
                ?? null,

            'numero' =>
                $snapshot['direccion']['numero']
                ?? null,

            'codigo_postal' =>
                $snapshot['direccion']['codigo_postal']
                ?? null,

            'colonia' =>
                $snapshot['direccion']['colonia']
                ?? null,

            'municipio' =>
                $snapshot['direccion']['municipio']
                ?? null,

            'estado' =>
                $snapshot['direccion']['estado']
                ?? null,

            'pais' =>
                $snapshot['direccion']['pais']
                ?? null,

            'telefono' =>
                $snapshot['contacto']['telefono']
                ?? null,

            'movil' =>
                $snapshot['contacto']['movil']
                ?? null,

            'email' =>
                $snapshot['contacto']['email']
                ?? null,
        ];


        /*
        |--------------------------------------------------------------------------
        | TRANSACCIÓN
        |--------------------------------------------------------------------------
        */

        $path = null;

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CREAR AVISO
            |--------------------------------------------------------------------------
            */

            $notice = PrivacyNotice::create([

                'submission_token' =>
                    $validated['submission_token'],

                'client_id' =>
                    $client->id,

                'company_id' =>
                    $company['id'],

                'client_snapshot' =>
                    $snapshot,

                'company_snapshot' =>
                    $companySnapshot,

                'signature_type' =>
                    $validated['signature_type'],

                'digital_signature' =>
                    $validated['digital_signature'],

                'status' =>
                    $validated['signature_type']
                    === 'DIGITAL'
                    ? 'SIGNED'
                    : 'PENDING_MANUAL_SIGNATURE',

                'signed_at' =>
                    $validated['signature_type']
                    === 'DIGITAL'
                    ? now()
                    : null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | GENERAR PDF
            |--------------------------------------------------------------------------
            */

            $pdf = Pdf::loadView(
                'privacy-notices.pdf',
                [
                    'notice' =>
                        $notice,

                    'client' =>
                        $pdfClient,

                    'company' =>
                        $companySnapshot,

                    'digitalSignature' =>
                        $validated['digital_signature'],

                    'date' =>
                        $notice
                            ->created_at
                            ->format('d/m/Y'),
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | RUTA DEL PDF
            |--------------------------------------------------------------------------
            */

            $path =
                'privacy-notices/'
                . ($client->source ?? 'main')
                . '/'
                . $client->codigo
                . '/aviso-'
                . $notice->id
                . '.pdf';


            /*
            |--------------------------------------------------------------------------
            | GUARDAR PDF
            |--------------------------------------------------------------------------
            */

            $stored =
                Storage::disk('local')
                    ->put(
                        $path,
                        $pdf->output()
                    );


            if (!$stored) {

                throw new \RuntimeException(
                    'No fue posible almacenar el archivo PDF.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR AVISO
            |--------------------------------------------------------------------------
            */

            $notice->update([
                'pdf_path' => $path,
            ]);


            /*
            |--------------------------------------------------------------------------
            | CONFIRMAR TODO
            |--------------------------------------------------------------------------
            */

            DB::commit();


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK MYSQL
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | ELIMINAR PDF PARCIAL
            |--------------------------------------------------------------------------
            |
            | La transacción SQL no puede revertir archivos,
            | por eso lo eliminamos manualmente.
            |--------------------------------------------------------------------------
            */

            if (
                $path &&
                Storage::disk('local')->exists(
                    $path
                )
            ) {

                Storage::disk('local')
                    ->delete(
                        $path
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | LOG
            |--------------------------------------------------------------------------
            */

            report($e);


            /*
            |--------------------------------------------------------------------------
            | RESPUESTA
            |--------------------------------------------------------------------------
            */

            return back()
                ->withInput(
                    $request->except(
                        'digital_signature'
                    )
                )
                ->withErrors([
                    'generation' =>
                        'No fue posible generar el aviso de privacidad. No se realizó ningún cambio.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT POST/REDIRECT/GET
        |--------------------------------------------------------------------------
        */

        return redirect()->to(
            route(
                'privacy-notices.show',
                [
                    'privacyNotice' =>
                        $notice->getKey(),
                ]
            ),
            303
        )->with(
                'success',
                'Aviso generado correctamente.'
            );
    }

    public function show(PrivacyNotice $privacyNotice)
    {
        $privacyNotice->load('client');

        $clientSnapshot =
            $privacyNotice->client_snapshot ?? [];

        $companySnapshot =
            $privacyNotice->company_snapshot ?? [];

        return view('privacy-notices.show', [
            'notice' => $privacyNotice,
            'clientSnapshot' => $clientSnapshot,
            'companySnapshot' => $companySnapshot,
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

        $snapshot = $privacyNotice->client_snapshot ?? [];

        $clientCode =
            $snapshot['codigo']
            ?? $privacyNotice->client?->codigo
            ?? 'cliente';

        $filename =
            'aviso-privacidad-'
            . $clientCode
            . '.pdf';

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

        $snapshot = $privacyNotice->client_snapshot ?? [];

        $clientCode =
            $snapshot['codigo']
            ?? $privacyNotice->client?->codigo
            ?? 'cliente';

        $clientSource =
            $snapshot['source']
            ?? 'main';

        $path = $request
            ->file('signed_pdf')
            ->store(
                'privacy-notices/'
                . $clientSource
                . '/'
                . $clientCode
                . '/signed',
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

    public function destroy(
        PrivacyNotice $privacyNotice
    ) {
        $paths = array_filter([
            $privacyNotice->pdf_path,
            $privacyNotice->signed_pdf_path,
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | ELIMINAR ARCHIVOS
            |--------------------------------------------------------------------------
            */

            foreach ($paths as $path) {

                if (
                    Storage::disk('local')
                        ->exists($path)
                ) {

                    $deleted =
                        Storage::disk('local')
                            ->delete($path);

                    if (!$deleted) {
                        throw new \RuntimeException(
                            "No fue posible eliminar el archivo: {$path}"
                        );
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ELIMINAR REGISTRO
            |--------------------------------------------------------------------------
            */

            $noticeId =
                $privacyNotice->id;

            $privacyNotice->delete();


            DB::commit();


            return redirect()
                ->route(
                    'privacy-notices.vault'
                )
                ->with(
                    'success',
                    "Aviso #{$noticeId} eliminado correctamente."
                );


        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return back()->with(
                'error',
                'No fue posible eliminar el aviso.'
            );
        }
    }

    public function vault(
        Request $request,
        FirebirdCompanyApiService $firebirdCompanies
    ) {
        $search = trim($request->get('search', ''));
        $status = $request->get('status');
        $signatureType = $request->get('signature_type');
        $companyId = $request->get('company_id');

        $notices = PrivacyNotice::query()
            ->with('client')

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    $q->whereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where(function ($client) use ($search) {
                            $client
                                ->where('codigo', 'like', "%{$search}%")
                                ->orWhere('nombre_completo', 'like', "%{$search}%")
                                ->orWhere('rfc', 'like', "%{$search}%");
                        });
                    })

                        ->orWhere(
                            'client_snapshot',
                            'like',
                            "%{$search}%"
                        );
                });
            })

            ->when($companyId, function ($query) use ($companyId) {
                $query->where(
                    'company_id',
                    $companyId
                );
            })

            ->when($status, function ($query) use ($status) {
                $query->where(
                    'status',
                    $status
                );
            })

            ->when($signatureType, function ($query) use ($signatureType) {
                $query->where(
                    'signature_type',
                    $signatureType
                );
            })

            ->latest()
            ->paginate(15)
            ->withQueryString();


        try {
            $companyResponse =
                $firebirdCompanies->list();

            $companies = collect(
                $companyResponse['data'] ?? []
            )
                ->map(function (array $company) {
                    return [
                        'id' => $company['id'],
                        'nombre' => $company['nombre'],
                        'rfc' => $company['rfc'] ?? null,
                    ];
                })
                ->sortBy('nombre')
                ->values();

        } catch (\Throwable $e) {

            report($e);

            $companies = collect();
        }


        return view(
            'privacy-notices.vault',
            [
                'notices' => $notices,
                'companies' => $companies,
                'search' => $search,
                'status' => $status,
                'signatureType' => $signatureType,
                'companyId' => $companyId,
            ]
        );
    }
}