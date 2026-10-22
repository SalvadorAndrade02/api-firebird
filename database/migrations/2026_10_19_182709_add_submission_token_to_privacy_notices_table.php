<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table(
            'privacy_notices',
            function (Blueprint $table) {

                $table
                    ->uuid('submission_token')
                    ->nullable()
                    ->unique()
                    ->after('client_id');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'privacy_notices',
            function (Blueprint $table) {

                $table->dropUnique(
                    'privacy_notices_submission_token_unique'
                );

                $table->dropColumn(
                    'submission_token'
                );
            }
        );
    }
};