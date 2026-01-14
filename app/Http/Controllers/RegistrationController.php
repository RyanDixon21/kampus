<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Setting;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService
    ) {}
    
    /**
     * Show the registration form.
     * Redirects to new multi-step registration system.
     * 
     * Requirements: 3.1, 3.2
     */
    public function create()
    {
        // Redirect to new multi-step registration system
        return redirect()->route('registration.search');
    }
    
    /**
     * Store a new registration.
     * 
     * Requirements: 3.2, 3.3, 3.4, 3.5
     */
    public function store(RegistrationRequest $request)
    {
        // Check if registration is open
        $registrationOpen = Setting::get('registration_open', true);
        
        if (!$registrationOpen) {
            return redirect()
                ->route('registration.create')
                ->with('error', 'Maaf, pendaftaran mahasiswa baru saat ini sedang ditutup.');
        }
        
        // Register using service with validated data
        $registration = $this->registrationService->register($request->validated());
        
        return redirect()
            ->route('registration.payment', $registration)
            ->with('success', 'Data pendaftaran berhasil disimpan');
    }
    
    /**
     * Show payment information page.
     * 
     * Requirements: 3.6, 3.7
     */
    public function payment(Registration $registration)
    {
        return view('registration.payment', compact('registration'));
    }
    
    /**
     * Show completion page with WhatsApp confirmation.
     * 
     * Requirements: 3.8, 9.2, 9.3, 9.4
     */
    public function complete(Registration $registration)
    {
        $waNumber = Setting::get('wa_admin');
        $message = $this->registrationService->generateWhatsAppMessage($registration);
        
        return view('registration.complete', compact('registration', 'waNumber', 'message'));
    }
}
