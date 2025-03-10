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
        Schema::create('download_trackers', function (Blueprint $table) {
            $table->id();
            $table->uuid('track_id')->unique();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('format')->default('csv');
            $table->string('status')->default('intent');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_trackers');
    }
};
