@extends('registration.layout')

@section('title', $path->name)

@php $currentStep = 1; @endphp

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('registration.search') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Jalur
    </a>

    <!-- Path Header -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $path->name }}</h1>
        <div class="flex flex-wrap gap-2 mt-3">
            @if($path->system_type)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ ucfirst($path->system_type) }}
                </span>
            @endif
            @if($path->degree_level)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ $path->degree_level }}
                </span>
            @endif
        </div>
    </div>

    <!-- Path Details -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Jalur Pendaftaran</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Periode</span>
                <span class="font-medium">{{ $path->period ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Sistem Kuliah</span>
                <span class="font-medium">{{ ucfirst($path->system_type) }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Masa Pendaftaran</span>
                <span class="font-medium">{{ $path->start_date->format('d M Y') }} - {{ $path->end_date->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Gelombang</span>
                <span class="font-medium">{{ $path->wave ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Jenjang</span>
                <span class="font-medium">{{ $path->degree_level }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Biaya Daftar</span>
                <span class="font-medium text-blue-600">Rp {{ number_format($path->registration_fee, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($path->description)
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h2>
        <p class="text-gray-600">{{ $path->description }}</p>
    </div>
    @endif

    <!-- Requirements -->
    @if($path->requirements && count($path->requirements) > 0)
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Persyaratan Administrasi</h2>
        <ul class="space-y-2">
            @foreach($path->requirements as $requirement)
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-600">{{ $requirement }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Available Programs -->
    @if($studyPrograms->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Program Studi Tersedia</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($studyPrograms as $program)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <div>
                        <span class="font-medium text-gray-900">{{ $program->name }}</span>
                        <span class="text-sm text-gray-500 ml-2">({{ $program->degree_level }})</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CTA -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold">Siap untuk mendaftar?</h3>
                <p class="text-blue-100 mt-1">Klik tombol di bawah untuk melanjutkan ke formulir pendaftaran.</p>
            </div>
            <form action="{{ route('registration.path.select', $path) }}" method="POST">
                @csrf
                <button type="submit" class="w-full md:w-auto bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Lanjutkan Mendaftar →
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
