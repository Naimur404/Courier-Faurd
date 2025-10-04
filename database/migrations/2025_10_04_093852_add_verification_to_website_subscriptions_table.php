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
        Schema::table('website_subscriptions', function (Blueprint $table) {
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('status');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->text('admin_notes')->nullable()->after('verified_by');
            
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['verification_status', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropIndex(['verification_status', 'status']);
            $table->dropColumn(['verification_status', 'verified_at', 'verified_by', 'admin_notes']);
        });
    }
};
