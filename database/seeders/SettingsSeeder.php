<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identitas Kampus
            'university_name' => 'Sekolah Tinggi Teknologi Pratama Adi',
            'logo' => 'logo.png', // Placeholder - admin should upload actual logo
            'address' => 'Jl. Contoh No. 123, Jakarta, Indonesia',
            'phone' => '021-12345678',
            'email' => 'info@sttpratama.ac.id',
            
            // Social Media
            'facebook_url' => 'https://facebook.com/sttpratama',
            'instagram_url' => 'https://instagram.com/sttpratama',
            'youtube_url' => 'https://youtube.com/@sttpratama',
            
            // WhatsApp Admin
            'wa_admin' => '628123456789',
            
            // Additional Settings
            'registration_fee' => '500000',
            'cbt_duration' => '90', // minutes
            'cbt_passing_score' => '60',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('Settings seeded successfully!');
        $this->command->warn('Please update the logo, contact information, and WhatsApp admin number in the admin panel.');
    }
}
