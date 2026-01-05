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
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Token identifier/name
            $table->string('token'); // The actual token
            $table->boolean('is_active')->default(true); // Whether token can be used
            $table->timestamp('cooldown_until')->nullable(); // When cooldown expires (midnight BDT)
            $table->integer('usage_count')->default(0); // How many times used today
            $table->timestamp('last_used_at')->nullable(); // Last successful use
            $table->integer('priority')->default(0); // Lower = higher priority
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
