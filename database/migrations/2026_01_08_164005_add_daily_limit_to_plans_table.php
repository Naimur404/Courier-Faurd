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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('daily_limit')->nullable()->after('request_limit');
            $table->string('billing_period')->default('monthly')->after('duration_months'); // monthly, yearly
            $table->decimal('monthly_price', 10, 2)->nullable()->after('price');
            $table->decimal('yearly_price', 10, 2)->nullable()->after('monthly_price');
            $table->boolean('is_popular')->default(false)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['daily_limit', 'billing_period', 'monthly_price', 'yearly_price', 'is_popular']);
        });
    }
};
