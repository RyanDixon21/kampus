<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationFormRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\RegistrationPath;
use App\Models\StudyProgram;
use App\Models\PaymentMethod;
use App\Services\RegistrationService;
use App\Services\VoucherService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MultiStepRegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService,
        private VoucherService $voucherService,
        private PaymentService $paymentService
    ) {}

    // ==========================================
    // STEP 1: Search and Select Path
    // ==========================================

    /**
     * Step 1: Show search page with filters
     */
    public function searchPaths(Request $request): View
    {
        $filters = [
            'degree_level' => $request->get('degree_level'),
            'study_program_id' => $request->get('study_program_id'),
            'system_type' => $request->get('system_type'),
        ];

        $paths = $this->registrationService->getFilteredPaths($filters);
        
        // Get filter options
        $degreeLevels = ['S1' => 'Sarjana (S1)', 'D3' => 'Diploma (D3)', 'S2' => 'Magister (S2)'];
        $systemTypes = ['reguler' => 'Reguler', 'karyawan' => 'Karyawan'];
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();

        return view('registration.search', compact(
            'paths', 
            'filters', 
            'degreeLevels', 
            'systemTypes', 
            'studyPrograms'
        ));
    }

    /**
     * Step 1: Show path detail
     */
    public function showPathDetail(RegistrationPath $path): View
    {
        if (!$path->isOpen()) {
            abort(404, 'Jalur pendaftaran tidak tersedia');
        }

        $studyPrograms = $path->studyPrograms()->active()->get();

        return view('registration.path-detail', compact('path', 'studyPrograms'));
    }

    /**
     * Step 1: Select path and proceed to form
     */
    public function selectPath(RegistrationPath $path): RedirectResponse
    {
        // Validate path is open
        if (!$path->isOpen()) {
            return back()->with('error', 'Jalur pendaftaran ini sudah ditutup');
        }

        // Validate quota
        if (!$path->hasQuotaAvailable()) {
            return back()->with('error', 'Kuota jalur pendaftaran ini sudah penuh');
        }

        // Clear previous session and store new path
        Session::forget('registration');
        Session::put('registration.step', 1);
        Session::put('registration.path_id', $path->id);

        return redirect()->route('registration.form');
    }


    // ==========================================
    // STEP 2: Registration Form
    // ==========================================

    /**
     * Step 2: Show registration form (personal info + programs)
     */
    public function showForm(): View
    {
        $pathId = Session::get('registration.path_id');
        
        if (!$pathId) {
            return redirect()->route('registration.search')
                ->with('error', 'Silakan pilih jalur pendaftaran terlebih dahulu');
        }

        $path = RegistrationPath::findOrFail($pathId);
        
        // Get programs based on path's study programs or all active programs
        $programs = $path->studyPrograms()->active()->get();
        if ($programs->isEmpty()) {
            $programs = StudyProgram::active()->get();
        }

        // Get existing form data from session
        $formData = Session::get('registration.form_data', []);

        return view('registration.form', compact('path', 'programs', 'formData'));
    }

    /**
     * Step 2: Store form data
     */
    public function storeForm(StoreRegistrationFormRequest $request): RedirectResponse
    {
        $pathId = Session::get('registration.path_id');
        
        if (!$pathId) {
            return redirect()->route('registration.search')
                ->with('error', 'Silakan pilih jalur pendaftaran terlebih dahulu');
        }

        // Store form data in session
        Session::put('registration.form_data', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'program_type' => $request->program_type,
            'first_choice_program_id' => $request->first_choice_program_id,
            'second_choice_program_id' => $request->second_choice_program_id,
            'referral_code' => $request->referral_code,
        ]);
        Session::put('registration.step', 2);

        return redirect()->route('registration.confirmation');
    }

    /**
     * Step 2: Change path (clear session and redirect to search)
     */
    public function changePath(): RedirectResponse
    {
        Session::forget('registration');
        return redirect()->route('registration.search')
            ->with('info', 'Silakan pilih jalur pendaftaran baru');
    }

    /**
     * Step 2: Get programs by type (AJAX)
     */
    public function getProgramsByType(string $type): JsonResponse
    {
        $pathId = Session::get('registration.path_id');
        
        $query = StudyProgram::active();
        
        if ($type && in_array($type, ['IPA', 'IPS'])) {
            $query->byProgramType($type);
        }

        // If path has specific programs, filter by those
        if ($pathId) {
            $path = RegistrationPath::find($pathId);
            if ($path && $path->studyPrograms()->count() > 0) {
                $programIds = $path->studyPrograms()->pluck('study_programs.id');
                $query->whereIn('id', $programIds);
            }
        }

        $programs = $query->orderBy('name')->get(['id', 'name', 'code', 'faculty', 'degree_level']);

        return response()->json($programs);
    }

    // ==========================================
    // STEP 3: Confirmation/Review
    // ==========================================

    /**
     * Step 3: Show confirmation page
     */
    public function showConfirmation(): View
    {
        $pathId = Session::get('registration.path_id');
        $formData = Session::get('registration.form_data');

        if (!$pathId || !$formData) {
            return redirect()->route('registration.search')
                ->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu');
        }

        $path = RegistrationPath::findOrFail($pathId);
        $firstChoiceProgram = StudyProgram::find($formData['first_choice_program_id']);
        $secondChoiceProgram = $formData['second_choice_program_id'] 
            ? StudyProgram::find($formData['second_choice_program_id']) 
            : null;

        return view('registration.confirmation', compact(
            'path',
            'formData',
            'firstChoiceProgram',
            'secondChoiceProgram'
        ));
    }

    /**
     * Step 3: Edit form (redirect back to form with data preserved)
     */
    public function editForm(): RedirectResponse
    {
        return redirect()->route('registration.form');
    }

    /**
     * Step 3: Confirm data and proceed to payment
     */
    public function confirmData(Request $request): RedirectResponse
    {
        $pathId = Session::get('registration.path_id');
        $formData = Session::get('registration.form_data');

        if (!$pathId || !$formData) {
            return redirect()->route('registration.search')
                ->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu');
        }

        // Validate checkbox
        if (!$request->has('confirm_data')) {
            return back()->with('error', 'Anda harus menyetujui bahwa data yang dimasukkan sudah benar');
        }

        // Mark data as confirmed
        Session::put('registration.data_confirmed', true);
        Session::put('registration.data_confirmed_at', now());
        Session::put('registration.step', 3);

        return redirect()->route('registration.payment');
    }


    // ==========================================
    // STEP 4: Payment
    // ==========================================

    /**
     * Step 4: Show payment page
     */
    public function showPayment(): View
    {
        $pathId = Session::get('registration.path_id');
        $formData = Session::get('registration.form_data');
        $dataConfirmed = Session::get('registration.data_confirmed');

        if (!$pathId || !$formData || !$dataConfirmed) {
            return redirect()->route('registration.confirmation')
                ->with('error', 'Silakan konfirmasi data terlebih dahulu');
        }

        $path = RegistrationPath::findOrFail($pathId);
        $paymentMethods = $this->paymentService->getActiveMethods();
        
        // Get voucher info from session if already applied
        $voucherData = Session::get('registration.voucher', []);
        
        // Calculate amounts
        $amounts = $this->registrationService->calculateFinalAmount(
            $path->registration_fee,
            $voucherData['code'] ?? null
        );

        return view('registration.payment', compact(
            'path',
            'paymentMethods',
            'amounts',
            'voucherData'
        ));
    }

    /**
     * Step 4: Apply voucher (AJAX)
     */
    public function applyVoucher(Request $request): JsonResponse
    {
        $voucherCode = $request->input('voucher_code');
        $pathId = Session::get('registration.path_id');

        if (!$pathId) {
            return response()->json([
                'valid' => false,
                'message' => 'Session tidak valid, silakan mulai ulang pendaftaran'
            ]);
        }

        if (!$voucherCode) {
            // Clear voucher from session
            Session::forget('registration.voucher');
            $path = RegistrationPath::find($pathId);
            
            return response()->json([
                'valid' => true,
                'message' => 'Voucher dihapus',
                'discount_amount' => 0,
                'final_amount' => $path->registration_fee
            ]);
        }

        $path = RegistrationPath::findOrFail($pathId);
        $validation = $this->voucherService->validate($voucherCode, $pathId);

        if ($validation['valid']) {
            $voucher = $validation['voucher'];
            $discountAmount = $this->voucherService->applyDiscount($voucher, $path->registration_fee);
            $finalAmount = $path->registration_fee - $discountAmount;

            // Store voucher in session
            Session::put('registration.voucher', [
                'code' => $voucherCode,
                'discount' => $discountAmount,
            ]);

            return response()->json([
                'valid' => true,
                'message' => $validation['message'],
                'discount_amount' => $discountAmount,
                'final_amount' => max(0, $finalAmount),
                'discount_type' => $voucher->type,
                'discount_value' => $voucher->value
            ]);
        }

        return response()->json($validation);
    }

    /**
     * Step 4: Process payment and create registration
     */
    public function processPayment(Request $request)
    {
        $pathId = Session::get('registration.path_id');
        $formData = Session::get('registration.form_data');
        $dataConfirmed = Session::get('registration.data_confirmed');
        $voucherData = Session::get('registration.voucher', []);

        // Check if AJAX request
        $isAjax = $request->expectsJson();

        if (!$pathId || !$formData || !$dataConfirmed) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pendaftaran tidak lengkap. Silakan mulai dari awal.'
                ], 400);
            }
            return redirect()->route('registration.search')
                ->with('error', 'Data pendaftaran tidak lengkap');
        }

        // Validate payment method
        $paymentMethod = $request->input('payment_method', 'transfer_manual');

        try {
            $path = RegistrationPath::findOrFail($pathId);

            // Prepare session data for registration service
            $sessionData = [
                'registration_path_id' => $pathId,
                'first_choice_program_id' => $formData['first_choice_program_id'],
                'second_choice_program_id' => $formData['second_choice_program_id'] ?? null,
                'program_type' => $formData['program_type'] ?? null,
                'name' => $formData['name'],
                'email' => $formData['email'],
                'phone' => $formData['phone'],
                'date_of_birth' => $formData['date_of_birth'],
                'referral_code' => $formData['referral_code'] ?? null,
                'voucher_code' => $voucherData['code'] ?? $request->input('voucher_code'),
                'payment_method' => $paymentMethod,
                'registration_fee' => $path->registration_fee,
                'data_confirmed_at' => Session::get('registration.data_confirmed_at'),
            ];

            // Create registration
            $registration = $this->registrationService->createFromSession($sessionData);

            // Send confirmation email (non-blocking)
            try {
                $this->registrationService->sendConfirmationEmail($registration);
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation email', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Clear session
            Session::forget('registration');

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil disimpan!',
                    'registration_number' => $registration->registration_number,
                    'registration_id' => $registration->id,
                    'name' => $registration->name,
                    'final_amount' => $registration->final_amount,
                ]);
            }

            return redirect()
                ->route('registration.success', ['registration' => $registration->id])
                ->with('success', 'Pendaftaran berhasil!');

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'path_id' => $pathId
            ]);
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan pendaftaran: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran. Silakan coba lagi.');
        }
    }


    // ==========================================
    // SUCCESS & UTILITIES
    // ==========================================

    /**
     * Show success page
     */
    public function showSuccess($registration): View
    {
        $registration = \App\Models\Registration::findOrFail($registration);
        
        $paymentInstructions = $this->paymentService->getInstructions(
            $registration->payment_method,
            $registration
        );

        // Generate WhatsApp message
        $whatsappMessage = $this->registrationService->generateWhatsAppMessage($registration);

        return view('registration.success', compact(
            'registration', 
            'paymentInstructions',
            'whatsappMessage'
        ));
    }

    /**
     * Restart registration (clear session)
     */
    public function restart(): RedirectResponse
    {
        Session::forget('registration');
        return redirect()->route('registration.search')
            ->with('info', 'Pendaftaran dimulai dari awal');
    }
}
