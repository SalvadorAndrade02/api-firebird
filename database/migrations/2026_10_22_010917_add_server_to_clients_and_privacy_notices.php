<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CLIENTS
        |--------------------------------------------------------------------------
        */

        Schema::table('clients', function (Blueprint $table) {

            $table
                ->string('server', 20)
                ->default('polaris')
                ->after('id');
        });


        /*
         * Todos los registros existentes pertenecen al flujo histórico
         * de Polaris.
         */
        DB::table('clients')
            ->whereNull('server')
            ->orWhere('server', '')
            ->update([
                'server' => 'polaris',
            ]);


        Schema::table('clients', function (Blueprint $table) {

            /*
             * Quitamos UNIQUE anterior:
             *
             * source + codigo
             */
            $table->dropUnique(
                'clients_source_codigo_unique'
            );


            /*
             * Nueva identidad:
             *
             * server + source + codigo
             */
            $table->unique(
                [
                    'server',
                    'source',
                    'codigo',
                ],
                'clients_server_source_codigo_unique'
            );


            $table->index(
                'server'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | PRIVACY NOTICES
        |--------------------------------------------------------------------------
        */

        Schema::table('privacy_notices', function (Blueprint $table) {

            $table
                ->string('server', 20)
                ->default('polaris')
                ->after('id');

            $table->index(
                'server'
            );
        });


        /*
         * Los avisos que ya existen son Polaris.
         */
        DB::table('privacy_notices')
            ->whereNull('server')
            ->orWhere('server', '')
            ->update([
                'server' => 'polaris',
            ]);
    }


    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PRIVACY NOTICES
        |--------------------------------------------------------------------------
        */

        Schema::table('privacy_notices', function (Blueprint $table) {

            $table->dropIndex([
                'server',
            ]);

            $table->dropColumn(
                'server'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | CLIENTS
        |--------------------------------------------------------------------------
        */

        Schema::table('clients', function (Blueprint $table) {

            $table->dropUnique(
                'clients_server_source_codigo_unique'
            );

            $table->dropIndex([
                'server',
            ]);


            /*
             * Restauramos comportamiento anterior.
             */
            $table->unique(
                [
                    'source',
                    'codigo',
                ],
                'clients_source_codigo_unique'
            );


            $table->dropColumn(
                'server'
            );
        });
    }
};