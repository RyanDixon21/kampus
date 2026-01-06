<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\HeroCard;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use Illuminate\Support\Facades\DB;

class CurrentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder contains the current production data.
     * Run with: php artisan db:seed --class=CurrentDataSeeder
     */
    public function run(): void
    {
        // Disable foreign key checks (compatible with both MySQL and SQLite)
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        // Clear existing data
        Setting::truncate();
        HeroCard::truncate();
        News::truncate();
        Facility::truncate();
        Tendik::truncate();

        // Re-enable foreign key checks
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $this->seedSettings();
        $this->seedHeroCards();
        $this->seedNews();
        $this->seedFacilities();
        $this->seedTendik();

        $this->command->info('Current data seeded successfully!');
    }

    private function seedSettings(): void
    {
        $settings = [
            ['key' => 'university_name', 'value' => 'Sekolah Tinggi Teknologi Pratama Adi'],
            ['key' => 'logo', 'value' => 'settings/01KE6FMBD45PQGQTD801DSNMAQ.png'],
            ['key' => 'address', 'value' => 'Jl. Contoh No. 123, Jakarta, Indonesia'],
            ['key' => 'phone', 'value' => '021-12345678'],
            ['key' => 'email', 'value' => 'info@sttpratama.ac.id'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/sttpratama'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/sttpratama'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@sttpratama'],
            ['key' => 'wa_admin', 'value' => '628123456789'],
            ['key' => 'registration_fee', 'value' => '500000'],
            ['key' => 'cbt_duration', 'value' => '90'],
            ['key' => 'cbt_passing_score', 'value' => '60'],
            ['key' => 'university_short_name', 'value' => 'STT Pratama Adi'],
            ['key' => 'university_slogan', 'value' => 'Sekolah Tinggi Teknologi'],
            ['key' => 'footer_description', 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'],
            ['key' => 'news_section_title', 'value' => 'Berita Terkini'],
            ['key' => 'news_section_description', 'value' => 'Informasi Terkini Terkait Stt Pratama Adi'],
            ['key' => 'facilities_section_title', 'value' => 'Fasilitas'],
            ['key' => 'facilities_section_description', 'value' => 'Fasilitas lengkap untuk mendukung kegiatan belajar mengajar'],
            ['key' => 'campus_images', 'value' => '["settings\/campus\/01KE6KYF61MYMMB6Q09ZCABRDB.jpg","settings\/campus\/01KE6KYF6811SP935M9JHB2A0K.jpg"]'],
            ['key' => 'maps_embed', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63355.77893610908!2d107.4760081216797!3d-7.040259399999992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ed4edd87a133%3A0xf391ea548548c627!2sKampus%202%20STT%20Pratama%20Adi!5e0!3m2!1sen!2sid!4v1767601168260!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('✓ Settings seeded');
    }

    private function seedHeroCards(): void
    {
        HeroCard::create([
            'title' => 'Selamat Datang di Duniaku',
            'subtitle' => 'RAWWWWR',
            'description' => 'lorem ipsum dolor sit amet',
            'background_image' => 'hero-slides/01KE6FVV4F2TXGM5F6VYPJ1EEN.jpg',
            'button_text' => 'Daftar Sekarang',
            'button_link' => '/registration/create',
            'show_logo' => true,
            'order' => 0,
            'is_active' => true,
        ]);

        $this->command->info('✓ Hero cards seeded');
    }

    private function seedNews(): void
    {
        News::create([
            'title' => 'test berita',
            'slug' => 'test-berita',
            'content' => '<p>test</p>',
            'thumbnail' => 'news/thumbnails/01KE6HB7VDJDDSYNF8M5XS3VGG.jpg',
            'category' => 'Penelitian',
            'status' => 'published',
            'published_at' => '2026-01-05 07:35:11',
            'created_by' => null, // Set to null since user might not exist
            'images' => ['news/gallery/01KE6HB7VMBZ68T61STBRG3KAA.jpg'],
        ]);

        $this->command->info('✓ News seeded');
    }

    private function seedFacilities(): void
    {
        Facility::create([
            'name' => 'test fasilitas',
            'slug' => 'test-fasilitas',
            'description' => '<p>SIUUU</p>',
            'image' => 'facilities/thumbnails/01KE6HDQ1XG9HGYN28PF0JG5JC.png',
            'status' => 'published',
            'published_at' => '2026-01-05 07:36:54',
            'images' => ['facilities/gallery/01KE6HDQ271BEYR5YBQ2XWEH93.jpg'],
        ]);

        $this->command->info('✓ Facilities seeded');
    }

    private function seedTendik(): void
    {
        Tendik::create([
            'name' => 'tes',
            'nidn' => '123123123',
            'position' => 'Instruktur',
            'photo' => 'tendik/01KE6KP830AD6ETC27SZ1QD7PP.jpg',
            'email' => 'test@tendik.com',
            'phone' => '123123123',
            'is_active' => true,
        ]);

        $this->command->info('✓ Tendik seeded');
    }
}
