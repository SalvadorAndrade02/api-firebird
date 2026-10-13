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
        Schema::create('privacy_notices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status', 30)->default('GENERATED');

            $table->longText('client_snapshot');

            $table->string('signature_type', 20)->nullable();

            $table->longText('digital_signature')->nullable();

            $table->string('pdf_path')->nullable();

            $table->timestamp('signed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy_notices');
    }
};
