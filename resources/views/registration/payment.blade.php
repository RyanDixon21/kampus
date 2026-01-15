@extends('layouts.app')

@section('content')
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        @include('registration.partials.progress', ['currentStep' => 4])

        <div class="space-y-6 mt-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Payment Methods -->
                    <div class="bg-white rounded-xl shadow-sm border p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h2>
                        <div class="space-y-3" id="paymentMethodList">
                            @forelse($paymentMethods as $index => $method)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option {{ $index === 0 ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <input type="radio" name="payment_method" value="{{ $method->code }}" 
                                           class="text-blue-600 focus:ring-blue-500"
                                           data-admin-fee="{{ $method->admin_fee }}"
                                           data-name="{{ $method->name }}"
                                           {{ $index === 0 ? 'checked' : '' }}>
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
                            @empty
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer border-blue-500 bg-blue-50 payment-method-option">
                                    <input type="radio" name="payment_method" value="transfer_manual" 
                                           class="text-blue-600 focus:ring-blue-500"
                                           data-admin-fee="0"
                                           data-name="Transfer Manual"
                                           checked>
                                    <div class="ml-4 flex-1">
                                        <span class="font-medium text-gray-900">Transfer Manual</span>
                                        <p class="text-sm text-gray-500 mt-1">Transfer ke rekening dan kirim bukti via WhatsApp</p>
                                    </div>
                                </label>
                            @endforelse
                        </div>
                        <p id="paymentError" class="mt-2 text-sm text-red-500 hidden"></p>
                    </div>
                </div>

                <!-- Right Column - Payment Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border p-6 sticky top-28">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pembayaran</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Biaya Formulir</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($amounts['base_amount'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-2" id="adminFeeRow">
                                <span class="text-gray-600">Biaya Admin</span>
                                <span class="font-medium text-gray-900" id="adminFeeAmount">Rp 0</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-900">Total Pembayaran</span>
                                    <span class="font-bold text-xl text-blue-600" id="totalAmount">Rp {{ number_format($amounts['final_amount'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="submitPaymentBtn" class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all">
            <!-- Success Icon -->
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <div class="mt-4 text-center">
                <h3 class="text-xl font-bold text-gray-900">Terima Kasih!</h3>
                <p class="mt-2 text-gray-600">Pendaftaran Anda berhasil disimpan.</p>
                <p class="text-sm text-gray-500 mt-1">Nomor Pendaftaran:</p>
                <p class="text-2xl font-bold text-blue-600 mt-1" id="registrationNumber">-</p>
            </div>

            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <strong>Silakan kirim bukti pembayaran</strong> sebesar <strong id="modalTotalAmount">Rp 0</strong> ke kontak WhatsApp berikut untuk verifikasi.
                </p>
            </div>

            <div class="mt-6 space-y-3">
                <a href="#" id="whatsappBtn" target="_blank" class="w-full flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Kirim Bukti via WhatsApp
                </a>
                <a href="{{ route('home') }}" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseAmount = {{ $amounts['base_amount'] }};
    let adminFee = 0;
    let finalAmount = baseAmount;
    
    const adminFeeRow = document.getElementById('adminFeeRow');
    const adminFeeAmountEl = document.getElementById('adminFeeAmount');
    const totalAmountEl = document.getElementById('totalAmount');
    const submitBtn = document.getElementById('submitPaymentBtn');
    const paymentError = document.getElementById('paymentError');
    const successModal = document.getElementById('successModal');
    
    const whatsappNumber = '{{ $settings["whatsapp_number"] ?? $settings["phone"] ?? "6281234567890" }}';
    
    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }
    
    function updateTotal() {
        finalAmount = baseAmount + adminFee;
        totalAmountEl.textContent = formatCurrency(finalAmount);
        
        if (adminFee > 0) {
            adminFeeAmountEl.textContent = formatCurrency(adminFee);
            adminFeeRow.style.display = '';
        } else {
            adminFeeRow.style.display = 'none';
        }
    }
    
    // Initialize with first selected method
    const firstSelected = document.querySelector('input[name="payment_method"]:checked');
    if (firstSelected) {
        adminFee = parseFloat(firstSelected.dataset.adminFee) || 0;
        updateTotal();
    }
    
    // Payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            adminFee = parseFloat(this.dataset.adminFee) || 0;
            
            document.querySelectorAll('.payment-method-option').forEach(opt => {
                opt.classList.remove('border-blue-500', 'bg-blue-50');
            });
            this.closest('.payment-method-option').classList.add('border-blue-500', 'bg-blue-50');
            
            updateTotal();
        });
    });
    
    // Submit payment
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        
        if (!selectedMethod) {
            paymentError.textContent = 'Silakan pilih metode pembayaran';
            paymentError.classList.remove('hidden');
            return;
        }
        
        paymentError.classList.add('hidden');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        
        fetch('{{ route("registration.payment.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                payment_method: selectedMethod.value
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('registrationNumber').textContent = data.registration_number;
                document.getElementById('modalTotalAmount').textContent = formatCurrency(data.final_amount || finalAmount);
                
                const message = `Halo, saya ingin mengirim bukti pembayaran pendaftaran.\n\nNomor Pendaftaran: ${data.registration_number}\nNama: ${data.name}\nTotal: ${formatCurrency(data.final_amount || finalAmount)}\n\nTerlampir bukti pembayaran saya.`;
                const waNumber = whatsappNumber.replace(/[^0-9]/g, '');
                document.getElementById('whatsappBtn').href = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
                
                successModal.classList.remove('hidden');
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            paymentError.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
            paymentError.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang';
        });
    });
});
</script>
@endsection
