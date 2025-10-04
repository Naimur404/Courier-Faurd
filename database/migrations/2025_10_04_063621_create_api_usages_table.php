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
        Schema::create('api_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('api_key_id')->nullable()->constrained()->onDelete('set null');
            $table->string('endpoint'); // API endpoint called
            $table->string('method'); // HTTP method
            $table->json('request_data')->nullable(); // Request payload
            $table->json('response_data')->nullable(); // Response data
            $table->integer('response_code'); // HTTP response code
            $table->float('response_time')->nullable(); // Response time in ms
            $table->ipAddress('ip_address');
            $table->text('user_agent')->nullable();
            $table->timestamp('requested_at');
            $table->timestamps();
            
            $table->index(['user_id', 'requested_at']);
            $table->index(['endpoint', 'requested_at']);
            $table->index('api_key_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_usages');
    }
};
