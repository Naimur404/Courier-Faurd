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
            $table->unsignedBigInteger('user_id')->nullable()->after('phone');
            $table->string('subscription_type')->nullable()->after('user_id'); // 'api', 'website', or null
            $table->unsignedBigInteger('subscription_id')->nullable()->after('subscription_type');
            
            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Add indexes for better performance
            $table->index(['user_id', 'subscription_type']);
            $table->index(['subscription_type', 'subscription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'subscription_type']);
            $table->dropIndex(['subscription_type', 'subscription_id']);
            $table->dropColumn(['user_id', 'subscription_type', 'subscription_id']);
        });
    }
};
