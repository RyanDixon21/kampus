@extends('layouts.app')

@section('content')
<!-- Search Section -->
<section class="relative py-16 bg-gray-50 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        @if(!$registrationOpen)
        <!-- Registration Closed Alert -->
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-xl p-6 shadow-lg">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-red-900 mb-2">Jalur pendaftaran sudah ditutup, silakan memilih jalur pendaftaran yang masih dibuka</h3>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Access Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Pendaftaran Mahasiswa Baru</h2>
            <p class="text-gray-600 mb-6">Mulai proses pendaftaran Anda dengan sistem multi-step yang mudah dan terstruktur</p>
            
            <a href="{{ route('registration.search') }}" 
               class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-10 py-4 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Mulai Pendaftaran
            </a>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold mr-3">
                        1
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Pilih Jalur</h4>
                        <p class="text-sm text-gray-600">Pilih jalur pendaftaran yang sesuai</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold mr-3">
                        2
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Isi Data</h4>
                        <p class="text-sm text-gray-600">Lengkapi data diri dan pilihan prodi</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold mr-3">
                        3
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Bayar</h4>
                        <p class="text-sm text-gray-600">Pilih metode pembayaran dan selesaikan</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
