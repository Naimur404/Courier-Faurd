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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('search_by')->default('web')->after('phone');
            $table->string('ip_address')->nullable()->after('search_by');
            $table->timestamp('last_searched_at')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('search_by');
            $table->dropColumn('ip_address');
            $table->dropColumn('last_searched_at');
        });
    }
};
