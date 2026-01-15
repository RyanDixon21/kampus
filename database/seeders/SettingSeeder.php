<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'university_name' => 'Sekolah Tinggi Teknologi Pratama Adi',
            'university_short_name' => 'STT Pratama Adi',
            'university_address' => 'Jl. Contoh No. 123, Jakarta',
            'university_phone' => '021-12345678',
            'university_email' => 'info@sttpratama.ac.id',
            'university_website' => 'https://sttpratama.ac.id',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('Settings seeded successfully!');
    }
}
