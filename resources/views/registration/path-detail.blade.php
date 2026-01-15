@extends('layouts.app')

@section('content')
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        @include('registration.partials.progress', ['currentStep' => 1])

        <div class="space-y-6 mt-8">
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
                        <span class="font-medium text-gray-900">{{ $path->period ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Sistem Kuliah</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($path->system_type) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Masa Pendaftaran</span>
                        <span class="font-medium text-gray-900">{{ $path->start_date->format('d M Y') }} - {{ $path->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Gelombang</span>
                        <span class="font-medium text-gray-900">{{ $path->wave ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Jenjang</span>
                        <span class="font-medium text-gray-900">{{ $path->degree_level }}</span>
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

            <!-- Requirements & Programs - Side by Side -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Requirements -->
                @if($path->requirements && count($path->requirements) > 0)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Persyaratan Administrasi</h2>
                    <ul class="space-y-2">
                        @foreach($path->requirements as $key => $value)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-600">
                                    {{ $key }}@if($value) <span class="text-gray-400">- {{ $value }}</span>@endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Available Programs -->
                @if($studyPrograms->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Program Studi Tersedia</h2>
                    <ul class="space-y-2">
                        @foreach($studyPrograms as $program)
                            <li class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <div>
                                    <span class="font-medium text-gray-900">{{ $program->name }}</span>
                                    <span class="text-sm text-gray-500 ml-1">({{ $program->degree_level }})</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- CTA -->
            <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">Siap untuk mendaftar?</h3>
                        <p class="text-gray-600 mt-1">Klik tombol di bawah untuk melanjutkan ke formulir pendaftaran.</p>
                    </div>
                    <form action="{{ route('registration.path.select', $path) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition whitespace-nowrap">
                            Lanjutkan Mendaftar →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
