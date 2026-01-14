<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            // Fakultas Ilmu Sosial dan Politik (IPS)
            [
                'name' => 'Administrasi Publik',
                'code' => 'S1-AP',
                'faculty' => 'Fakultas Ilmu Sosial dan Politik',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang administrasi dan kebijakan publik.',
                'is_active' => true,
            ],
            [
                'name' => 'Ilmu Komunikasi',
                'code' => 'S1-IKOM',
                'faculty' => 'Fakultas Ilmu Sosial dan Politik',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang komunikasi massa, public relations, dan jurnalistik.',
                'is_active' => true,
            ],
            [
                'name' => 'Ilmu Politik',
                'code' => 'S1-IP',
                'faculty' => 'Fakultas Ilmu Sosial dan Politik',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang sistem politik, pemerintahan, dan hubungan internasional.',
                'is_active' => true,
            ],

            // Fakultas Ekonomi dan Bisnis (IPS)
            [
                'name' => 'Akuntansi',
                'code' => 'S1-AK',
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang akuntansi keuangan, manajemen, dan perpajakan.',
                'is_active' => true,
            ],
            [
                'name' => 'Manajemen',
                'code' => 'S1-MJ',
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang manajemen bisnis, pemasaran, dan keuangan.',
                'is_active' => true,
            ],
            [
                'name' => 'Ekonomi Pembangunan',
                'code' => 'S1-EP',
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang ekonomi makro, mikro, dan pembangunan.',
                'is_active' => true,
            ],

            // Fakultas Teknik (IPA)
            [
                'name' => 'Teknik Informatika',
                'code' => 'S1-TI',
                'faculty' => 'Fakultas Teknik',
                'degree_level' => 'S1',
                'program_type' => 'IPA',
                'description' => 'Program studi yang mempelajari tentang pemrograman, sistem informasi, dan teknologi komputer.',
                'is_active' => true,
            ],
            [
                'name' => 'Teknik Sipil',
                'code' => 'S1-TS',
                'faculty' => 'Fakultas Teknik',
                'degree_level' => 'S1',
                'program_type' => 'IPA',
                'description' => 'Program studi yang mempelajari tentang konstruksi bangunan, jalan, dan jembatan.',
                'is_active' => true,
            ],
            [
                'name' => 'Teknik Elektro',
                'code' => 'S1-TE',
                'faculty' => 'Fakultas Teknik',
                'degree_level' => 'S1',
                'program_type' => 'IPA',
                'description' => 'Program studi yang mempelajari tentang sistem kelistrikan dan elektronika.',
                'is_active' => true,
            ],

            // Fakultas Keguruan dan Ilmu Pendidikan
            [
                'name' => 'Pendidikan Bahasa Inggris',
                'code' => 'S1-PBI',
                'faculty' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'degree_level' => 'S1',
                'program_type' => 'IPS',
                'description' => 'Program studi yang mempelajari tentang pengajaran bahasa Inggris.',
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Matematika',
                'code' => 'S1-PM',
                'faculty' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'degree_level' => 'S1',
                'program_type' => 'IPA',
                'description' => 'Program studi yang mempelajari tentang pengajaran matematika.',
                'is_active' => true,
            ],

            // Program Diploma (D3)
            [
                'name' => 'Akuntansi',
                'code' => 'D3-AK',
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'degree_level' => 'D3',
                'program_type' => 'IPS',
                'description' => 'Program diploma yang mempelajari tentang akuntansi praktis.',
                'is_active' => true,
            ],
            [
                'name' => 'Teknik Komputer',
                'code' => 'D3-TK',
                'faculty' => 'Fakultas Teknik',
                'degree_level' => 'D3',
                'program_type' => 'IPA',
                'description' => 'Program diploma yang mempelajari tentang perangkat keras dan jaringan komputer.',
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            StudyProgram::create($program);
        }
    }
}
