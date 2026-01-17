@extends('layouts.app')

@section('content')
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        @include('registration.partials.progress', ['currentStep' => 3])

        <!-- Flash Messages -->
        @if(session('warning'))
            <div class="mt-4 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg">
                {{ session('warning') }}
            </div>
        @endif

        <div class="space-y-6 mt-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Konfirmasi Data Pendaftaran</h1>
                <p class="mt-2 text-gray-600">Periksa kembali data Anda sebelum melanjutkan ke pembayaran.</p>
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
                        @if($path->system_type)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                {{ ucfirst($path->system_type) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Personal Info -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Nama Lengkap</span>
                        <span class="font-medium text-gray-900">{{ $formData['name'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">No Handphone</span>
                        <span class="font-medium text-gray-900">{{ $formData['phone'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Alamat Email</span>
                        <span class="font-medium text-gray-900">{{ $formData['email'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Tanggal Lahir</span>
                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($formData['date_of_birth'])->format('d F Y') }}</span>
                    </div>
                    <div class="md:col-span-2 py-2 border-b">
                        <span class="text-gray-600 block mb-1">Alamat Lengkap</span>
                        <span class="font-medium text-gray-900">{{ $formData['address'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Program Selection -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilihan Program Studi</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Jenis Program</span>
                        <span class="font-medium text-gray-900">{{ $formData['program_type'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Pilihan 1</span>
                        <span class="font-medium text-gray-900">{{ $firstChoiceProgram->degree_level }} - {{ $firstChoiceProgram->name }}</span>
                    </div>
                    @if($secondChoiceProgram)
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Pilihan 2</span>
                        <span class="font-medium text-gray-900">{{ $secondChoiceProgram->degree_level }} - {{ $secondChoiceProgram->name }}</span>
                    </div>
                    @endif
                    @if(!empty($formData['referral_code']))
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Kode Referral</span>
                        <span class="font-medium text-gray-900">{{ $formData['referral_code'] }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Confirmation Form -->
            <form action="{{ route('registration.confirm') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Checkbox -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="confirm_data" id="confirm_data" 
                               class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                               required>
                        <span class="ml-3 text-gray-700">
                            Saya menyetujui bahwa data yang telah dimasukkan adalah <strong>Benar</strong> dan dapat dipertanggungjawabkan.
                        </span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-between">
                    <a href="{{ route('registration.edit') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Ubah Data
                    </a>
                    <button type="submit" id="submitBtn" disabled
                            class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Lanjutkan Mendaftar →
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('confirm_data');
    const submitBtn = document.getElementById('submitBtn');
    
    checkbox.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });
});
</script>
@endsection
