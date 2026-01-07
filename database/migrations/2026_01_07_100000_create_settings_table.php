<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('display_name');
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->timestamps();
        });

        $now = now();
        DB::table('settings')->insert([
            ['key' => 'site_title', 'display_name' => 'Site Title', 'value' => 'FraudShield', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_logo', 'display_name' => 'Logo', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_favicon', 'display_name' => 'Favicon', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'google_tag_manager', 'display_name' => 'Google Tag Manager ID', 'value' => 'GTM-5TNKX5N9', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'phone', 'display_name' => 'Phone', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'address', 'display_name' => 'Address', 'value' => 'ঢাকা, বাংলাদেশ', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'footer_text', 'display_name' => 'Footer Text', 'value' => '', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
