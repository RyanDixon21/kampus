<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\RegistrationPath;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use Illuminate\Database\Eloquent\Collection;

class RegistrationService
{
    public function __construct(
        private VoucherService $voucherService,
        private PaymentService $paymentService
    ) {}

    /**
     * Get filtered registration paths
     * 
     * @param array $filters ['degree_level' => string|null, 'study_program_id' => int|null, 'system_type' => string|null]
     * @return Collection
     */
    public function getFilteredPaths(array $filters = []): Collection
    {
        $query = RegistrationPath::query()->open();

        if (!empty($filters['degree_level'])) {
            $query->byDegreeLevel($filters['degree_level']);
        }

        if (!empty($filters['system_type'])) {
            $query->bySystemType($filters['system_type']);
        }

        if (!empty($filters['study_program_id'])) {
            $query->byStudyProgram($filters['study_program_id']);
        }

        return $query->orderBy('start_date', 'desc')->get();
    }

    /**
     * Create registration from session data
     * 
     * @param array $sessionData
     * @return Registration
     * @throws \Exception
     */
    public function createFromSession(array $sessionData): Registration
    {
        DB::beginTransaction();
        
        try {
            // Calculate final amount
            $amounts = $this->calculateFinalAmount(
                $sessionData['registration_fee'],
                $sessionData['voucher_code'] ?? null
            );

            $registration = Registration::create([
                'registration_number' => $this->generateRegistrationNumber(),
                'registration_path_id' => $sessionData['registration_path_id'],
                'first_choice_program_id' => $sessionData['first_choice_program_id'],
                'second_choice_program_id' => $sessionData['second_choice_program_id'] ?? null,
                'program_type' => $sessionData['program_type'] ?? null,
                'name' => $sessionData['name'],
                'email' => $sessionData['email'],
                'phone' => $sessionData['phone'],
                'date_of_birth' => $sessionData['date_of_birth'],
                'address' => $sessionData['address'] ?? '-',
                'voucher_code' => $sessionData['voucher_code'] ?? null,
                'referral_code' => $sessionData['referral_code'] ?? null,
                'payment_method' => $sessionData['payment_method'] ?? 'transfer_manual',
                'payment_amount' => $amounts['base_amount'],
                'discount_amount' => $amounts['discount_amount'],
                'final_amount' => $amounts['final_amount'],
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'data_confirmed_at' => $sessionData['data_confirmed_at'] ?? now(),
            ]);

            // Mark voucher as used if applicable
            if (!empty($sessionData['voucher_code'])) {
                $voucher = Voucher::where('code', $sessionData['voucher_code'])->first();
                if ($voucher) {
                    $this->voucherService->markAsUsed($voucher);
                }
            }
            
            DB::commit();
            return $registration;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create registration from session', [
                'error' => $e->getMessage(),
                'session_data' => $sessionData
            ]);
            throw $e;
        }
    }

    /**
     * Register a new student with transaction support (legacy method)
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
     * Format: REG-YYYY-XXXXX
     * Example: REG-2026-00001
     * 
     * @return string
     */
    public function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $lastNumber = Registration::whereYear('created_at', $year)
            ->max('registration_number');
            
        if ($lastNumber) {
            // Extract sequence from last number (REG-2026-00001 -> 00001)
            $parts = explode('-', $lastNumber);
            $sequence = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $sequence = 1;
        }
        
        return sprintf('REG-%s-%05d', $year, $sequence);
    }

    /**
     * Calculate final amount with discounts
     * 
     * @param float $baseAmount
     * @param string|null $voucherCode
     * @return array ['base_amount' => float, 'discount_amount' => float, 'final_amount' => float]
     */
    public function calculateFinalAmount(float $baseAmount, ?string $voucherCode): array
    {
        $discountAmount = 0;

        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->first();
            if ($voucher && $voucher->canBeUsed()) {
                $discountAmount = $this->voucherService->applyDiscount($voucher, $baseAmount);
            }
        }

        $finalAmount = $baseAmount - $discountAmount;

        return [
            'base_amount' => $baseAmount,
            'discount_amount' => $discountAmount,
            'final_amount' => max(0, $finalAmount) // Ensure non-negative
        ];
    }

    /**
     * Send confirmation email
     * 
     * @param Registration $registration
     * @return bool
     */
    public function sendConfirmationEmail(Registration $registration): bool
    {
        try {
            Mail::to($registration->email)->send(new RegistrationConfirmation($registration));
            
            Log::info('Registration confirmation email sent', [
                'registration_number' => $registration->registration_number,
                'email' => $registration->email
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send registration confirmation email', [
                'registration_number' => $registration->registration_number,
                'email' => $registration->email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
    
    /**
     * Generate WhatsApp message for registration confirmation
     * 
     * @param Registration $registration
     * @return string
     */
    public function generateWhatsAppMessage(Registration $registration): string
    {
        $message = "Halo Admin, saya telah menyelesaikan pendaftaran dengan nomor: {$registration->registration_number}. ";
        $message .= "Nama: {$registration->name}. ";
        
        if ($registration->registrationPath) {
            $message .= "Jalur: {$registration->registrationPath->name}. ";
        }
        
        if ($registration->firstChoiceProgram) {
            $message .= "Program Studi: {$registration->firstChoiceProgram->name}. ";
        }
        
        $message .= "Mohon konfirmasi pembayaran saya.";
        
        return $message;
    }
}
