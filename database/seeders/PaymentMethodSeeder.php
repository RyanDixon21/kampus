<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Tokopedia',
                'code' => 'tokopedia',
                'logo' => null,
                'admin_fee' => 4500,
                'instructions' => [
                    '1' => 'Buka aplikasi Tokopedia',
                    '2' => 'Pilih menu "Top Up & Tagihan"',
                    '3' => 'Pilih "Pendidikan"',
                    '4' => 'Masukkan nomor pendaftaran: {registration_number}',
                    '5' => 'Periksa detail pembayaran (Total: Rp {amount})',
                    '6' => 'Pilih metode pembayaran',
                    '7' => 'Selesaikan pembayaran',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Bank Mandiri',
                'code' => 'mandiri',
                'logo' => null,
                'admin_fee' => 6500,
                'instructions' => [
                    '1' => 'Login ke Mandiri Online/Mobile Banking',
                    '2' => 'Pilih menu "Bayar"',
                    '3' => 'Pilih "Pendidikan"',
                    '4' => 'Pilih "Universitas Pasundan"',
                    '5' => 'Masukkan nomor pendaftaran: {registration_number}',
                    '6' => 'Periksa detail pembayaran (Total: Rp {amount})',
                    '7' => 'Masukkan PIN',
                    '8' => 'Simpan bukti pembayaran',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Shopee',
                'code' => 'shopee',
                'logo' => null,
                'admin_fee' => 4000,
                'instructions' => [
                    '1' => 'Buka aplikasi Shopee',
                    '2' => 'Pilih menu "Pulsa, Tagihan & Hiburan"',
                    '3' => 'Pilih "Pendidikan"',
                    '4' => 'Masukkan nomor pendaftaran: {registration_number}',
                    '5' => 'Periksa detail pembayaran (Total: Rp {amount})',
                    '6' => 'Pilih metode pembayaran',
                    '7' => 'Selesaikan pembayaran',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Bank BJB',
                'code' => 'bjb',
                'logo' => null,
                'admin_fee' => 5000,
                'instructions' => [
                    '1' => 'Login ke BJB Mobile Banking',
                    '2' => 'Pilih menu "Pembayaran"',
                    '3' => 'Pilih "Pendidikan"',
                    '4' => 'Pilih "Universitas Pasundan"',
                    '5' => 'Masukkan nomor pendaftaran: {registration_number}',
                    '6' => 'Periksa detail pembayaran (Total: Rp {amount})',
                    '7' => 'Masukkan PIN',
                    '8' => 'Simpan bukti pembayaran',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
