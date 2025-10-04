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
        Schema::table('users', function (Blueprint $table) {
            // $table->enum('role', ['admin', 'api_user'])->default('api_user')->after('email');
            // $table->string('api_token')->nullable()->unique()->after('remember_token');
            $table->integer('monthly_request_limit')->default(1000)->after('api_token');
            $table->integer('current_month_requests')->default(0)->after('monthly_request_limit');
            $table->timestamp('last_request_reset')->nullable()->after('current_month_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'api_token', 
                'monthly_request_limit', 
                'current_month_requests', 
                'last_request_reset'
            ]);
        });
    }
};
