<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'codigo',
        'source',
        'tipo_persona',

        'nombre',
        'apellido1',
        'apellido2',
        'nombre_completo',

        'rfc',
        'numero_registro_tributario',
        'regimen_fiscal',

        'calle',
        'numero',
        'codigo_postal',
        'colonia',
        'municipio',
        'estado',
        'pais',
        

        'telefono',
        'movil',
        'email',

        'synced_at',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
    ];

    public function privacyNotices()
    {
        return $this->hasMany(PrivacyNotice::class);
    }
}