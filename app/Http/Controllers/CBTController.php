<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\CbtResult;
use App\Services\CBTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CBTController extends Controller
{
    public function __construct(
        private CBTService $cbtService
    ) {}
    
    /**
     * Show CBT login form.
     * 
     * Requirements: 4.1, 4.2
     */
    public function login()
    {
        return view('cbt.login');
    }
    
    /**
     * Authenticate user for CBT using registration number.
     * 
     * Requirements: 4.2
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ], [
            'registration_number.required' => 'Nomor pendaftaran wajib diisi',
        ]);
        
        // Sanitize input to prevent XSS
        $registrationNumber = htmlspecialchars(strip_tags($request->registration_number), ENT_QUOTES, 'UTF-8');
        
        // Find registration with paid status
        $registration = Registration::where('registration_number', $registrationNumber)
            ->where('payment_status', 'paid')
            ->first();
        
        if (!$registration) {
            return back()->withErrors([
                'registration_number' => 'Nomor pendaftaran tidak ditemukan atau pembayaran belum dikonfirmasi',
            ]);
        }
        
        // Check if CBT already completed
        if ($registration->cbt_completed_at) {
            return back()->withErrors([
                'registration_number' => 'Anda sudah menyelesaikan ujian CBT',
            ]);
        }
        
        // Store registration ID in session
        Session::put('cbt_registration_id', $registration->id);
        
        return redirect()->route('cbt.start');
    }
    
    /**
     * Start CBT exam and display questions.
     * 
     * Requirements: 4.3, 4.4, 4.5, 4.6
     */
    public function start()
    {
        // Check if user is authenticated for CBT
        if (!Session::has('cbt_registration_id')) {
            return redirect()->route('cbt.login')
                ->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }
        
        $registrationId = Session::get('cbt_registration_id');
        $registration = Registration::findOrFail($registrationId);
        
        // Get random questions
        $questions = $this->cbtService->getRandomQuestions(50);
        
        // Set exam duration (90 minutes)
        $duration = 90;
        
        // Store start time in session
        Session::put('cbt_start_time', now());
        
        return view('cbt.exam', compact('questions', 'duration', 'registration'));
    }
    
    /**
     * Submit CBT answers and calculate score.
     * 
     * Requirements: 4.6, 4.7
     */
    public function submit(\App\Http\Requests\CBTAnswerRequest $request)
    {
        // Check if user is authenticated for CBT
        if (!Session::has('cbt_registration_id')) {
            return redirect()->route('cbt.login')
                ->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }
        
        $registrationId = Session::get('cbt_registration_id');
        $registration = Registration::findOrFail($registrationId);
        
        // Get validated and sanitized answers
        $answers = $request->getAnswers();
        
        if (empty($answers)) {
            return back()->withErrors(['error' => 'Format jawaban tidak valid']);
        }
        
        // Calculate score
        $score = $this->cbtService->calculateScore($answers);
        
        // Save result and get the result object
        $cbtResult = $this->cbtService->saveResult($registration, $answers, $score);
        
        // Prepare result data for view
        $result = [
            'score' => $score,
            'total_questions' => $cbtResult->total_questions,
            'correct_answers' => $cbtResult->correct_answers,
        ];
        
        // Clear session
        Session::forget('cbt_registration_id');
        Session::forget('cbt_start_time');
        
        return view('cbt.result', compact('result', 'registration'));
    }
}
