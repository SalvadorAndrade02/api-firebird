<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {

            // Quitar UNIQUE antiguo de codigo
            $table->dropUnique('clients_codigo_unique');

            // Ahora la combinación source + codigo es única
            $table->unique(
                ['source', 'codigo'],
                'clients_source_codigo_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {

            $table->dropUnique(
                'clients_source_codigo_unique'
            );

            $table->unique(
                'codigo',
                'clients_codigo_unique'
            );
        });
    }
};