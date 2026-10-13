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
        Schema::table('privacy_notices', function (Blueprint $table) {
            $table
                ->string('signed_pdf_path')
                ->nullable()
                ->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('privacy_notices', function (Blueprint $table) {
            $table->dropColumn('signed_pdf_path');
        });
    }

};
