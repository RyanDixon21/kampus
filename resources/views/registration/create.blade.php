@extends('layouts.app')

@section('content')
<!-- Search Section -->
<section class="relative py-16 bg-gray-50 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        @if(!$registrationOpen)
        <!-- Registration Closed Alert -->
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-xl p-6 shadow-lg">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-red-900 mb-2">Jalur pendaftaran sudah ditutup, silakan memilih jalur pendaftaran yang masih dibuka</h3>
                </div>
            </div>
        </div>
        @endif

        <!-- Search Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8" x-data="registrationSearch()">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Jalur Pendaftaran</h2>
            <p class="text-gray-600 mb-6">Temukan jalur pendaftaran sesuai dengan pilihan program studi yang diminati.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Jenjang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">-- Pilih Jenjang --</label>
                    <select x-model="jenjang" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="S1">S1</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                    </select>
                </div>

                <!-- Program Studi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">-- Pilih Program Studi --</label>
                    <select x-model="prodi" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknik Komputer">Teknik Komputer</option>
                    </select>
                </div>

                <!-- Sistem Kuliah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">-- Pilih Sistem Kuliah --</label>
                    <select x-model="sistemKuliah" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Sistem Kuliah --</option>
                        <option value="Reguler">Reguler</option>
                        <option value="Karyawan">Karyawan</option>
                    </select>
                </div>
            </div>

            <button @click="searchRegistration()" 
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                Cari Jalur Pendaftaran
            </button>

            <!-- Results Section -->
            <div x-show="searched" x-transition class="mt-8">
                <div x-show="!hasResults" class="bg-red-50 border-l-4 border-red-500 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-red-900 mb-2">Jalur pendaftaran sudah ditutup, silakan memilih jalur pendaftaran yang masih dibuka</h3>
                        </div>
                    </div>
                </div>

                <div x-show="hasResults">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Tata Cara Pendaftaran Mahasiswa Baru</h3>
                    
                    <!-- Registration Paths -->
                    <div class="space-y-4">
                        <!-- USM Reguler -->
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold mr-3">Reguler</span>
                                        <h4 class="text-lg font-bold text-gray-900">USM Reguler - USM-Sarjana Gelombang 1</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">
                                        Untuk informasi lainnya bisa kontak hotline PMB kami di 0811-960-193
                                    </p>
                                    <p class="text-gray-600 text-sm mb-3">
                                        <strong>JIKA</strong> Kesulitan dalam mendaftar silahkan klik panduan pendaftaran di halaman : 
                                        <a href="#" class="text-blue-600 hover:underline">unpas.ac.id/pmb</a>
                                    </p>
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>5 Jan 2026 - 10 Apr 2026</span>
                                    </div>
                                    <div class="flex items-center text-sm mb-2">
                                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-600">Biaya Daftar</span>
                                        <span class="font-bold text-blue-600 ml-2">Rp. 300.000</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl">
                                        Daftar Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Prestasi Akademik -->
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-500 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold mr-3">Reguler</span>
                                        <h4 class="text-lg font-bold text-gray-900">Prestasi Akademik - PMDK-Sarjana Gelombang 1</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">
                                        Untuk informasi lainnya bisa kontak hotline PMB kami di 0811-960-193
                                    </p>
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>5 Jan 2026 - Belum Bantuan? Hubungi Kami!</span>
                                    </div>
                                    <div class="flex items-center text-sm mb-2">
                                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-600">Biaya Daftar</span>
                                        <span class="font-bold text-green-600 ml-2">Rp. 300.000</span>
                                    </div>
                                </div>
                                <div class="ml-4 flex items-center">
                                    <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-medium">
                                        <svg class="h-5 w-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Belum Bantuan? Hubungi Kami!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
function registrationSearch() {
    return {
        jenjang: '',
        prodi: '',
        sistemKuliah: '',
        searched: false,
        hasResults: false,

        searchRegistration() {
            this.searched = true;
            
            // Check if all fields are filled
            if (this.jenjang && this.prodi && this.sistemKuliah) {
                this.hasResults = true;
            } else {
                this.hasResults = false;
            }
        }
    }
}
</script>
@endpush
