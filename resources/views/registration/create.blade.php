@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-900 mb-2">Pendaftaran Mahasiswa Baru</h1>
            <p class="text-gray-600">Silakan lengkapi formulir pendaftaran di bawah ini</p>
        </div>

        <!-- Registration Form Card -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <form action="{{ route('registration.store') }}" 
                  method="POST" 
                  id="registrationForm"
                  x-data="registrationForm()"
                  @submit="validateForm">
                @csrf

                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           x-model="formData.name"
                           @blur="validateField('name')"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                           :class="{ 'border-red-500': errors.name }"
                           placeholder="Masukkan nama lengkap Anda">
                    
                    <!-- Client-side error -->
                    <p x-show="errors.name" 
                       x-text="errors.name" 
                       class="mt-1 text-sm text-red-600"
                       x-transition:enter="transition ease-out duration-200"
                       x-transition:enter-start="opacity-0 transform -translate-y-1"
                       x-transition:enter-end="opacity-100 transform translate-y-0"></p>
                    
                    <!-- Server-side error -->
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           x-model="formData.email"
                           @blur="validateField('email')"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                           :class="{ 'border-red-500': errors.email }"
                           placeholder="contoh@email.com">
                    
                    <!-- Client-side error -->
                    <p x-show="errors.email" 
                       x-text="errors.email" 
                       class="mt-1 text-sm text-red-600"
                       x-transition:enter="transition ease-out duration-200"
                       x-transition:enter-start="opacity-0 transform -translate-y-1"
                       x-transition:enter-end="opacity-100 transform translate-y-0"></p>
                    
                    <!-- Server-side error -->
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           x-model="formData.phone"
                           @blur="validateField('phone')"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                           :class="{ 'border-red-500': errors.phone }"
                           placeholder="08123456789">
                    <p class="mt-1 text-xs text-gray-500">Format: 08123456789 atau +628123456789</p>
                    
                    <!-- Client-side error -->
                    <p x-show="errors.phone" 
                       x-text="errors.phone" 
                       class="mt-1 text-sm text-red-600"
                       x-transition:enter="transition ease-out duration-200"
                       x-transition:enter-start="opacity-0 transform -translate-y-1"
                       x-transition:enter-end="opacity-100 transform translate-y-0"></p>
                    
                    <!-- Server-side error -->
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="4"
                              x-model="formData.address"
                              @blur="validateField('address')"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 resize-none"
                              :class="{ 'border-red-500': errors.address }"
                              placeholder="Masukkan alamat lengkap Anda">{{ old('address') }}</textarea>
                    
                    <!-- Client-side error -->
                    <p x-show="errors.address" 
                       x-text="errors.address" 
                       class="mt-1 text-sm text-red-600"
                       x-transition:enter="transition ease-out duration-200"
                       x-transition:enter-start="opacity-0 transform -translate-y-1"
                       x-transition:enter-end="opacity-100 transform translate-y-0"></p>
                    
                    <!-- Server-side error -->
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-600 hover:text-primary-600 transition-colors duration-200 flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="bg-primary-600 text-white px-8 py-3 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                        <span x-show="!isSubmitting">Daftar Sekarang</span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-900 mb-1">Informasi Penting</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Pastikan semua data yang Anda masukkan sudah benar</li>
                        <li>• Nomor pendaftaran akan dikirimkan setelah formulir berhasil disubmit</li>
                        <li>• Simpan nomor pendaftaran Anda untuk proses selanjutnya</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function registrationForm() {
    return {
        formData: {
            name: '',
            email: '',
            phone: '',
            address: ''
        },
        errors: {
            name: '',
            email: '',
            phone: '',
            address: ''
        },
        isSubmitting: false,

        validateField(field) {
            this.errors[field] = '';
            
            switch(field) {
                case 'name':
                    if (!this.formData.name.trim()) {
                        this.errors.name = 'Nama lengkap wajib diisi.';
                    } else if (this.formData.name.length > 255) {
                        this.errors.name = 'Nama lengkap tidak boleh lebih dari 255 karakter.';
                    }
                    break;
                    
                case 'email':
                    if (!this.formData.email.trim()) {
                        this.errors.email = 'Email wajib diisi.';
                    } else if (!this.isValidEmail(this.formData.email)) {
                        this.errors.email = 'Format email tidak valid.';
                    }
                    break;
                    
                case 'phone':
                    if (!this.formData.phone.trim()) {
                        this.errors.phone = 'Nomor telepon wajib diisi.';
                    } else if (!this.isValidPhone(this.formData.phone)) {
                        this.errors.phone = 'Format nomor telepon tidak valid. Gunakan format Indonesia (contoh: 08123456789 atau +628123456789).';
                    }
                    break;
                    
                case 'address':
                    if (!this.formData.address.trim()) {
                        this.errors.address = 'Alamat lengkap wajib diisi.';
                    } else if (this.formData.address.length > 500) {
                        this.errors.address = 'Alamat lengkap tidak boleh lebih dari 500 karakter.';
                    }
                    break;
            }
        },

        validateForm(event) {
            // Validate all fields
            this.validateField('name');
            this.validateField('email');
            this.validateField('phone');
            this.validateField('address');

            // Check if there are any errors
            const hasErrors = Object.values(this.errors).some(error => error !== '');
            
            if (hasErrors) {
                event.preventDefault();
                // Scroll to first error
                const firstError = Object.keys(this.errors).find(key => this.errors[key] !== '');
                if (firstError) {
                    document.getElementById(firstError)?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                this.isSubmitting = true;
            }
        },

        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        isValidPhone(phone) {
            const phoneRegex = /^(\+62|62|0)[0-9]{9,12}$/;
            return phoneRegex.test(phone);
        }
    }
}
</script>
@endpush
