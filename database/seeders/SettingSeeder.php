<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $year = date('Y');
        
        $settings = [
            ['key' => 'site_title', 'display_name' => 'Site Title', 'value' => 'FraudShield', 'type' => 'text'],
            ['key' => 'site_logo', 'display_name' => 'Logo', 'value' => '', 'type' => 'text'],
            ['key' => 'site_favicon', 'display_name' => 'Favicon', 'value' => '', 'type' => 'text'],
            ['key' => 'google_tag_manager', 'display_name' => 'Google Tag Manager ID', 'value' => 'GTM-5TNKX5N9', 'type' => 'text'],
            ['key' => 'phone', 'display_name' => 'Phone', 'value' => '01309092748', 'type' => 'text'],
            ['key' => 'whatsapp', 'display_name' => 'WhatsApp Number', 'value' => '01309092748', 'type' => 'text'],
            ['key' => 'address', 'display_name' => 'Address', 'value' => 'ঢাকা, বাংলাদেশ', 'type' => 'textarea'],
            ['key' => 'footer_text', 'display_name' => 'Footer Text', 'value' => "© {$year} FraudShield. All rights reserved.", 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
