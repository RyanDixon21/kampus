@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start"
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <svg class="h-6 w-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-primary-900 mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600">Silakan lakukan pembayaran untuk melanjutkan proses pendaftaran</p>
        </div>

        <!-- Registration Number Card -->
        <div class="bg-white rounded-lg shadow-xl p-8 mb-6">
            <div class="text-center mb-6 pb-6 border-b border-gray-200">
                <p class="text-sm text-gray-600 mb-2">Nomor Pendaftaran Anda</p>
                <div class="inline-flex items-center bg-primary-50 px-6 py-3 rounded-lg">
                    <span class="text-3xl font-bold text-primary-700 tracking-wider">{{ $registration->registration_number }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">Simpan nomor ini untuk keperluan konfirmasi</p>
            </div>

            <!-- Registration Details -->
            <div class="space-y-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pendaftaran</h3>
                
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                        <p class="font-medium text-gray-900">{{ $registration->name }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <svg class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-gray-900">{{ $registration->email }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <svg class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-600">Nomor Telepon</p>
                        <p class="font-medium text-gray-900">{{ $registration->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information Card -->
        <div class="bg-white rounded-lg shadow-xl p-8 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pembayaran</h3>
            
            <!-- Payment Amount -->
            <div class="bg-gradient-to-r from-primary-50 to-blue-50 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Biaya Pendaftaran</p>
                        <p class="text-3xl font-bold text-primary-700">Rp 500.000</p>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-900">Metode Pembayaran</h4>
                
                <!-- Bank Transfer -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-primary-100 p-2 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Transfer Bank</p>
                            <p class="text-sm text-gray-600">BCA / Mandiri / BNI</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded p-3 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bank BCA</span>
                            <span class="font-mono font-medium">1234567890</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bank Mandiri</span>
                            <span class="font-mono font-medium">0987654321</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bank BNI</span>
                            <span class="font-mono font-medium">5555666677</span>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            <p class="text-gray-600">a.n. <span class="font-medium text-gray-900">STT Pratama Adi</span></p>
                        </div>
                    </div>
                </div>

                <!-- E-Wallet -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">E-Wallet</p>
                            <p class="text-sm text-gray-600">GoPay / OVO / Dana</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded p-3 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">GoPay / OVO / Dana</span>
                            <span class="font-mono font-medium">08123456789</span>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            <p class="text-gray-600">a.n. <span class="font-medium text-gray-900">STT Pratama Adi</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-900 mb-2">Langkah Selanjutnya</h3>
                    <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                        <li>Lakukan pembayaran sesuai dengan nominal yang tertera</li>
                        <li>Simpan bukti pembayaran Anda</li>
                        <li>Klik tombol "Lanjut ke Konfirmasi" di bawah</li>
                        <li>Hubungi admin melalui WhatsApp untuk konfirmasi pembayaran</li>
                        <li>Sertakan nomor pendaftaran dan bukti pembayaran</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" 
               class="flex-1 bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center">
                Kembali ke Beranda
            </a>
            <a href="{{ route('registration.complete', $registration) }}" 
               class="flex-1 bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 font-medium text-center flex items-center justify-center">
                Lanjut ke Konfirmasi
                <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
