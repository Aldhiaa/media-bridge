<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'platform_name', 'value' => 'Media Bridge', 'type' => 'string'],
            ['group' => 'general', 'key' => 'support_email', 'value' => 'support@mediabridge.sa', 'type' => 'string'],
            ['group' => 'general', 'key' => 'default_currency', 'value' => 'SAR', 'type' => 'string'],
            ['group' => 'general', 'key' => 'contact_phone', 'value' => '+966500000000', 'type' => 'string'],
            ['group' => 'general', 'key' => 'contact_address', 'value' => 'الرياض، المملكة العربية السعودية', 'type' => 'string'],
            ['group' => 'notifications', 'key' => 'email_notifications', 'value' => '0', 'type' => 'boolean'],
            ['group' => 'moderation', 'key' => 'auto_approve_reviews', 'value' => '0', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
