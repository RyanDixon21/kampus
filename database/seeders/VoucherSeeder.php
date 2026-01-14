<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'DISKON50',
                'type' => 'percentage',
                'value' => 50,
                'max_uses' => 100,
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
                'applicable_paths' => null, // Berlaku untuk semua jalur
            ],
            [
                'code' => 'GRATIS100K',
                'type' => 'fixed',
                'value' => 100000,
                'max_uses' => 50,
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
                'applicable_paths' => null,
            ],
            [
                'code' => 'EARLYBIRD',
                'type' => 'percentage',
                'value' => 25,
                'max_uses' => null, // Unlimited
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonth(),
                'is_active' => true,
                'applicable_paths' => null,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
