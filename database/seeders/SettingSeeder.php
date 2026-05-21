<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'brand_name' => 'My Company',
                'default_gst_percent' => 18,
            ]
        );
    }
}