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
        Schema::create('web_subscription_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address', 45);
            $table->string('endpoint')->default('/courier-check');
            $table->date('usage_date');
            $table->integer('hit_count')->default(0);
            $table->timestamp('last_hit_at')->nullable();
            $table->timestamps();
            
            // Unique constraint to ensure one record per user per day
            $table->unique(['user_id', 'usage_date']);
            $table->index(['user_id', 'usage_date']);
            $table->index(['usage_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_subscription_usages');
    }
};
