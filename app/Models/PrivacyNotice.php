<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyNotice extends Model
{
    protected $fillable = [
        'client_id',
        'status',
        'client_snapshot',
        'signature_type',
        'digital_signature',
        'pdf_path',
        'signed_at',
        'signed_pdf_path',
    ];

    protected $casts = [
        'client_snapshot' => 'array',
        'signed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}