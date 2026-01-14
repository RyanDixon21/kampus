<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\Registration;
use Illuminate\Support\Collection;

class PaymentService
{
    /**
     * Get active payment methods
     * 
     * @return Collection
     */
    public function getActiveMethods(): Collection
    {
        return PaymentMethod::active()->get();
    }

    /**
     * Calculate total with admin fee
     * 
     * @param float $amount
     * @param string $methodCode
     * @return float
     */
    public function calculateTotal(float $amount, string $methodCode): float
    {
        $method = PaymentMethod::where('code', $methodCode)->first();
        
        if (!$method) {
            return $amount;
        }

        return $method->calculateTotal($amount);
    }

    /**
     * Get payment instructions for a method
     * 
     * @param string $methodCode
     * @param Registration $registration
     * @return array
     */
    public function getInstructions(string $methodCode, Registration $registration): array
    {
        $method = PaymentMethod::where('code', $methodCode)->first();
        
        if (!$method || !$method->instructions) {
            return [
                'method_name' => $method?->name ?? 'Unknown',
                'steps' => []
            ];
        }

        // Replace placeholders in instructions
        $instructions = $method->instructions;
        $replacements = [
            '{registration_number}' => $registration->registration_number,
            '{amount}' => number_format($registration->final_amount, 0, ',', '.'),
            '{name}' => $registration->name,
            '{email}' => $registration->email
        ];

        foreach ($instructions as &$instruction) {
            if (is_string($instruction)) {
                $instruction = str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $instruction
                );
            }
        }

        return [
            'method_name' => $method->name,
            'logo' => $method->logo,
            'admin_fee' => $method->admin_fee,
            'steps' => $instructions
        ];
    }
}
