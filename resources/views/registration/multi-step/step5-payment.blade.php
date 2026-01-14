@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-600">Langkah 5 dari 6</span>
                <span class="text-sm text-gray-500">Metode Pembayaran</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 83.33%"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pilih Metode Pembayaran</h1>
            <p class="text-gray-600">Jalur: <span class="font-semibold text-blue-600">{{ $selectedPath }}</span></p>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Biaya Pendaftaran</span>
                    <span class="font-semibold">Rp {{ number_format($amounts['payment_amount'], 0, ',', '.') }}</span>
                </div>
                @if($amounts['discount_amount'] > 0)
                <div class="flex justify-between text-green-600">
                    <span>Diskon</span>
                    <span class="font-semibold">- Rp {{ number_format($amounts['discount_amount'], 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-900">
                    <span>Total Bayar</span>
                    <span class="text-blue-600">Rp {{ number_format($amounts['final_amount'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('registration.multi-step.payment.store') }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                
                @if($paymentMethods->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
                        <p class="text-yellow-700">Belum ada metode pembayaran tersedia.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($paymentMethods as $method)
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="{{ $method->code }}" 
                                   class="peer sr-only" required>
                            <div class="border-2 border-gray-200 rounded-lg p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($method->logo)
                                        <img src="{{ Storage::url($method->logo) }}" 
                                             alt="{{ $method->name }}" 
                                             class="h-10 w-10 object-contain mr-4">
                                        @else
                                        <div class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $method->name }}</h4>
                                            @if($method->admin_fee > 0)
                                            <p class="text-sm text-gray-500">Biaya Admin: Rp {{ number_format($method->admin_fee, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @endif
                
                @error('payment_method')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center">
                <a href="{{ route('registration.multi-step.voucher') }}" 
                   class="text-gray-600 hover:text-gray-900 font-medium">
                    ← Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl">
                    Lanjutkan →
                </button>
            </div>
        </form>

    </div>
</section>
@endsection
