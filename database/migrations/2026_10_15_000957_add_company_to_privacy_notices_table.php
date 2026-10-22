<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('privacy_notices', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')
                ->nullable()
                ->after('client_id')
                ->index();

            $table->longText('company_snapshot')
                ->nullable()
                ->after('client_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('privacy_notices', function (Blueprint $table) {
            $table->dropIndex(['company_id']);

            $table->dropColumn([
                'company_id',
                'company_snapshot',
            ]);
        });
    }
};