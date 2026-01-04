<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for news author
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder first.');
            return;
        }

        // Seed sample news
        $this->seedNews($admin->id);
        
        // Seed sample facilities
        $this->seedFacilities();
        
        // Seed sample tendik
        $this->seedTendik();

        $this->command->info('Sample data seeded successfully!');
    }

    /**
     * Seed sample news articles
     */
    private function seedNews(int $adminId): void
    {
        $newsData = [
            [
                'title' => 'Penerimaan Mahasiswa Baru Tahun Akademik 2026/2027',
                'content' => '<p>STT Pratama Adi membuka pendaftaran mahasiswa baru untuk tahun akademik 2026/2027. Pendaftaran dibuka mulai tanggal 1 Januari 2026 hingga 31 Maret 2026.</p><p>Program studi yang tersedia: Teknik Informatika, Sistem Informasi, dan Teknik Komputer.</p><p>Untuk informasi lebih lanjut, silakan hubungi kami atau kunjungi halaman pendaftaran.</p>',
                'thumbnail' => 'news/pmb-2026.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'created_by' => $adminId,
            ],
            [
                'title' => 'Seminar Nasional Teknologi Informasi 2026',
                'content' => '<p>STT Pratama Adi akan menyelenggarakan Seminar Nasional Teknologi Informasi pada tanggal 15 Februari 2026.</p><p>Tema: "Artificial Intelligence dan Machine Learning untuk Masa Depan Indonesia"</p><p>Pembicara: Prof. Dr. Ahmad Santoso (ITB), Dr. Budi Raharjo (UI), dan praktisi industri terkemuka.</p>',
                'thumbnail' => 'news/seminar-2026.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'created_by' => $adminId,
            ],
            [
                'title' => 'Prestasi Mahasiswa STT Pratama Adi di Kompetisi Nasional',
                'content' => '<p>Tim mahasiswa STT Pratama Adi berhasil meraih juara 1 dalam Kompetisi Pemrograman Nasional 2025.</p><p>Tim yang terdiri dari 3 mahasiswa Teknik Informatika berhasil mengalahkan 50 tim dari berbagai universitas di Indonesia.</p><p>Selamat kepada para pemenang!</p>',
                'thumbnail' => 'news/prestasi-2025.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'created_by' => $adminId,
            ],
            [
                'title' => 'Kerjasama dengan Industri IT Terkemuka',
                'content' => '<p>STT Pratama Adi menjalin kerjasama dengan beberapa perusahaan IT terkemuka untuk program magang dan rekrutmen mahasiswa.</p><p>Perusahaan yang terlibat antara lain: PT. Teknologi Nusantara, PT. Digital Indonesia, dan PT. Software Solutions.</p>',
                'thumbnail' => 'news/kerjasama-industri.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'created_by' => $adminId,
            ],
            [
                'title' => 'Workshop Pengembangan Web Modern',
                'content' => '<p>Workshop pengembangan web modern menggunakan Laravel dan React akan diadakan pada tanggal 25 Januari 2026.</p><p>Workshop ini terbuka untuk mahasiswa dan umum. Pendaftaran dibuka hingga tanggal 20 Januari 2026.</p>',
                'thumbnail' => 'news/workshop-web.jpg',
                'status' => 'draft',
                'published_at' => now()->addDays(5),
                'created_by' => $adminId,
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }

        $this->command->info('Sample news created: ' . count($newsData) . ' articles');
    }

    /**
     * Seed sample facilities
     */
    private function seedFacilities(): void
    {
        $facilitiesData = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan 50 unit PC modern yang dilengkapi dengan software development tools terkini. Tersedia untuk praktikum pemrograman, jaringan komputer, dan pengembangan aplikasi.',
                'image' => 'facilities/lab-komputer.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Perpustakaan Digital',
                'description' => 'Perpustakaan modern dengan koleksi buku cetak dan digital lebih dari 10.000 judul. Dilengkapi dengan ruang baca yang nyaman dan akses internet berkecepatan tinggi.',
                'image' => 'facilities/perpustakaan.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Multimedia',
                'description' => 'Studio multimedia untuk pembelajaran desain grafis, video editing, dan animasi. Dilengkapi dengan perangkat keras dan software profesional.',
                'image' => 'facilities/multimedia.jpg',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Aula Serbaguna',
                'description' => 'Aula dengan kapasitas 500 orang untuk kegiatan seminar, workshop, dan acara kampus lainnya. Dilengkapi dengan sound system dan proyektor modern.',
                'image' => 'facilities/aula.jpg',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Kantin Kampus',
                'description' => 'Kantin yang menyediakan berbagai pilihan makanan dan minuman dengan harga terjangkau untuk mahasiswa dan dosen.',
                'image' => 'facilities/kantin.jpg',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Area Parkir',
                'description' => 'Area parkir yang luas dan aman untuk kendaraan mahasiswa, dosen, dan tamu kampus.',
                'image' => 'facilities/parkir.jpg',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($facilitiesData as $facility) {
            Facility::create($facility);
        }

        $this->command->info('Sample facilities created: ' . count($facilitiesData) . ' facilities');
    }

    /**
     * Seed sample tendik (staff)
     */
    private function seedTendik(): void
    {
        $tendikData = [
            [
                'name' => 'Siti Nurhaliza, S.Kom',
                'position' => 'Kepala Bagian Akademik',
                'photo' => 'tendik/siti-nurhaliza.jpg',
                'email' => 'siti.nurhaliza@sttpratama.ac.id',
                'phone' => '081234567890',
                'is_active' => true,
            ],
            [
                'name' => 'Budi Santoso, S.T',
                'position' => 'Kepala Laboratorium',
                'photo' => 'tendik/budi-santoso.jpg',
                'email' => 'budi.santoso@sttpratama.ac.id',
                'phone' => '081234567891',
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Lestari, S.E',
                'position' => 'Kepala Bagian Keuangan',
                'photo' => 'tendik/dewi-lestari.jpg',
                'email' => 'dewi.lestari@sttpratama.ac.id',
                'phone' => '081234567892',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fauzi, S.Kom',
                'position' => 'Staff IT',
                'photo' => 'tendik/ahmad-fauzi.jpg',
                'email' => 'ahmad.fauzi@sttpratama.ac.id',
                'phone' => '081234567893',
                'is_active' => true,
            ],
            [
                'name' => 'Rina Wijaya, S.Sos',
                'position' => 'Staff Kemahasiswaan',
                'photo' => 'tendik/rina-wijaya.jpg',
                'email' => 'rina.wijaya@sttpratama.ac.id',
                'phone' => '081234567894',
                'is_active' => true,
            ],
        ];

        foreach ($tendikData as $tendik) {
            Tendik::create($tendik);
        }

        $this->command->info('Sample tendik created: ' . count($tendikData) . ' staff members');
    }
}
