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
        Schema::table('customer_reviews', function (Blueprint $table) {
            // Drop the unique constraint on commenter_phone
            $table->dropUnique(['commenter_phone']);
            
            // Add a composite unique constraint for phone and commenter_phone combination
            $table->unique(['phone', 'commenter_phone'], 'unique_phone_commenter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_reviews', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('unique_phone_commenter');
            
            // Add back the unique constraint on commenter_phone
            $table->unique('commenter_phone');
        });
    }
};
