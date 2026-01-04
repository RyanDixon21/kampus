@extends('layouts.app')

@section('content')
<!-- Hero Section with Slider -->
<section id="beranda" class="relative overflow-hidden">
    @if($heroCards->count() > 0)
    <!-- Slider Container -->
    <div x-data="{ 
        currentSlide: 0,
        slides: {{ $heroCards->count() }},
        autoplay: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplay = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        stopAutoplay() {
            clearInterval(this.autoplay);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
        },
        goToSlide(index) {
            this.currentSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }" 
    class="relative"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()">
        
        @foreach($heroCards as $index => $slide)
        <div x-show="currentSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-700"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="relative bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 text-white py-40 overflow-hidden"
             style="display: none;"
             :style="currentSlide === {{ $index }} ? 'display: block;' : 'display: none;'">
            
            <!-- Background Image -->
            <div class="absolute inset-0">
                @if($slide->background_image)
                <img src="{{ asset('storage/' . $slide->background_image) }}" 
                     alt="{{ $slide->title }}" 
                     class="w-full h-full object-cover">
                <!-- Dark overlay untuk readability text -->
                <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/60 to-black/70"></div>
                @else
                <!-- Background gradient if no image -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900"></div>
                @endif
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
                <div class="absolute top-40 right-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <!-- Logo -->
                    <div class="mb-8 animate-fade-in-down">
                        @php
                            $logo = $settings['logo'] ?? null;
                            $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        @endphp
                        <img src="{{ $logoUrl }}" alt="Logo" class="h-28 w-28 mx-auto mb-6 drop-shadow-2xl">
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 animate-fade-in leading-tight" style="animation-delay: 0.1s;">
                        {{ $slide->title }}<br>
                        <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">{{ $slide->subtitle }}</span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="text-xl md:text-2xl mb-10 text-gray-200 max-w-3xl mx-auto animate-fade-in leading-relaxed" style="animation-delay: 0.2s;">
                        {{ $slide->description }}
                    </p>
                    
                    <!-- CTA Button -->
                    @if($slide->button_text && $slide->button_link)
                    <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                        <a href="{{ $slide->button_link }}" 
                           class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-12 py-5 rounded-full font-bold text-lg hover:from-blue-600 hover:to-purple-700 hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-purple-500/50">
                            {{ $slide->button_text }}
                            <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Navigation Arrows -->
        @if($heroCards->count() > 1)
        <button @click="prevSlide()" 
                class="absolute left-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-4 rounded-full transition-all duration-300 hover:scale-110 border border-white/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="nextSlide()" 
                class="absolute right-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-4 rounded-full transition-all duration-300 hover:scale-110 border border-white/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <!-- Dots Indicator -->
        <div class="absolute bottom-12 left-0 right-0 z-20 flex justify-center space-x-3">
            @foreach($heroCards as $index => $slide)
            <button @click="goToSlide({{ $index }})"
                    :class="currentSlide === {{ $index }} ? 'bg-white w-10' : 'bg-white/40 w-3'"
                    class="h-3 rounded-full transition-all duration-300 hover:bg-white"></button>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <!-- Default Hero if no slides -->
    <div class="relative bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 text-white py-40 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <div class="mb-8 animate-fade-in-down">
                    @php
                        $logo = $settings['logo'] ?? null;
                        $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        $universityName = $settings['university_name'] ?? 'Sekolah Tinggi Teknologi Pratama Adi';
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ $universityName }} Logo" class="h-28 w-28 mx-auto mb-6 drop-shadow-2xl">
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 animate-fade-in leading-tight" style="animation-delay: 0.1s;">
                    Selamat Datang di<br>
                    <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">{{ $universityName }}</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-10 text-gray-200 max-w-3xl mx-auto animate-fade-in leading-relaxed" style="animation-delay: 0.2s;">
                    Sekolah Tinggi Teknologi Terdepan untuk Masa Depan Anda
                </p>
                
                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('registration.create') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-12 py-5 rounded-full font-bold text-lg hover:from-blue-600 hover:to-purple-700 hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-purple-500/50">
                        Daftar Sekarang
                        <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<!-- Berita Section -->
