<?php

namespace Database\Seeders;

use App\Models\RegistrationPath;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CurrentRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini untuk data saat ini sesuai permintaan klien:
     * - 2 Jalur: Mandiri dan KIP
     * - 2 Program Studi: Digital Marketing dan Teknik Informatika
     * - 3 Gelombang Pendaftaran
     */
    public function run(): void
    {
        // ========================================
        // 1. PROGRAM STUDI
        // ========================================
        
        $programs = [
            [
                'name' => 'Digital Marketing',
                'code' => 'S1-DM',
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'degree_level' => 'S1',
                'description' => 'Program studi yang mempelajari tentang pemasaran digital, social media marketing, SEO, content marketing, dan strategi digital bisnis modern.',
                'is_active' => true,
            ],
            [
                'name' => 'Teknik Informatika',
                'code' => 'S1-TI',
                'faculty' => 'Fakultas Teknik',
                'degree_level' => 'S1',
                'description' => 'Program studi yang mempelajari tentang pemrograman, pengembangan software, sistem informasi, database, dan teknologi komputer.',
                'is_active' => true,
            ],
        ];

        $createdPrograms = [];
        foreach ($programs as $programData) {
            $program = StudyProgram::updateOrCreate(
                ['code' => $programData['code']],
                $programData
            );
            $createdPrograms[] = $program;
        }

        // ========================================
        // 2. JALUR PENDAFTARAN
        // ========================================

        // Gelombang 1: 1 Oktober - 31 Januari
        $gelombang1Start = Carbon::create(2025, 10, 1);
        $gelombang1End = Carbon::create(2026, 1, 31);

        // Gelombang 2: 1 Februari - 31 Mei
        $gelombang2Start = Carbon::create(2026, 2, 1);
        $gelombang2End = Carbon::create(2026, 5, 31);

        // Gelombang 3: 1 Juni - 30 September
        $gelombang3Start = Carbon::create(2026, 6, 1);
        $gelombang3End = Carbon::create(2026, 9, 30);

        $paths = [
            // ========================================
            // JALUR MANDIRI - GELOMBANG 1
            // ========================================
            [
                'name' => 'Mandiri',
                'slug' => 'mandiri-gelombang-1',
                'description' => 'Jalur pendaftaran mandiri untuk calon mahasiswa baru. Tersedia pilihan kelas Reguler, Karyawan, dan Eksekutif.',
                'registration_fee' => 350000,
                'start_date' => $gelombang1Start,
                'end_date' => $gelombang1End,
                'is_active' => true,
                'quota' => 500,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 1',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 200000,
                    'Biaya Administrasi' => 150000,
                ],
            ],

            // ========================================
            // JALUR MANDIRI - GELOMBANG 2
            // ========================================
            [
                'name' => 'Mandiri',
                'slug' => 'mandiri-gelombang-2',
                'description' => 'Jalur pendaftaran mandiri untuk calon mahasiswa baru. Tersedia pilihan kelas Reguler, Karyawan, dan Eksekutif.',
                'registration_fee' => 350000,
                'start_date' => $gelombang2Start,
                'end_date' => $gelombang2End,
                'is_active' => false, // Belum aktif
                'quota' => 400,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 2',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 200000,
                    'Biaya Administrasi' => 150000,
                ],
            ],

            // ========================================
            // JALUR MANDIRI - GELOMBANG 3
            // ========================================
            [
                'name' => 'Mandiri',
                'slug' => 'mandiri-gelombang-3',
                'description' => 'Jalur pendaftaran mandiri untuk calon mahasiswa baru. Tersedia pilihan kelas Reguler, Karyawan, dan Eksekutif.',
                'registration_fee' => 350000,
                'start_date' => $gelombang3Start,
                'end_date' => $gelombang3End,
                'is_active' => false, // Belum aktif
                'quota' => 300,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 3',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 200000,
                    'Biaya Administrasi' => 150000,
                ],
            ],

            // ========================================
            // JALUR KIP - GELOMBANG 1
            // ========================================
            [
                'name' => 'Kartu Indonesia Pintar (KIP)',
                'slug' => 'kip-gelombang-1',
                'description' => 'Jalur pendaftaran untuk pemegang Kartu Indonesia Pintar. Otomatis masuk kelas Reguler dengan biaya pendaftaran yang lebih terjangkau.',
                'registration_fee' => 250000,
                'start_date' => $gelombang1Start,
                'end_date' => $gelombang1End,
                'is_active' => true,
                'quota' => 200,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 1',
                'period' => '2025/2026',
                'requirements' => [
                    'Kartu Indonesia Pintar' => 'Fotocopy Kartu Indonesia Pintar (KIP) yang masih berlaku',
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                    'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu dari Kelurahan/Desa',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran khusus untuk pemegang KIP. Sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 150000,
                    'Biaya Administrasi' => 100000,
                ],
            ],

            // ========================================
            // JALUR KIP - GELOMBANG 2
            // ========================================
            [
                'name' => 'Kartu Indonesia Pintar (KIP)',
                'slug' => 'kip-gelombang-2',
                'description' => 'Jalur pendaftaran untuk pemegang Kartu Indonesia Pintar. Otomatis masuk kelas Reguler dengan biaya pendaftaran yang lebih terjangkau.',
                'registration_fee' => 250000,
                'start_date' => $gelombang2Start,
                'end_date' => $gelombang2End,
                'is_active' => false, // Belum aktif
                'quota' => 150,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 2',
                'period' => '2025/2026',
                'requirements' => [
                    'Kartu Indonesia Pintar' => 'Fotocopy Kartu Indonesia Pintar (KIP) yang masih berlaku',
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                    'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu dari Kelurahan/Desa',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran khusus untuk pemegang KIP. Sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 150000,
                    'Biaya Administrasi' => 100000,
                ],
            ],

            // ========================================
            // JALUR KIP - GELOMBANG 3
            // ========================================
            [
                'name' => 'Kartu Indonesia Pintar (KIP)',
                'slug' => 'kip-gelombang-3',
                'description' => 'Jalur pendaftaran untuk pemegang Kartu Indonesia Pintar. Otomatis masuk kelas Reguler dengan biaya pendaftaran yang lebih terjangkau.',
                'registration_fee' => 250000,
                'start_date' => $gelombang3Start,
                'end_date' => $gelombang3End,
                'is_active' => false, // Belum aktif
                'quota' => 100,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 3',
                'period' => '2025/2026',
                'requirements' => [
                    'Kartu Indonesia Pintar' => 'Fotocopy Kartu Indonesia Pintar (KIP) yang masih berlaku',
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                    'Kartu Keluarga' => 'Fotocopy Kartu Keluarga',
                    'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu dari Kelurahan/Desa',
                ],
                'system_type' => 'reguler',
                'payment_note' => 'Biaya pendaftaran khusus untuk pemegang KIP. Sudah termasuk biaya tes masuk dan administrasi.',
                'payment_items' => [
                    'Biaya Tes Masuk' => 150000,
                    'Biaya Administrasi' => 100000,
                ],
            ],
        ];

        // Create paths and attach programs
        foreach ($paths as $pathData) {
            $path = RegistrationPath::updateOrCreate(
                ['slug' => $pathData['slug']],
                $pathData
            );

            // Attach all created programs to this path
            $programIds = collect($createdPrograms)->pluck('id')->toArray();
            $path->studyPrograms()->sync($programIds);
        }

        $this->command->info('✅ Seeder berhasil dijalankan!');
        $this->command->info('📚 Program Studi: Digital Marketing, Teknik Informatika');
        $this->command->info('🎯 Jalur Pendaftaran: Mandiri (3 gelombang), KIP (3 gelombang)');
        $this->command->info('📅 Gelombang 1: 1 Oktober 2025 - 31 Januari 2026 (AKTIF)');
        $this->command->info('📅 Gelombang 2: 1 Februari 2026 - 31 Mei 2026 (BELUM AKTIF)');
        $this->command->info('📅 Gelombang 3: 1 Juni 2026 - 30 September 2026 (BELUM AKTIF)');
    }
}
