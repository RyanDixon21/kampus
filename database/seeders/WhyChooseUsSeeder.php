<?php

namespace Database\Seeders;

use App\Models\WhyChooseUs;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Kurikulum Terakreditasi',
                'description' => 'Program studi terakreditasi dengan kurikulum yang selalu diperbarui mengikuti perkembangan industri',
                'icon' => 'book-open',
                'color' => 'blue',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Dosen Berpengalaman',
                'description' => 'Tenaga pengajar profesional dengan pengalaman akademis dan industri yang mumpuni',
                'icon' => 'briefcase',
                'color' => 'green',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Fasilitas Modern',
                'description' => 'Laboratorium lengkap, perpustakaan digital, dan ruang kelas dengan teknologi terkini',
                'icon' => 'building-library',
                'color' => 'purple',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            WhyChooseUs::create($item);
        }
    }
}
