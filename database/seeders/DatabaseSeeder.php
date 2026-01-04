<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user first
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Seed default settings
        $this->call([
            SettingsSeeder::class,
        ]);

        // Optionally seed sample data for testing
        // Uncomment the line below to seed sample data
        // $this->call([
        //     SampleDataSeeder::class,
        // ]);
    }
}
