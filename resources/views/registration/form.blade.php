@extends('registration.layout')

@section('title', 'Formulir Pendaftaran')

@php $currentStep = 2; @endphp

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">Formulir Pendaftaran</h1>
        <p class="mt-2 text-gray-600">Lengkapi data pendaftaran untuk melanjutkan ke tahap selanjutnya.</p>
    </div>

    <!-- Selected Path -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-center justify-between">
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
            <a href="{{ route('registration.change-path') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Pindah Jalur
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('registration.form.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Personal Info Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $formData['name'] ?? '') }}" 
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. HP <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $formData['phone'] ?? '') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                           placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $formData['email'] ?? '') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                           placeholder="email@example.com" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $formData['date_of_birth'] ?? '') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror"
                           required>
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Program Selection Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilihan Program Studi</h2>
            <div class="space-y-4">
                <div>
                    <label for="program_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Program yang Dituju <span class="text-red-500">*</span></label>
                    <select name="program_type" id="program_type" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('program_type') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Jenis Program --</option>
                        <option value="IPA" {{ old('program_type', $formData['program_type'] ?? '') == 'IPA' ? 'selected' : '' }}>IPA</option>
                        <option value="IPS" {{ old('program_type', $formData['program_type'] ?? '') == 'IPS' ? 'selected' : '' }}>IPS</option>
                    </select>
                    @error('program_type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_choice_program_id" class="block text-sm font-medium text-gray-700 mb-1">Pilihan 1 <span class="text-red-500">*</span></label>
                        <select name="first_choice_program_id" id="first_choice_program_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('first_choice_program_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" 
                                        data-type="{{ $program->program_type }}"
                                        {{ old('first_choice_program_id', $formData['first_choice_program_id'] ?? '') == $program->id ? 'selected' : '' }}>
                                    {{ $program->degree_level }} - {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('first_choice_program_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="second_choice_program_id" class="block text-sm font-medium text-gray-700 mb-1">Pilihan 2</label>
                        <select name="second_choice_program_id" id="second_choice_program_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('second_choice_program_id') border-red-500 @enderror">
                            <option value="">-- Pilih Pilihan 2 (Opsional) --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}"
                                        data-type="{{ $program->program_type }}"
                                        {{ old('second_choice_program_id', $formData['second_choice_program_id'] ?? '') == $program->id ? 'selected' : '' }}>
                                    {{ $program->degree_level }} - {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('second_choice_program_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Referral</h2>
            <div>
                <label for="referral_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Referral</label>
                <input type="text" name="referral_code" id="referral_code" value="{{ old('referral_code', $formData['referral_code'] ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Masukkan kode referral (opsional)">
                <p class="mt-1 text-sm text-gray-500">Jika Anda memiliki kode referral, masukkan di sini.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Lanjutkan Mendaftar →
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const programType = document.getElementById('program_type');
    const firstChoice = document.getElementById('first_choice_program_id');
    const secondChoice = document.getElementById('second_choice_program_id');
    
    function filterPrograms() {
        const selectedType = programType.value;
        
        [firstChoice, secondChoice].forEach(select => {
            const options = select.querySelectorAll('option[data-type]');
            options.forEach(option => {
                if (!selectedType || option.dataset.type === selectedType) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) {
                        select.value = '';
                    }
                }
            });
        });
    }
    
    programType.addEventListener('change', filterPrograms);
    filterPrograms();
});
</script>
@endpush
@endsection
