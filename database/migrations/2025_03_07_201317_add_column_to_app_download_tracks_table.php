<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_download_tracks', function (Blueprint $table) {
            $table->string('status')->default('complete')->after('ip_address');
            $table->timestamp('completed_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_download_tracks', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('completed_at');
        });
    }
};
