@extends('registration.layout')

@section('title', 'Pembayaran')

@php $currentStep = 4; @endphp

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">Pilih Metode Pembayaran</h1>
        <p class="mt-2 text-gray-600">Pilih metode pembayaran dan segera lakukan pembayaran biaya formulir.</p>
    </div>

    <!-- Selected Path -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-blue-600 font-medium">Kamu Memilih Jalur Pendaftaran</p>
                <p class="font-semibold text-gray-900">{{ $path->name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('registration.payment.process') }}" method="POST" id="paymentForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Voucher Section -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Voucher Pendaftaran</h2>
                    <div class="flex gap-2">
                        <input type="text" id="voucher_code" name="voucher_code" 
                               value="{{ $voucherData['code'] ?? '' }}"
                               class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Masukkan kode voucher">
                        <button type="button" id="applyVoucherBtn" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                            Terapkan
                        </button>
                    </div>
                    <div id="voucherMessage" class="mt-2 text-sm hidden"></div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h2>
                    <div class="space-y-3">
                        @foreach($paymentMethods as $method)
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option">
                                <input type="radio" name="payment_method" value="{{ $method->code }}" 
                                       class="text-blue-600 focus:ring-blue-500"
                                       data-admin-fee="{{ $method->admin_fee }}"
                                       required>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">{{ $method->name }}</span>
                                        @if($method->logo)
                                            <img src="{{ Storage::url($method->logo) }}" alt="{{ $method->name }}" class="h-8">
                                        @endif
                                    </div>
                                    @if($method->admin_fee > 0)
                                        <p class="text-sm text-gray-500 mt-1">Biaya admin Rp {{ number_format($method->admin_fee, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('payment_method')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border p-6 sticky top-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Biaya Formulir</span>
                            <span class="font-medium" id="baseAmount">Rp {{ number_format($amounts['base_amount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2" id="discountRow" style="{{ $amounts['discount_amount'] > 0 ? '' : 'display: none;' }}">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-green-600" id="discountAmount">- Rp {{ number_format($amounts['discount_amount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2" id="adminFeeRow" style="display: none;">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-medium" id="adminFeeAmount">Rp 0</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900">Total Pembayaran</span>
                                <span class="font-bold text-xl text-blue-600" id="totalAmount">Rp {{ number_format($amounts['final_amount'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseAmount = {{ $amounts['base_amount'] }};
    let discountAmount = {{ $amounts['discount_amount'] }};
    let adminFee = 0;
    
    const voucherInput = document.getElementById('voucher_code');
    const applyBtn = document.getElementById('applyVoucherBtn');
    const voucherMessage = document.getElementById('voucherMessage');
    const discountRow = document.getElementById('discountRow');
    const discountAmountEl = document.getElementById('discountAmount');
    const adminFeeRow = document.getElementById('adminFeeRow');
    const adminFeeAmountEl = document.getElementById('adminFeeAmount');
    const totalAmountEl = document.getElementById('totalAmount');
    
    function formatCurrency(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }
    
    function updateTotal() {
        const total = Math.max(0, baseAmount - discountAmount + adminFee);
        totalAmountEl.textContent = formatCurrency(total);
    }
    
    // Apply voucher
    applyBtn.addEventListener('click', function() {
        const code = voucherInput.value.trim();
        
        fetch('{{ route("registration.voucher.apply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ voucher_code: code })
        })
        .then(response => response.json())
        .then(data => {
            voucherMessage.classList.remove('hidden', 'text-green-600', 'text-red-600');
            
            if (data.valid) {
                voucherMessage.classList.add('text-green-600');
                discountAmount = data.discount_amount;
                discountRow.style.display = '';
                discountAmountEl.textContent = '- ' + formatCurrency(discountAmount);
            } else {
                voucherMessage.classList.add('text-red-600');
                discountAmount = 0;
                discountRow.style.display = 'none';
            }
            
            voucherMessage.textContent = data.message;
            updateTotal();
        });
    });
    
    // Payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            adminFee = parseFloat(this.dataset.adminFee) || 0;
            
            if (adminFee > 0) {
                adminFeeRow.style.display = '';
                adminFeeAmountEl.textContent = formatCurrency(adminFee);
            } else {
                adminFeeRow.style.display = 'none';
            }
            
            // Update visual selection
            document.querySelectorAll('.payment-method-option').forEach(opt => {
                opt.classList.remove('border-blue-500', 'bg-blue-50');
            });
            this.closest('.payment-method-option').classList.add('border-blue-500', 'bg-blue-50');
            
            updateTotal();
        });
    });
});
</script>
@endpush
@endsection
