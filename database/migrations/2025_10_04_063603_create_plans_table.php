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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Monthly, Half Yearly, Yearly
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('duration_months'); // 1, 6, 12
            $table->integer('request_limit'); // Monthly request limit
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // JSON array of features
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
        Schema::dropIfExists('plans');
    }
};
