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
             class="relative text-white overflow-hidden min-h-[60vh]"
             style="display: none;"
             :style="currentSlide === {{ $index }} ? 'display: flex;' : 'display: none;'">
            
            <!-- Background Layer -->
            <div class="absolute inset-0 z-0">
                @if($slide->background_image)
                    <img src="{{ Storage::url($slide->background_image) }}" 
                         alt="{{ $slide->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70"></div>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900"></div>
                @endif
                <!-- Animated Overlay Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>
                </div>
            </div>
            
            <!-- Content Container -->
            <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">
                <div class="text-center">
                    
                    <!-- Logo (Optional) -->
                    @if($slide->show_logo)
                    <div class="mb-6 animate-fade-in-down">
                        @php
                            $logo = $settings['logo'] ?? null;
                            $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        @endphp
                        <img src="{{ $logoUrl }}" 
                             alt="Logo" 
                             class="h-24 w-24 md:h-32 md:w-32 mx-auto drop-shadow-2xl"
                             onerror="this.style.display='none';">
                    </div>
                    @endif
                    
                    <!-- Title -->
                    <div class="mb-6 animate-fade-in" style="animation-delay: 0.1s;">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight mb-4">
                            {{ $slide->title }}
                        </h1>
                        @if($slide->subtitle)
                        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-blue-300">
                            {{ $slide->subtitle }}
                        </h2>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    @if($slide->description)
                    <p class="text-lg sm:text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto leading-relaxed mb-10 animate-fade-in" style="animation-delay: 0.2s;">
                        {{ $slide->description }}
                    </p>
                    @endif
                    
                    <!-- CTA Button -->
                    @if($slide->button_text && $slide->button_link)
                    <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                        <a href="{{ $slide->button_link }}" 
                           class="inline-flex items-center gap-3 bg-blue-500 hover:bg-blue-700 text-white px-10 py-4 md:px-12 md:py-5 rounded-full font-bold text-base md:text-lg transition-all duration-300 shadow-2xl hover:scale-105">
                            {{ $slide->button_text }}
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                class="absolute left-4 md:left-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-3 md:p-4 rounded-full transition-all duration-300 hover:scale-110 border border-white/20">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="nextSlide()" 
                class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-3 md:p-4 rounded-full transition-all duration-300 hover:scale-110 border border-white/20">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <!-- Dots Indicator -->
        <div class="absolute bottom-8 md:bottom-12 left-0 right-0 z-20 flex justify-center gap-3">
            @foreach($heroCards as $index => $slide)
            <button @click="goToSlide({{ $index }})"
                    :class="currentSlide === {{ $index }} ? 'bg-white w-10' : 'bg-white/40 w-3'"
                    class="h-3 rounded-full transition-all duration-300 hover:bg-white"
                    aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <!-- Default Hero if no slides -->
    <div class="relative text-white overflow-hidden min-h-[60vh]">
        
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900"></div>
            <!-- Animated Overlay Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>
            </div>
        </div>
        
        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">
            <div class="text-center">
                
                <!-- Logo -->
                @if(($settings['show_hero_logo'] ?? true))
                <div class="mb-6 animate-fade-in-down">
                    @php
                        $logo = $settings['logo'] ?? null;
                        $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        $universityName = $settings['university_name'] ?? 'Sekolah Tinggi Teknologi Pratama Adi';
                    @endphp
                    <img src="{{ $logoUrl }}" 
                         alt="{{ $universityName }} Logo" 
                         class="h-24 w-24 md:h-32 md:w-32 mx-auto drop-shadow-2xl"
                         onerror="this.style.display='none';">
                </div>
                @endif
                
                <!-- Title -->
                <div class="mb-6 animate-fade-in" style="animation-delay: 0.1s;">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight mb-4">
                        Selamat Datang di
                    </h1>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-blue-300">
                        {{ $settings['university_name'] ?? 'Sekolah Tinggi Teknologi Pratama Adi' }}
                    </h2>
                </div>
                
                <!-- Description -->
                <p class="text-lg sm:text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto leading-relaxed mb-10 animate-fade-in" style="animation-delay: 0.2s;">
                    {{ $settings['hero_description'] ?? 'Sekolah Tinggi Teknologi Terdepan untuk Masa Depan Anda' }}
                </p>
                
                <!-- CTA Button -->
                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('registration.create') }}" 
                       class="inline-flex items-center gap-3 bg-blue-500 hover:bg-blue-700 text-white px-10 py-4 md:px-12 md:py-5 rounded-full font-bold text-base md:text-lg transition-all duration-300 shadow-2xl hover:scale-105">
                        Daftar Sekarang
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    @endif
</section>