<section id="berita" class="py-24 bg-primary-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold mb-4">Berita Terkini</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Informasi & Berita
            </h2>
            <p class="mt-4 text-blue-100 text-lg max-w-2xl mx-auto">
                Tetap update dengan berita dan informasi terbaru dari kampus kami
            </p>
        </div>
        
        <!-- Content with proper loading -->
        <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
            <!-- Actual Content -->
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 style="display: none;"
                 :style="loaded ? 'display: block;' : 'display: none;'">
                @if($latestNews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($latestNews as $index => $news)
                    <div class="group bg-primary-800/50 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-primary-600/50"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($news->thumbnail)
                        <div class="relative overflow-hidden h-56">
                            <img src="{{ Storage::url($news->thumbnail) }}" 
                                 alt="{{ $news->title }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-56 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center\'><svg class=\'h-16 w-16 text-white opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z\'/></svg></div>';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        @else
                        <div class="w-full h-56 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center text-blue-200 text-sm mb-3">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $news->published_at->format('d M Y') }}
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-blue-300 transition-colors duration-300">
                                {{ $news->title }}
                            </h3>
                            <p class="text-blue-100 line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit(strip_tags($news->content), 120) }}
                            </p>
                            <a href="{{ route('news.show', $news->slug) }}" class="inline-flex items-center text-blue-300 hover:text-blue-200 font-semibold transition-colors duration-300 group">
                                Baca Selengkapnya
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-blue-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-blue-100 text-lg">Belum ada berita tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas Section -->
<section id="fasilitas" class="py-24 bg-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold mb-4">Fasilitas Kampus</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Fasilitas Modern
            </h2>
            <p class="mt-4 text-green-100 text-lg max-w-2xl mx-auto">
                Fasilitas lengkap dan modern untuk mendukung pembelajaran Anda
            </p>
        </div>
        
        <!-- Content with proper loading -->
        <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
            <!-- Actual Content -->
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 style="display: none;"
                 :style="loaded ? 'display: block;' : 'display: none;'">
                @if($facilities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($facilities as $index => $facility)
                    <div class="group bg-primary-700/50 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-primary-500/50"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($facility->image)
                        <div class="relative overflow-hidden h-56">
                            <img src="{{ Storage::url($facility->image) }}" 
                                 alt="{{ $facility->name }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-56 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center\'><svg class=\'h-16 w-16 text-white opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'/></svg></div>';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        @else
                        <div class="w-full h-56 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                            <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-green-300 transition-colors duration-300">
                                {{ $facility->name }}
                            </h3>
                            <p class="text-green-100 line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit($facility->description, 120) }}
                            </p>
                            <a href="{{ route('facility.show', $facility->slug) }}" class="inline-flex items-center text-green-300 hover:text-green-200 font-semibold transition-colors duration-300 group">
                                Lihat Detail
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-green-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-green-100 text-lg">Belum ada fasilitas tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Tendik Section -->
<section id="tendik" class="py-24 bg-primary-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-purple-500 text-white rounded-full text-sm font-semibold mb-4">Tim Kami</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Tenaga Kependidikan
            </h2>
            <p class="mt-4 text-purple-100 text-lg max-w-2xl mx-auto">
                Tim profesional yang siap membantu dan membimbing Anda
            </p>
        </div>
        
        <!-- Content with proper loading -->
        <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
            <!-- Actual Content -->
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 style="display: none;"
                 :style="loaded ? 'display: block;' : 'display: none;'">
                @if($tendik->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($tendik as $index => $staff)
                    <div class="group bg-primary-800/50 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-primary-600/50"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($staff->photo)
                        <div class="relative overflow-hidden h-72">
                            <img src="{{ Storage::url($staff->photo) }}" 
                                 alt="{{ $staff->name }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-72 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center\'><svg class=\'h-24 w-24 text-white opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg></div>';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        @else
                        <div class="w-full h-72 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                            <svg class="h-24 w-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-white mb-1 group-hover:text-purple-300 transition-colors duration-300">{{ $staff->name }}</h3>
                            <p class="text-purple-300 font-semibold mb-4 text-sm">{{ $staff->position }}</p>
                            
                            <div class="space-y-2 text-sm">
                                @if($staff->email)
                                <a href="mailto:{{ $staff->email }}" 
                                   class="flex items-center justify-center text-purple-100 hover:text-purple-200 transition-colors duration-300">
                                    <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate">{{ $staff->email }}</span>
                                </a>
                                @endif
                                @if($staff->phone)
                                <a href="tel:{{ $staff->phone }}" 
                                   class="flex items-center justify-center text-purple-100 hover:text-purple-200 transition-colors duration-300">
                                    <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $staff->phone }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-purple-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-purple-100 text-lg">Informasi tenaga kependidikan akan segera tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section id="lokasi" class="py-24 bg-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold mb-4">Lokasi Kami</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Kunjungi Kampus Kami
            </h2>
            <p class="mt-4 text-red-100 text-lg max-w-2xl mx-auto">
                Temukan lokasi kampus kami dan kunjungi kami
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Campus Image -->
            <div class="relative">
                <div class="bg-primary-700 rounded-2xl overflow-hidden shadow-lg h-full min-h-[400px]">
                    @if(isset($settings['campus_image']))
                        <img src="{{ Storage::url($settings['campus_image']) }}" 
                             alt="Kampus" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                    @else
                        <!-- Placeholder Image -->
                        <div class="w-full h-full flex items-center justify-center bg-primary-700">
                            <div class="text-center">
                                <svg class="mx-auto h-24 w-24 text-primary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-primary-200 text-lg">Gambar kampus akan segera tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Map -->
            <div class="relative">
                <div class="bg-primary-700 rounded-2xl overflow-hidden shadow-lg h-full min-h-[400px]">
                    @if(isset($settings['maps_embed']))
                        <div class="w-full h-full">
                            {!! $settings['maps_embed'] !!}
                        </div>
                    @else
                        <!-- Placeholder Map -->
                        <div class="w-full h-full flex items-center justify-center bg-primary-700">
                            <div class="text-center">
                                <svg class="mx-auto h-24 w-24 text-primary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <p class="text-primary-200 text-lg">Peta lokasi akan segera tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
