<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memvalidasi akses step pendaftaran.
 * Memastikan user tidak bisa mengakses step tertentu tanpa menyelesaikan step sebelumnya.
 * 
 * Requirements: 8.4
 */
class RegistrationStepMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $step): Response
    {
        $routeName = $request->route()->getName();
        
        // Validasi berdasarkan step yang diminta
        switch ($step) {
            case 'form':
                // Step 2: Butuh path_id di session
                if (!session()->has('registration.path_id')) {
                    return redirect()
                        ->route('registration.search')
                        ->with('warning', 'Silakan pilih jalur pendaftaran terlebih dahulu.');
                }
                break;
                
            case 'confirmation':
                // Step 3: Butuh path_id dan form_data di session
                if (!session()->has('registration.path_id')) {
                    return redirect()
                        ->route('registration.search')
                        ->with('warning', 'Silakan pilih jalur pendaftaran terlebih dahulu.');
                }
                if (!session()->has('registration.form_data')) {
                    return redirect()
                        ->route('registration.form')
                        ->with('warning', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
                }
                break;
                
            case 'payment':
                // Step 4: Butuh path_id, form_data, dan data_confirmed di session
                if (!session()->has('registration.path_id')) {
                    return redirect()
                        ->route('registration.search')
                        ->with('warning', 'Silakan pilih jalur pendaftaran terlebih dahulu.');
                }
                if (!session()->has('registration.form_data')) {
                    return redirect()
                        ->route('registration.form')
                        ->with('warning', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
                }
                if (!session()->has('registration.data_confirmed')) {
                    return redirect()
                        ->route('registration.confirmation')
                        ->with('warning', 'Silakan konfirmasi data pendaftaran terlebih dahulu.');
                }
                break;
        }
        
        return $next($request);
    }
}
