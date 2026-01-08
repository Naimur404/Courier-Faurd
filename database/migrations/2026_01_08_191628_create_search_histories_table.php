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
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone', 20)->index();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('search_by')->default('web'); // 'web', 'api', 'dashboard'
            $table->string('ip_address', 45)->nullable();
            $table->json('result_summary')->nullable(); // Store summary of results
            $table->timestamp('searched_at')->useCurrent();
            $table->timestamps();
            
            // Index for efficient querying
            $table->index(['user_id', 'searched_at']);
            $table->index(['user_id', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_histories');
    }
};