<!-- Why Choose Us Section -->
<section class="relative py-20 bg-gray-50 overflow-hidden">
    <!-- Subtle Grid Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                {{ $settings['why_choose_us_title'] ?? 'Mengapa Memilih Kami?' }}
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                {{ $settings['why_choose_us_description'] ?? 'Komitmen kami untuk memberikan pendidikan berkualitas tinggi dengan fasilitas modern' }}
            </p>
        </div>
        
        @if($whyChooseUs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($whyChooseUs as $item)
            @php
                $colorMap = [
                    'blue' => ['bg' => '#3b82f6', 'border' => '#3b82f6'],
                    'green' => ['bg' => '#22c55e', 'border' => '#22c55e'],
                    'purple' => ['bg' => '#a855f7', 'border' => '#a855f7'],
                    'red' => ['bg' => '#ef4444', 'border' => '#ef4444'],
                    'yellow' => ['bg' => '#eab308', 'border' => '#eab308'],
                    'indigo' => ['bg' => '#6366f1', 'border' => '#6366f1'],
                    'pink' => ['bg' => '#ec4899', 'border' => '#ec4899'],
                    'orange' => ['bg' => '#f97316', 'border' => '#f97316'],
                ];
                $colors = $colorMap[$item->color] ?? $colorMap['blue'];
            @endphp
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4" style="border-color: {{ $colors['border'] }};">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg" style="background-color: {{ $colors['bg'] }};">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($item->icon == 'book-open')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        @elseif($item->icon == 'academic-cap')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        @elseif($item->icon == 'briefcase')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        @elseif($item->icon == 'users')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        @elseif($item->icon == 'building-library')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        @elseif($item->icon == 'beaker')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        @elseif($item->icon == 'computer-desktop')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        @elseif($item->icon == 'light-bulb')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        @elseif($item->icon == 'trophy')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        @elseif($item->icon == 'star')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        @elseif($item->icon == 'rocket-launch')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        @elseif($item->icon == 'shield-check')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        @elseif($item->icon == 'chart-bar')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        @elseif($item->icon == 'globe-alt')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        @elseif($item->icon == 'cog')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        @endif
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Berita Section -->
<section id="berita" class="relative py-20 bg-white overflow-hidden">
    <!-- Dot Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                {{ $settings['news_section_title'] ?? 'Berita Terkini' }}
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ $settings['news_section_description'] ?? 'Informasi terkini terkait Civitas Academica' }}</p>
        </div>
        
        @if($latestNews->count() > 0)
        <!-- Grid Layout: 1 Large + 4 Small -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Large Featured News (Left Side) -->
            @php $featuredNews = $latestNews->first(); @endphp
            <div class="lg:col-span-2 lg:row-span-2">
                <a href="{{ route('news.show', $featuredNews->slug) }}" class="group block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 h-full flex flex-col">
                    @if($featuredNews->thumbnail)
                    <div class="relative overflow-hidden h-80 lg:h-96 flex-shrink-0">
                        <img src="{{ Storage::url($featuredNews->thumbnail) }}" 
                             alt="{{ $featuredNews->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent pointer-events-none"></div>
                        <!-- Category Badge -->
                        @if($featuredNews->category)
                        <div class="absolute top-6 left-6">
                            <span class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg">
                                {{ $featuredNews->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="h-80 lg:h-96 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0">
                        <svg class="h-24 w-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="p-8 flex-grow flex flex-col">
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $featuredNews->title }}
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-2 flex-grow">
                            {{ Str::limit(strip_tags($featuredNews->content), 150) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-blue-600">
                            <span>{{ $featuredNews->published_at->format('d M Y') }}</span>
                            <span class="font-semibold uppercase tracking-wide">Baca Selengkapnya →</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Small News Grid (Right Side - 2x2) -->
            @foreach($latestNews->skip(1)->take(4) as $index => $news)
            <div class="lg:col-span-1">
                <a href="{{ route('news.show', $news->slug) }}" class="group block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 h-full flex flex-col">
                    @if($news->thumbnail)
                    <div class="relative overflow-hidden h-48 flex-shrink-0">
                        <img src="{{ Storage::url($news->thumbnail) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent pointer-events-none"></div>
                        <!-- Category Badge -->
                        @if($news->category)
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-lg">
                                {{ $news->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0">
                        <svg class="h-12 w-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="p-5 flex-grow flex flex-col">
                        <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300 flex-grow">
                            {{ $news->title }}
                        </h3>
                        <div class="flex items-center justify-between text-xs text-blue-600 mt-2">
                            <span>{{ $news->published_at->format('d M Y') }}</span>
                            <span class="font-semibold uppercase">Baca →</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold text-base transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                LIHAT SELENGKAPNYA
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @else
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <p class="text-gray-600 text-lg">Belum ada berita tersedia.</p>
        </div>
        @endif
    </div>
</section>

<!-- Fasilitas Section -->
<section id="fasilitas" class="relative py-24 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 overflow-hidden">
    <!-- Tech Pattern Background -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="tech-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <!-- Circuit lines -->
                    <path d="M0 50 L25 50 L25 25 L50 25 L50 50 L75 50 L75 75 L100 75" stroke="white" fill="none" stroke-width="1"/>
                    <path d="M50 0 L50 25 M50 50 L50 75 M50 75 L50 100" stroke="white" fill="none" stroke-width="1"/>
                    <!-- Dots -->
                    <circle cx="25" cy="50" r="2" fill="white"/>
                    <circle cx="50" cy="25" r="2" fill="white"/>
                    <circle cx="75" cy="75" r="2" fill="white"/>
                    <circle cx="50" cy="50" r="2" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#tech-pattern)"/>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                {{ $settings['facilities_section_title'] ?? 'Fasilitas Modern' }}
            </h2>
            @if(isset($settings['facilities_section_description']) && $settings['facilities_section_description'])
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">{{ $settings['facilities_section_description'] }}</p>
            @else
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">Fasilitas lengkap untuk mendukung proses pembelajaran yang optimal</p>
            @endif
        </div>
        
        @if($facilities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($facilities as $index => $facility)
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($facility->image)
                        <div class="relative overflow-hidden h-56">
                            <img src="{{ Storage::url($facility->image) }}" 
                                 alt="{{ $facility->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.style.display='none';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                        </div>
                        @else
                        <div class="w-full h-56 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        @endif
                        <div class="p-6 bg-white">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                                {{ $facility->name }}
                            </h3>
                            <p class="text-gray-600 mb-4 leading-relaxed" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit(strip_tags($facility->description), 120) }}
                            </p>
                            <a href="{{ route('facility.show', $facility->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-300">
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
            <svg class="mx-auto h-24 w-24 text-blue-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <p class="text-blue-100 text-lg">Belum ada fasilitas tersedia.</p>
        </div>
        @endif
    </div>
</section>

<!-- Tendik Section -->
<section id="tendik" class="relative py-24 bg-gray-50 overflow-hidden">
    <!-- Hexagon Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hexagon" x="0" y="0" width="56" height="100" patternUnits="userSpaceOnUse">
                    <path d="M28 0 L56 25 L56 75 L28 100 L0 75 L0 25 Z" stroke="#3b82f6" fill="none" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hexagon)"/>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Tenaga Kependidikan
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Tim profesional yang siap melayani dan mendukung kegiatan akademik Anda</p>
        </div>
        
        @if($tendik->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($tendik as $index => $staff)
                    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 p-8"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                        <!-- Circular Photo with Ring -->
                        <div class="relative mb-6 flex justify-center">
                            <div class="relative">
                                <!-- Decorative Ring -->
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 opacity-20 group-hover:opacity-30 transition-opacity duration-300 transform scale-110"></div>
                                
                                @if($staff->photo)
                                <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-xl group-hover:border-blue-100 transition-all duration-300">
                                    <img src="{{ Storage::url($staff->photo) }}" 
                                         alt="{{ $staff->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center\'><svg class=\'h-20 w-20 text-white opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg></div>';">
                                </div>
                                @else
                                <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 rounded-full border-4 border-white shadow-lg"></div>
                            </div>
                        </div>
                        
                        <!-- Info Section -->
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors duration-300">
                                {{ $staff->name }}
                            </h3>
                            
                            @if($staff->nidn)
                            <p class="text-gray-500 text-xs mb-2 font-medium">NIDN: {{ $staff->nidn }}</p>
                            @endif
                            
                            <div class="inline-block bg-blue-50 px-4 py-1.5 rounded-full mb-4">
                                <p class="text-blue-700 font-semibold text-sm">{{ $staff->position }}</p>
                            </div>
                            
                            <!-- Contact Info -->
                            <div class="space-y-2.5 text-sm pt-4 border-t border-gray-100">
                                @if($staff->email)
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $staff->email }}" 
                                   target="_blank"
                                   class="flex items-center justify-center text-gray-600 hover:text-blue-600 transition-colors duration-300 group/email">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-2 group-hover/email:bg-blue-100 transition-colors duration-300">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="truncate font-medium">{{ $staff->email }}</span>
                                </a>
                                @endif
                                
                                @if($staff->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $staff->phone) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center text-gray-600 hover:text-green-600 transition-colors duration-300 group/phone">
                                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center mr-2 group-hover/phone:bg-green-100 transition-colors duration-300">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $staff->phone }}</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        @else
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p class="text-gray-600 text-lg">Informasi tenaga kependidikan akan segera tersedia.</p>
        </div>
        @endif
    </div>
</section>

<!-- Location Section -->
<section id="lokasi" class="relative py-24 bg-white overflow-hidden">
    <!-- Wave Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="wave" x="0" y="0" width="100" height="50" patternUnits="userSpaceOnUse">
                    <path d="M0 25 Q 25 15, 50 25 T 100 25" stroke="#3b82f6" fill="none" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#wave)"/>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Kunjungi Kampus Kami
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Temukan lokasi kampus kami dengan mudah dan lihat suasana kampus yang nyaman</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Campus Images Collage -->
            <div class="relative" x-data="{ 
                showModal: false, 
                currentImage: '',
                openImage(src) {
                    this.currentImage = src;
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },
                closeModal() {
                    this.showModal = false;
                    document.body.style.overflow = 'auto';
                }
            }">
                @php
                    $campusImages = $settings['campus_images'] ?? [];
                    if (is_string($campusImages)) {
                        $campusImages = json_decode($campusImages, true) ?? [];
                    }
                    $imageCount = count($campusImages);
                @endphp
                
                @if($imageCount > 0)
                    @if($imageCount == 1)
                        <!-- Single Image -->
                        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl h-full min-h-[400px] border-4 border-white/20 cursor-pointer group"
                             @click="openImage('{{ Storage::url($campusImages[0]) }}')">
                            <img src="{{ Storage::url($campusImages[0]) }}" 
                                 alt="Kampus" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none';">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </div>
                    @elseif($imageCount == 2)
                        <!-- 2 Images Grid -->
                        <div class="grid grid-cols-2 h-full min-h-[400px] bg-white rounded-2xl overflow-hidden shadow-2xl border-4 border-white/20">
                            @foreach($campusImages as $image)
                            <div class="relative overflow-hidden cursor-pointer group"
                                 @click="openImage('{{ Storage::url($image) }}')">
                                <img src="{{ Storage::url($image) }}" 
                                     alt="Kampus" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     onerror="this.style.display='none';">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @elseif($imageCount == 3)
                        <!-- 3 Images Grid (1 large + 2 small) -->
                        <div class="grid grid-cols-2 h-full min-h-[400px] bg-white rounded-2xl overflow-hidden shadow-2xl border-4 border-white/20">
                            <div class="row-span-2 relative overflow-hidden cursor-pointer group"
                                 @click="openImage('{{ Storage::url($campusImages[0]) }}')">
                                <img src="{{ Storage::url($campusImages[0]) }}" 
                                     alt="Kampus" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     onerror="this.style.display='none';">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                            @foreach(array_slice($campusImages, 1) as $image)
                            <div class="relative overflow-hidden cursor-pointer group"
                                 @click="openImage('{{ Storage::url($image) }}')">
                                <img src="{{ Storage::url($image) }}" 
                                     alt="Kampus" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     onerror="this.style.display='none';">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- 4 Images Grid (2x2) -->
                        <div class="grid grid-cols-2 h-full min-h-[400px] bg-white rounded-2xl overflow-hidden shadow-2xl border-4 border-white/20">
                            @foreach(array_slice($campusImages, 0, 4) as $image)
                            <div class="relative overflow-hidden cursor-pointer group"
                                 @click="openImage('{{ Storage::url($image) }}')">
                                <img src="{{ Storage::url($image) }}" 
                                     alt="Kampus" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     onerror="this.style.display='none';">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <!-- Placeholder Image -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-2xl h-full min-h-[400px] border-4 border-white/20">
                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                            <div class="text-center">
                                <svg class="mx-auto h-24 w-24 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-blue-600 text-lg font-medium">Gambar kampus akan segera tersedia</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Image Modal/Lightbox -->
                <div x-show="showModal" 
                     x-cloak
                     @click="closeModal()"
                     @keydown.escape.window="closeModal()"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <button @click="closeModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <img :src="currentImage" 
                         alt="Kampus" 
                         class="max-w-full max-h-full object-contain rounded-lg shadow-2xl"
                         @click.stop>
                </div>
            </div>

            <!-- Map -->
            <div class="relative">
                <div class="bg-white rounded-2xl overflow-hidden shadow-2xl h-full min-h-[400px] border-4 border-white/20">
                    @if(isset($settings['maps_embed']))
                        <div class="w-full h-full">
                            {!! $settings['maps_embed'] !!}
                        </div>
                    @else
                        <!-- Placeholder Map -->
                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                            <div class="text-center">
                                <svg class="mx-auto h-24 w-24 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <p class="text-blue-600 text-lg font-medium">Peta lokasi akan segera tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
