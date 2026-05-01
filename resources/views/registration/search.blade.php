@extends('layouts.app')

@section('content')
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        @include('registration.partials.progress', ['currentStep' => 1])

        <div class="space-y-6 mt-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Jalur Pendaftaran</h1>
                <p class="mt-2 text-gray-600">Temukan jalur pendaftaran sesuai dengan pilihan program studi yang diminati.</p>
            </div>

            <!-- Flash Messages -->
            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Filter Form - HIDDEN -->
            <div class="bg-white rounded-xl shadow-sm border p-6 hidden">
                <form id="searchForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenjang</label>
                        <select name="degree_level" id="degree_level" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Jenjang</option>
                            @foreach($degreeLevels as $value => $label)
                                <option value="{{ $value }}" {{ ($filters['degree_level'] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Prodi</label>
                        <select name="study_program_id" id="study_program_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Program Studi</option>
                            @foreach($studyPrograms as $program)
                                <option value="{{ $program->id }}" {{ ($filters['study_program_id'] ?? '') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sistem Kuliah</label>
                        <select name="system_type" id="system_type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Sistem</option>
                            @foreach($systemTypes as $value => $label)
                                <option value="{{ $value }}" {{ ($filters['system_type'] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" id="searchBtn" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                            <span id="searchBtnText">Cari</span>
                            <svg id="searchSpinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results - 2 Card Layout for Mandiri & KIP -->
            <div id="resultsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $mandiriPath = $paths->first(function($path) {
                        return stripos($path->name, 'mandiri') !== false;
                    });
                    $kipPath = $paths->first(function($path) {
                        return stripos($path->name, 'kip') !== false || stripos($path->name, 'kartu indonesia pintar') !== false;
                    });
                @endphp

                @if($mandiriPath || $kipPath)
                    <!-- Mandiri Card -->
                    @if($mandiriPath)
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-500 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $mandiriPath->name }}</h3>
                            <p class="text-gray-600">{{ $mandiriPath->description }}</p>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Periode Pendaftaran</p>
                                    <p class="font-semibold">{{ $mandiriPath->start_date->format('d M Y') }} - {{ $mandiriPath->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Biaya Pendaftaran</p>
                                    <p class="font-bold text-xl text-blue-600">Rp {{ number_format($mandiriPath->registration_fee, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if($mandiriPath->wave)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Gelombang</p>
                                    <p class="font-semibold">{{ $mandiriPath->wave }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <p class="text-sm font-semibold text-blue-900 mb-2">Pilihan Kelas:</p>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Reguler (Pagi | Senin - Sabtu)</li>
                                <li>• Karyawan (Malam | Senin - Sabtu)</li>
                                <li>• Eksekutif (Pagi | Sabtu - Minggu)</li>
                            </ul>
                        </div>

                        <form action="{{ route('registration.path.select', $mandiriPath) }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-center px-6 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-all transform hover:scale-105">
                                Daftar Jalur Mandiri
                                <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- KIP Card -->
                    @if($kipPath)
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-green-500 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $kipPath->name }}</h3>
                            <p class="text-gray-600">{{ $kipPath->description }}</p>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Periode Pendaftaran</p>
                                    <p class="font-semibold">{{ $kipPath->start_date->format('d M Y') }} - {{ $kipPath->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Biaya Pendaftaran</p>
                                    <p class="font-bold text-xl text-green-600">Rp {{ number_format($kipPath->registration_fee, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if($kipPath->wave)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Gelombang</p>
                                    <p class="font-semibold">{{ $kipPath->wave }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="bg-green-50 rounded-lg p-4 mb-6">
                            <p class="text-sm font-semibold text-green-900 mb-2">Kelas:</p>
                            <p class="text-sm text-green-800">• Reguler (Pagi | Senin - Sabtu)</p>
                            <p class="text-xs text-green-700 mt-2 italic">*Otomatis masuk kelas Reguler</p>
                        </div>

                        <form action="{{ route('registration.path.select', $kipPath) }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-center px-6 py-4 bg-green-600 text-white rounded-xl font-bold text-lg hover:bg-green-700 transition-all transform hover:scale-105">
                                Daftar Jalur KIP
                                <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada jalur pendaftaran</h3>
                        <p class="mt-2 text-gray-500">Jalur pendaftaran Mandiri dan KIP belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchBtn = document.getElementById('searchBtn');
    const searchBtnText = document.getElementById('searchBtnText');
    const searchSpinner = document.getElementById('searchSpinner');
    const resultsContainer = document.getElementById('resultsContainer');
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        searchBtn.disabled = true;
        searchBtnText.textContent = 'Mencari...';
        searchSpinner.classList.remove('hidden');
        
        const formData = new FormData(searchForm);
        const params = new URLSearchParams(formData).toString();
        
        fetch(`{{ route('registration.search') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                resultsContainer.innerHTML = data.html;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultsContainer.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    Terjadi kesalahan saat mencari jalur pendaftaran. Silakan coba lagi.
                </div>
            `;
        })
        .finally(() => {
            // Reset loading state
            searchBtn.disabled = false;
            searchBtnText.textContent = 'Cari';
            searchSpinner.classList.add('hidden');
        });
    });
});
</script>
@endsection
