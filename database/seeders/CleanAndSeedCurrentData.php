<?php

namespace Database\Seeders;

use App\Models\RegistrationPath;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CleanAndSeedCurrentData extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini akan:
     * 1. Menonaktifkan semua jalur pendaftaran lama
     * 2. Menonaktifkan semua program studi lama
     * 3. Membuat data baru sesuai permintaan klien
     */
    public function run(): void
    {
        $this->command->info('🧹 Membersihkan data lama...');
        
        // Nonaktifkan semua jalur pendaftaran lama
        RegistrationPath::query()->update(['is_active' => false]);
        $this->command->info('✅ Semua jalur pendaftaran lama dinonaktifkan');
        
        // Nonaktifkan semua program studi lama
        StudyProgram::query()->update(['is_active' => false]);
        $this->command->info('✅ Semua program studi lama dinonaktifkan');

        $this->command->info('');
        $this->command->info('📚 Membuat data baru...');

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
            $this->command->info("  ✓ {$program->name} ({$program->code})");
        }

        // ========================================
        // 2. JALUR PENDAFTARAN
        // ========================================

        $this->command->info('');
        $this->command->info('🎯 Membuat jalur pendaftaran...');

        // Gelombang 1: 1 April 2026 - 31 Juli 2026 (AKTIF SEKARANG)
        $gelombang1Start = Carbon::create(2026, 4, 1);
        $gelombang1End = Carbon::create(2026, 7, 31);

        // Gelombang 2: 1 Agustus - 30 November 2026
        $gelombang2Start = Carbon::create(2026, 8, 1);
        $gelombang2End = Carbon::create(2026, 11, 30);

        // Gelombang 3: 1 Desember 2026 - 31 Maret 2027
        $gelombang3Start = Carbon::create(2026, 12, 1);
        $gelombang3End = Carbon::create(2027, 3, 31);

        $paths = [
            // ========================================
            // JALUR MANDIRI - GELOMBANG 1 (AKTIF)
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
                'is_active' => false,
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
                'is_active' => false,
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
            // JALUR KIP - GELOMBANG 1 (AKTIF)
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
                'is_active' => false,
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
                'is_active' => false,
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

            $status = $path->is_active ? '✅ AKTIF' : '⏳ Belum Aktif';
            $this->command->info("  ✓ {$path->name} - {$path->wave} {$status}");
        }

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('✅ SEEDER BERHASIL DIJALANKAN!');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('📚 PROGRAM STUDI (2):');
        $this->command->info('   1. Digital Marketing (S1-DM)');
        $this->command->info('   2. Teknik Informatika (S1-TI)');
        $this->command->info('');
        $this->command->info('🎯 JALUR PENDAFTARAN AKTIF (2):');
        $this->command->info('   1. Mandiri - Gelombang 1 (Rp 350.000)');
        $this->command->info('   2. KIP - Gelombang 1 (Rp 250.000)');
        $this->command->info('');
        $this->command->info('📅 PERIODE GELOMBANG 1:');
        $this->command->info('   1 April 2026 - 31 Juli 2026');
        $this->command->info('');
        $this->command->info('💡 NEXT STEPS:');
        $this->command->info('   1. Buka halaman: /registration/search');
        $this->command->info('   2. Harus muncul 2 card: Mandiri (biru) dan KIP (hijau)');
        $this->command->info('   3. Test alur pendaftaran lengkap');
        $this->command->info('');
    }
}
