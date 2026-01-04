<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    /**
     * Register a new student with transaction support
     * 
     * @param array $data
     * @return Registration
     * @throws \Exception
     */
    public function register(array $data): Registration
    {
        DB::beginTransaction();
        
        try {
            $registration = Registration::create([
                'registration_number' => $this->generateRegistrationNumber(),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'status' => 'pending',
            ]);
            
            DB::commit();
            return $registration;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Generate unique registration number
     * Format: REG{YEAR}{SEQUENCE}
     * Example: REG20260001
     * 
     * @return string
     */
    private function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $lastNumber = Registration::whereYear('created_at', $year)
            ->max('registration_number');
            
        $sequence = $lastNumber ? intval(substr($lastNumber, -4)) + 1 : 1;
        
        return sprintf('REG%s%04d', $year, $sequence);
    }
    
    /**
     * Generate WhatsApp message for registration confirmation
     * 
     * @param Registration $registration
     * @return string
     */
    public function generateWhatsAppMessage(Registration $registration): string
    {
        return "Halo Admin, saya telah menyelesaikan pendaftaran dengan nomor: {$registration->registration_number}. Nama: {$registration->name}. Mohon konfirmasi pembayaran saya.";
    }
}
