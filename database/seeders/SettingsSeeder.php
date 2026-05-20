<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'University Activities', 'type' => 'text',     'group' => 'general'],
            ['key' => 'site_description', 'value' => 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'academic_year',    'value' => '2569',                  'type' => 'text',     'group' => 'general'],

            // Appearance
            ['key' => 'primary_color',    'value' => '#6366F1',              'type' => 'color',    'group' => 'appearance'],
            ['key' => 'logo',             'value' => null,                    'type' => 'image',    'group' => 'appearance'],
            ['key' => 'favicon',          'value' => null,                    'type' => 'image',    'group' => 'appearance'],
            ['key' => 'hero_title',       'value' => 'จัดการกิจกรรมมหาวิทยาลัย ให้ง่ายยิ่งขึ้น', 'type' => 'text', 'group' => 'appearance'],
            ['key' => 'hero_subtitle',    'value' => 'ระบบครบวงจรสำหรับจัดการกิจกรรม อัปโหลดเอกสาร และติดตามข้อมูลอย่างมีประสิทธิภาพ', 'type' => 'textarea', 'group' => 'appearance'],

            // Contact
            ['key' => 'contact_email',    'value' => 'admin@example.com',     'type' => 'email',    'group' => 'contact'],
            ['key' => 'contact_phone',    'value' => '02-xxx-xxxx',           'type' => 'text',     'group' => 'contact'],
            ['key' => 'facebook_url',     'value' => null,                    'type' => 'text',     'group' => 'contact'],
            ['key' => 'line_url',         'value' => null,                    'type' => 'text',     'group' => 'contact'],
            ['key' => 'youtube_url',       'value' => null,                    'type' => 'text',     'group' => 'contact'],

            // Footer
            ['key' => 'footer_text',      'value' => '© 2569 University Activities. สงวนลิขสิทธิ์ทั้งหมด', 'type' => 'text', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
