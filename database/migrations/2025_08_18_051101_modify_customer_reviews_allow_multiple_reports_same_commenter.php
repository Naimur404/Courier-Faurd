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
            // Drop the existing composite unique constraint
            $table->dropUnique('unique_phone_commenter');
            
            // Add a new composite unique constraint that includes comment to allow multiple reports
            // from same commenter to same phone as long as the content is different
            $table->unique(['phone', 'commenter_phone', 'comment'], 'unique_phone_commenter_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_reviews', function (Blueprint $table) {
            // Drop the new constraint
            $table->dropUnique('unique_phone_commenter_comment');
            
            // Add back the old constraint
            $table->unique(['phone', 'commenter_phone'], 'unique_phone_commenter');
        });
    }
};
