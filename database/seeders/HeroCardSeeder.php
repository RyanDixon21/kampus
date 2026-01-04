<?php

namespace Database\Seeders;

use App\Models\HeroCard;
use Illuminate\Database\Seeder;

class HeroCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroCards = [
            [
                'title' => 'Selamat Datang di',
                'subtitle' => 'Sekolah Tinggi Teknologi Pratama Adi',
                'description' => 'Sekolah Tinggi Teknologi Terdepan untuk Masa Depan Anda',
                'background_image' => null, // Will be uploaded via Filament
                'button_text' => 'Daftar Sekarang',
                'button_link' => '/registration',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Raih Masa Depan Cerah',
                'subtitle' => 'Bersama STT Pratama Adi',
                'description' => 'Program Studi Berkualitas dengan Fasilitas Modern dan Dosen Profesional',
                'background_image' => null,
                'button_text' => 'Lihat Program Studi',
                'button_link' => '#',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pendaftaran Dibuka',
                'subtitle' => 'Tahun Akademik 2026/2027',
                'description' => 'Daftar sekarang dan dapatkan kesempatan beasiswa untuk mahasiswa berprestasi',
                'background_image' => null,
                'button_text' => 'Info Pendaftaran',
                'button_link' => '/registration',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($heroCards as $card) {
            HeroCard::create($card);
        }

        $this->command->info('Hero cards seeded successfully!');
        $this->command->info('Please upload background images via Filament admin panel.');
    }
}
