@extends('registration.layout')

@section('title', 'Cari Jalur Pendaftaran')

@php $currentStep = 1; @endphp

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">Jalur Pendaftaran</h1>
        <p class="mt-2 text-gray-600">Temukan jalur pendaftaran sesuai dengan pilihan program studi yang diminati.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form method="GET" action="{{ route('registration.search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenjang</label>
                <select name="degree_level" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
                <select name="study_program_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
                <select name="system_type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Sistem</option>
                    @foreach($systemTypes as $value => $label)
                        <option value="{{ $value }}" {{ ($filters['system_type'] ?? '') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    <div class="space-y-4">
        @forelse($paths as $path)
            <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $path->name }}</h3>
                        <p class="text-gray-600 mt-1 line-clamp-2">{{ $path->description }}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            @if($path->system_type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($path->system_type) }}
                                </span>
                            @endif
                            @if($path->degree_level)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $path->degree_level }}
                                </span>
                            @endif
                            @if($path->wave)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $path->wave }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right space-y-2">
                        <div class="text-sm text-gray-500">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $path->start_date->format('d M Y') }} - {{ $path->end_date->format('d M Y') }}
                        </div>
                        <div class="text-lg font-semibold text-gray-900">
                            Rp {{ number_format($path->registration_fee, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('registration.path.detail', $path) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Daftar Sekarang
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada jalur pendaftaran</h3>
                <p class="mt-2 text-gray-500">Tidak ditemukan jalur pendaftaran yang sesuai dengan filter Anda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
