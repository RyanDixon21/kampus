@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-600">Langkah 4 dari 6</span>
                <span class="text-sm text-gray-500">Voucher & Referral</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 66.67%"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Voucher & Kode Referral</h1>
            <p class="text-gray-600">Jalur: <span class="font-semibold text-blue-600">{{ $selectedPath }}</span></p>
            <p class="text-sm text-gray-500 mt-2">Opsional - Lewati jika tidak memiliki</p>
        </div>

        <!-- Form -->
        <form action="{{ route('registration.multi-step.voucher.store') }}" method="POST" x-data="voucherForm()">
            @csrf
            
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <!-- Registration Fee Display -->
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Biaya Pendaftaran</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($registrationFee, 0, ',', '.') }}</p>
                        </div>
                        <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Voucher Code -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Voucher <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="voucher_code" x-model="voucherCode" value="{{ old('voucher_code') }}"
                               class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase"
                               placeholder="Masukkan kode voucher">
                        <button type="button" @click="checkVoucher()" :disabled="!voucherCode || checking"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!checking">Cek</span>
                            <span x-show="checking">...</span>
                        </button>
                    </div>
                    @error('voucher_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Voucher Result -->
                    <div x-show="voucherMessage" class="mt-3 p-3 rounded-lg" 
                         :class="voucherValid ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
                        <p class="text-sm" x-text="voucherMessage"></p>
                        <div x-show="voucherValid && discountAmount > 0" class="mt-2 text-sm font-semibold">
                            Diskon: Rp <span x-text="discountAmount.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>

                <!-- Referral Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Referral <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <input type="text" name="referral_code" value="{{ old('referral_code') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase"
                           placeholder="Masukkan kode referral jika ada">
                    @error('referral_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kode referral dari mahasiswa atau alumni
                    </p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center">
                <a href="{{ route('registration.multi-step.personal-info') }}" 
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

@push('scripts')
<script>
function voucherForm() {
    return {
        voucherCode: '',
        checking: false,
        voucherValid: false,
        voucherMessage: '',
        discountAmount: 0,

        async checkVoucher() {
            if (!this.voucherCode) return;
            
            this.checking = true;
            this.voucherMessage = '';
            
            try {
                const response = await fetch('{{ route("registration.multi-step.voucher.apply") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        voucher_code: this.voucherCode
                    })
                });
                
                const data = await response.json();
                
                this.voucherValid = data.valid;
                this.voucherMessage = data.message;
                this.discountAmount = data.discount_amount || 0;
                
            } catch (error) {
                this.voucherValid = false;
                this.voucherMessage = 'Terjadi kesalahan saat memeriksa voucher';
            } finally {
                this.checking = false;
            }
        }
    }
}
</script>
@endpush
@endsection
