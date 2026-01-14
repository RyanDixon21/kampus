@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-600">Langkah 1 dari 6</span>
                <span class="text-sm text-gray-500">Pilih Jalur Pendaftaran</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 16.67%"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pilih Jalur Pendaftaran</h1>
            <p class="text-gray-600">Pilih jalur pendaftaran yang sesuai dengan kebutuhan Anda</p>
        </div>

        <!-- Registration Paths -->
        <form action="{{ route('registration.multi-step.paths.store') }}" method="POST">
            @csrf
            
            @if($paths->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-xl p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-yellow-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-yellow-900 mb-2">Belum Ada Jalur Pendaftaran Tersedia</h3>
                            <p class="text-yellow-700">Saat ini belum ada jalur pendaftaran yang dibuka. Silakan cek kembali nanti.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-y-4 mb-6">
                    @foreach($paths as $path)
                    <label class="block cursor-pointer">
                        <input type="radio" name="registration_path_id" value="{{ $path->id }}" 
                               class="peer sr-only" required>
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold mr-3">
                                            {{ ucfirst($path->system_type) }}
                                        </span>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $path->name }}</h3>
                                    </div>
                                    
                                    @if($path->description)
                                    <p class="text-gray-600 mb-4">{{ $path->description }}</p>
                                    @endif
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $path->start_date->format('d M Y') }} - {{ $path->end_date->format('d M Y') }}</span>
                                        </div>
                                        
                                        <div class="flex items-center text-sm">
                                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-gray-600">Biaya Daftar:</span>
                                            <span class="font-bold text-blue-600 ml-2">Rp {{ number_format($path->registration_fee, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        @if($path->quota)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span>Kuota: {{ $path->quota - $path->registrations_count }} / {{ $path->quota }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="ml-4 flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                @error('registration_path_id')
                    <div class="mb-4 text-red-600 text-sm">{{ $message }}</div>
                @enderror

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        ← Kembali ke Beranda
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl">
                        Lanjutkan →
                    </button>
                </div>
            @endif
        </form>

    </div>
</section>
@endsection
