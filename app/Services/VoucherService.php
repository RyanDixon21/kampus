<?php

namespace App\Services;

use App\Models\Voucher;
use Illuminate\Support\Facades\Log;

class VoucherService
{
    /**
     * Validate voucher code
     * 
     * @param string $code
     * @param int $pathId
     * @return array ['valid' => bool, 'message' => string, 'voucher' => Voucher|null]
     */
    public function validate(string $code, int $pathId): array
    {
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return [
                'valid' => false,
                'message' => 'Kode voucher tidak ditemukan',
                'voucher' => null
            ];
        }

        if (!$voucher->isValid()) {
            return [
                'valid' => false,
                'message' => 'Voucher sudah tidak berlaku atau belum aktif',
                'voucher' => null
            ];
        }

        if (!$voucher->canBeUsed()) {
            return [
                'valid' => false,
                'message' => 'Voucher sudah mencapai batas penggunaan maksimal',
                'voucher' => null
            ];
        }

        if (!$voucher->isApplicableToPath($pathId)) {
            return [
                'valid' => false,
                'message' => 'Voucher tidak berlaku untuk jalur pendaftaran ini',
                'voucher' => null
            ];
        }

        return [
            'valid' => true,
            'message' => 'Voucher berhasil diterapkan',
            'voucher' => $voucher
        ];
    }

    /**
     * Apply discount to amount
     * 
     * @param Voucher $voucher
     * @param float $amount
     * @return float
     */
    public function applyDiscount(Voucher $voucher, float $amount): float
    {
        return $voucher->calculateDiscount($amount);
    }

    /**
     * Mark voucher as used
     * 
     * @param Voucher $voucher
     * @return void
     */
    public function markAsUsed(Voucher $voucher): void
    {
        try {
            $voucher->incrementUsedCount();
            Log::info('Voucher marked as used', [
                'voucher_code' => $voucher->code,
                'used_count' => $voucher->used_count
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to mark voucher as used', [
                'voucher_code' => $voucher->code,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if voucher can be used
     * 
     * @param Voucher $voucher
     * @return bool
     */
    public function canBeUsed(Voucher $voucher): bool
    {
        return $voucher->canBeUsed();
    }
}
