<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 8)->unique();

            $table->string('tipo_persona', 20)->nullable();

            $table->string('nombre')->nullable();
            $table->string('apellido1')->nullable();
            $table->string('apellido2')->nullable();
            $table->string('nombre_completo')->nullable();

            $table->string('rfc', 20)->nullable();
            $table->string('numero_registro_tributario')->nullable();
            $table->string('regimen_fiscal', 20)->nullable();

            $table->string('calle')->nullable();
            $table->string('numero')->nullable();
            $table->string('codigo_postal', 15)->nullable();
            $table->string('colonia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();

            $table->string('telefono', 50)->nullable();
            $table->string('movil', 50)->nullable();
            $table->string('email')->nullable();

            $table->timestamp('synced_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
