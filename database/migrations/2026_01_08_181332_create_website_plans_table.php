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
        Schema::create('website_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name (e.g., "Daily", "Weekly")
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Price in BDT
            $table->integer('duration_days'); // How many days the plan lasts
            $table->string('icon')->nullable(); // Icon name (lucide icon)
            $table->string('color')->default('indigo'); // Theme color
            $table->json('features')->nullable(); // List of features
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_plans');
    }
};
