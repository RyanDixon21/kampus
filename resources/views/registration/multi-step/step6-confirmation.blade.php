@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-600">Langkah 6 dari 6</span>
                <span class="text-sm text-gray-500">Konfirmasi</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Pendaftaran</h1>
            <p class="text-gray-600">Periksa kembali data Anda sebelum mengirim</p>
        </div>

        <!-- Confirmation Details -->
        <div class="space-y-6 mb-6">
            
            <!-- Jalur & Program Studi -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Jalur & Program Studi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Jalur Pendaftaran</p>
                        <p class="font-semibold text-gray-900">{{ $path->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Biaya Pendaftaran</p>
                        <p class="font-semibold text-gray-900">Rp {{ number_format($path->registration_fee, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Program Studi Pilihan 1</p>
                        <p class="font-semibold text-gray-900">{{ $firstChoiceProgram->name }} ({{ $firstChoiceProgram->degree_level }})</p>
                    </div>
                    @if($secondChoiceProgram)
                    <div>
                        <p class="text-gray-500">Program Studi Pilihan 2</p>
                        <p class="font-semibold text-gray-900">{{ $secondChoiceProgram->name }} ({{ $secondChoiceProgram->degree_level }})</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Data Diri -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Data Diri
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $sessionData['name'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $sessionData['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nomor Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $sessionData['phone'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($sessionData['date_of_birth'])->format('d M Y') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-900">{{ $sessionData['address'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Pembayaran
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Metode Pembayaran</span>
                        <span class="font-semibold text-gray-900">{{ $paymentMethod->name }}</span>
                    </div>
                    @if(isset($sessionData['voucher_code']) && $sessionData['voucher_code'])
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Kode Voucher</span>
                        <span class="font-semibold text-green-600">{{ $sessionData['voucher_code'] }}</span>
                    </div>
                    @endif
                    @if(isset($sessionData['referral_code']) && $sessionData['referral_code'])
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Kode Referral</span>
                        <span class="font-semibold text-gray-900">{{ $sessionData['referral_code'] }}</span>
                    </div>
                    @endif
                    <div class="border-t pt-3">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-500">Biaya Pendaftaran</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($amounts['payment_amount'], 0, ',', '.') }}</span>
                        </div>
                        @if($amounts['discount_amount'] > 0)
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-500">Diskon</span>
                            <span class="font-semibold text-green-600">- Rp {{ number_format($amounts['discount_amount'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-gray-900">Total Bayar</span>
                            <span class="text-blue-600">Rp {{ number_format($amounts['final_amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Terms & Conditions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <label class="flex items-start cursor-pointer">
                <input type="checkbox" id="agree-terms" class="mt-1 mr-3 h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                <span class="text-sm text-gray-700">
                    Saya menyatakan bahwa data yang saya berikan adalah benar dan saya bersedia mengikuti seluruh proses seleksi penerimaan mahasiswa baru sesuai dengan ketentuan yang berlaku.
                </span>
            </label>
        </div>

        <!-- Form -->
        <form action="{{ route('registration.multi-step.submit') }}" method="POST" id="submit-form">
            @csrf
            
            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center">
                <a href="{{ route('registration.multi-step.payment') }}" 
                   class="text-gray-600 hover:text-gray-900 font-medium">
                    ← Kembali
                </a>
                <button type="submit" id="submit-btn" disabled
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                    Kirim Pendaftaran
                </button>
            </div>
        </form>

    </div>
</section>

@push('scripts')
<script>
document.getElementById('agree-terms').addEventListener('change', function() {
    document.getElementById('submit-btn').disabled = !this.checked;
});

document.getElementById('submit-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.textContent = 'Mengirim...';
});
</script>
@endpush
@endsection
