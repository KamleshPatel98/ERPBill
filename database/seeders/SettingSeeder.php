<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key_name' => 'app_name',
                'value' => 'Krishi Dawai ERP',
            ],
            [
                'key_name' => 'app_email',
                'value' => 'admin@gmail.com',
            ],
            [
                'key_name' => 'app_phone',
                'value' => '1234567891',
            ],
            [
                'key_name' => 'app_alt_phone',
                'value' => '1234567892',
            ],
            [
                'key_name' => 'app_address',
                'value' => 'Raipur, Chhattisgarh, India - 492001',
            ],
            [
                'key_name' => 'app_footer_text',
                'value' => '© 2026 Krishi Dawai ERPerved.',
            ],
            [
                'key_name' => 'page_limit',
                'value' => '3',
            ],
            [
                'key_name' => 'web_version',
                'value' => '1.0',
            ],
            [
                'key_name' => 'app_url',
                'value' => 'https://tifin.mywaydigitalsolutions.com',
            ],
        ];

        foreach ($data as $row) {
            Setting::firstOrCreate(
                ['key_name' => $row['key_name']],
                ['value' => $row['value']]
            );
        }
    }
}
