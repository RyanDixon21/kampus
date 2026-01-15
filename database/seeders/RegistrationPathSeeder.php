<?php

namespace Database\Seeders;

use App\Models\RegistrationPath;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class RegistrationPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paths = [
            [
                'name' => 'USM Reguler - USM-Sarjana Gelombang 1',
                'slug' => 'usm-reguler-gelombang-1',
                'description' => 'Jalur pendaftaran reguler untuk program sarjana gelombang 1. Terbuka untuk lulusan SMA/SMK/MA sederajat.',
                'registration_fee' => 300000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
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
                ],
                'system_type' => 'regular',
            ],
            [
                'name' => 'USM Reguler - USM-Sarjana Gelombang 2',
                'slug' => 'usm-reguler-gelombang-2',
                'description' => 'Jalur pendaftaran reguler untuk program sarjana gelombang 2. Terbuka untuk lulusan SMA/SMK/MA sederajat.',
                'registration_fee' => 350000,
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(4),
                'is_active' => true,
                'quota' => 300,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 2',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                ],
                'system_type' => 'regular',
            ],
            [
                'name' => 'Prestasi Akademik - PMDK-Sarjana Gelombang 1',
                'slug' => 'prestasi-akademik-gelombang-1',
                'description' => 'Jalur pendaftaran untuk siswa berprestasi akademik. Bebas biaya pendaftaran untuk siswa dengan nilai rata-rata minimal 8.0.',
                'registration_fee' => 0,
                'start_date' => now(),
                'end_date' => now()->addMonths(1)->addDays(15),
                'is_active' => true,
                'quota' => 100,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 1',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir dengan nilai rata-rata minimal 8.0',
                    'Sertifikat Prestasi' => 'Fotocopy sertifikat prestasi akademik (jika ada)',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                ],
                'system_type' => 'prestasi',
            ],
            [
                'name' => 'PMDK - Penelusuran Minat dan Kemampuan',
                'slug' => 'pmdk',
                'description' => 'Jalur penelusuran minat dan kemampuan untuk siswa yang direkomendasikan oleh sekolah.',
                'registration_fee' => 250000,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'is_active' => true,
                'quota' => 200,
                'degree_level' => 'S1',
                'wave' => 'Gelombang 1',
                'period' => '2025/2026',
                'requirements' => [
                    'Surat Rekomendasi' => 'Surat rekomendasi dari kepala sekolah',
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                ],
                'system_type' => 'pmdk',
            ],
            [
                'name' => 'USM Diploma - D3 Gelombang 1',
                'slug' => 'usm-diploma-gelombang-1',
                'description' => 'Jalur pendaftaran reguler untuk program diploma 3 gelombang 1.',
                'registration_fee' => 200000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'is_active' => true,
                'quota' => 150,
                'degree_level' => 'D3',
                'wave' => 'Gelombang 1',
                'period' => '2025/2026',
                'requirements' => [
                    'Ijazah/STTB' => 'Fotocopy ijazah atau surat keterangan lulus yang dilegalisir',
                    'Rapor' => 'Fotocopy rapor semester 1-6 yang dilegalisir',
                    'KTP' => 'Fotocopy KTP',
                    'Pas Foto' => 'Pas foto 3x4 sebanyak 3 lembar',
                ],
                'system_type' => 'regular',
            ],
        ];

        foreach ($paths as $pathData) {
            // Use updateOrCreate to avoid duplicate entry errors
            $path = RegistrationPath::updateOrCreate(
                ['slug' => $pathData['slug']], // Find by slug
                $pathData // Update or create with this data
            );
            
            // Sync study programs based on degree level
            $programs = StudyProgram::where('degree_level', $pathData['degree_level'])
                ->where('is_active', true)
                ->pluck('id');
            
            if ($programs->isNotEmpty()) {
                // Use sync instead of attach to avoid duplicates
                $path->studyPrograms()->sync($programs);
            }
        }
    }
}
