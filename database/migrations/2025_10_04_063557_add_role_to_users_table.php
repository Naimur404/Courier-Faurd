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
            // Only add columns if they don't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'api_user'])->default('api_user')->after('email');
            }
            if (!Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token')->nullable()->unique()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'monthly_request_limit')) {
                $table->integer('monthly_request_limit')->default(1000)->after('api_token');
            }
            if (!Schema::hasColumn('users', 'current_month_requests')) {
                $table->integer('current_month_requests')->default(0)->after('monthly_request_limit');
            }
            if (!Schema::hasColumn('users', 'last_request_reset')) {
                $table->timestamp('last_request_reset')->nullable()->after('current_month_requests');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'api_token')) {
                $table->dropColumn('api_token');
            }
            if (Schema::hasColumn('users', 'monthly_request_limit')) {
                $table->dropColumn('monthly_request_limit');
            }
            if (Schema::hasColumn('users', 'current_month_requests')) {
                $table->dropColumn('current_month_requests');
            }
            if (Schema::hasColumn('users', 'last_request_reset')) {
                $table->dropColumn('last_request_reset');
            }
        });
    }
};
