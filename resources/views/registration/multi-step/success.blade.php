@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600">Terima kasih telah mendaftar</p>
        </div>

        <!-- Registration Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-2">Nomor Pendaftaran Anda</p>
                <p class="text-3xl font-bold text-blue-600">{{ $registration->registration_number }}</p>
                <p class="text-sm text-gray-500 mt-2">Simpan nomor ini untuk keperluan verifikasi</p>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Pendaftaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-semibold text-gray-900">{{ $registration->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $registration->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jalur Pendaftaran</p>
                        <p class="font-semibold text-gray-900">{{ $registration->registrationPath->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Program Studi</p>
                        <p class="font-semibold text-gray-900">{{ $registration->firstChoiceProgram->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Pembayaran</p>
                        <p class="font-semibold text-blue-600">Rp {{ number_format($registration->final_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            Menunggu Pembayaran
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Instruksi Pembayaran
            </h3>
            
            @if($paymentInstructions && count($paymentInstructions) > 0)
                <div class="space-y-3">
                    @foreach($paymentInstructions as $step => $instruction)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm mr-3">
                            {{ $loop->iteration }}
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700">{{ $instruction }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Silakan lakukan pembayaran sesuai dengan metode yang Anda pilih: <strong>{{ $registration->payment_method }}</strong></p>
            @endif

            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                <p class="text-sm text-yellow-800">
                    <strong>Penting:</strong> Setelah melakukan pembayaran, konfirmasi pembayaran akan diverifikasi dalam 1x24 jam. Anda akan menerima email konfirmasi setelah pembayaran terverifikasi.
                </p>
            </div>
        </div>

        <!-- Email Notification -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6 mb-6">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div>
                    <h4 class="font-bold text-blue-900 mb-1">Email Konfirmasi Terkirim</h4>
                    <p class="text-sm text-blue-800">
                        Kami telah mengirimkan email konfirmasi ke <strong>{{ $registration->email }}</strong>. 
                        Silakan periksa inbox atau folder spam Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Bukti Pendaftaran
            </button>
        </div>

    </div>
</section>
@endsection
