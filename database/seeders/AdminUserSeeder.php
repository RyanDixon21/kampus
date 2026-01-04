<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@sttpratama.ac.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@sttpratama.ac.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@sttpratama.ac.id');
        $this->command->info('Password: password');
        $this->command->warn('Please change the password after first login!');
    }
}
