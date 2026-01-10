@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in-down">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Tentang Kami
            </h1>
            <p class="text-xl text-blue-200 max-w-2xl mx-auto">
                {{ $settings['university_name'] ?? 'STT Pratama Adi' }}
            </p>
        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
@if($tentang->count() > 0)
<section class="relative py-16 bg-white overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @foreach($tentang as $item)
        <div class="mb-12 animate-fade-in">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">{{ $item->title }}</h2>
            <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                {!! $item->content !!}
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Visi Section -->
@if($visi->count() > 0)
<section class="relative py-16 bg-gray-50 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @foreach($visi as $item)
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 border-t-4 border-blue-500 animate-fade-in-up">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $item->title }}</h2>
            </div>
            <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                {!! $item->content !!}
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Misi Section -->
@if($misi->count() > 0)
<section class="relative py-16 bg-white overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @foreach($misi as $item)
        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-2xl shadow-2xl p-8 md:p-12 border-t-4 border-green-500 animate-fade-in-up">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $item->title }}</h2>
            </div>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $item->content !!}
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Sejarah Section -->
@if($sejarah->count() > 0)
<section class="relative py-16 bg-gray-50 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @foreach($sejarah as $item)
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 border-t-4 border-purple-500 animate-fade-in-up">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $item->title }}</h2>
            </div>
            <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                {!! $item->content !!}
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Empty State -->
@if($tentang->count() == 0 && $visi->count() == 0 && $misi->count() == 0 && $sejarah->count() == 0)
<section class="relative py-24 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Konten Belum Tersedia</h3>
        <p class="text-gray-600">Informasi tentang kami akan segera ditambahkan.</p>
    </div>
</section>
@endif
@endsection
