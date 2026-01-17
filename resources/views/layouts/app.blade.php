<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $logo = $settings['logo'] ?? null;
        $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
        $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
    @endphp
    <title>{{ $title ?? $universityShortName }}</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-primary-900 via-primary-800 to-blue-900 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50 transition-all duration-300 border-b-4 border-blue-500" 
         x-data="{ 
             mobileMenuOpen: false, 
             akademikDropdown: false,
             scrolled: false,
             activeSection: 'beranda',
             init() {
                 window.addEventListener('scroll', () => {
                     this.scrolled = window.scrollY > 20;
                     this.updateActiveSection();
                 });
                 this.updateActiveSection();
             },
             updateActiveSection() {
                 const sections = ['beranda', 'berita', 'fasilitas', 'tendik'];
                 const scrollPosition = window.scrollY + 100;
                 
                 for (let section of sections) {
                     const element = document.getElementById(section);
                     if (element) {
                         const offsetTop = element.offsetTop;
                         const offsetBottom = offsetTop + element.offsetHeight;
                         
                         if (scrollPosition >= offsetTop && scrollPosition < offsetBottom) {
                             this.activeSection = section;
                             break;
                         }
                     }
                 }
             }
         }"
         :class="scrolled ? 'shadow-xl' : 'shadow-md'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 group">
                    @php
                        $logo = $settings['logo'] ?? null;
                        $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
                        $universitySlogan = $settings['university_slogan'] ?? 'Sekolah Tinggi Teknologi';
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ $universityShortName }} Logo" class="h-12 w-12 sm:h-14 sm:w-14 object-contain transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                    <div class="min-w-0">
                        <h1 class="text-sm sm:text-xl font-bold text-gray-900 group-hover:text-blue-500 transition-colors truncate">{{ $universityShortName }}</h1>
                        <p class="text-xs text-gray-600 truncate">{{ $universitySlogan }}</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-1 items-center">
                    <a href="{{ route('home') }}" 
                       @click="activeSection = 'beranda'"
                       class="px-4 py-2 rounded-lg hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 font-medium relative {{ request()->routeIs('home') ? 'text-blue-500 bg-blue-50' : 'text-gray-700' }}">
                        Beranda
                    </a>
                    <a href="{{ route('about') }}" 
                       class="px-4 py-2 rounded-lg hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 font-medium {{ request()->routeIs('about') ? 'text-blue-500 bg-blue-50' : 'text-gray-700' }}">
                        Tentang
                    </a>
                    <a href="{{ route('home') }}#berita" 
                       @click="activeSection = 'berita'"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'berita' }">
                        Berita
                    </a>
                    <a href="{{ route('home') }}#fasilitas" 
                       @click="activeSection = 'fasilitas'"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'fasilitas' }">
                        Fasilitas
                    </a>
                    <a href="{{ route('home') }}#tendik" 
                       @click="activeSection = 'tendik'"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'tendik' }">
                        Tendik
                    </a>
                    
                    <!-- Akademik Dropdown -->
                    <div class="relative ml-2" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                                class="bg-blue-500 text-white px-6 py-2.5 rounded-lg hover:bg-blue-600 hover:shadow-lg transition-all duration-200 font-semibold flex items-center gap-2">
                            Akademik
                            <svg class="w-4 h-4 transition-transform duration-200" 
                                 :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click="open = false"
                             class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                             style="display: none;">
                            <div class="py-2">
                                <a href="{{ route('registration.search') }}" 
                                   class="flex items-center px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-500 transition-all duration-200 group">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-500 group-hover:scale-110 transition-all duration-200">
                                        <svg class="w-5 h-5 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold block">Pendaftaran</span>
                                        <span class="text-xs text-gray-500">Daftar mahasiswa baru</span>
                                    </div>
                                </a>
                                <a href="#" 
                                   class="flex items-center px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-600 transition-all duration-200 group">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3 group-hover:bg-green-600 group-hover:scale-110 transition-all duration-200">
                                        <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold block">KRS</span>
                                        <span class="text-xs text-gray-500">Kartu Rencana Studi</span>
                                    </div>
                                </a>
                                <a href="#" 
                                   class="flex items-center px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-purple-100 hover:text-purple-600 transition-all duration-200 group">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3 group-hover:bg-purple-600 group-hover:scale-110 transition-all duration-200">
                                        <svg class="w-5 h-5 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold block">UBK</span>
                                        <span class="text-xs text-gray-500">Ujian Berbasis Komputer</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden text-gray-700 hover:text-blue-500 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden pb-4 border-t border-gray-100 mt-2"
                 x-data="{ mobileAkademikOpen: false }">
                <div class="flex flex-col space-y-1 p-4">
                    <a href="{{ route('home') }}" 
                       @click="activeSection = 'beranda'; mobileMenuOpen = false"
                       class="hover:text-blue-500 hover:bg-blue-50 py-3 px-4 rounded-lg transition-all duration-200 font-medium {{ request()->routeIs('home') ? 'text-blue-500 bg-blue-50' : 'text-gray-700' }}">
                        Beranda
                    </a>
                    <a href="{{ route('about') }}" 
                       @click="mobileMenuOpen = false"
                       class="hover:text-blue-500 hover:bg-blue-50 py-3 px-4 rounded-lg transition-all duration-200 font-medium {{ request()->routeIs('about') ? 'text-blue-500 bg-blue-50' : 'text-gray-700' }}">
                        Tentang
                    </a>
                    <a href="{{ route('home') }}#berita" 
                       @click="activeSection = 'berita'; mobileMenuOpen = false"
                       class="text-gray-700 hover:text-blue-500 hover:bg-blue-50 py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'berita' }">
                        Berita
                    </a>
                    <a href="{{ route('home') }}#fasilitas" 
                       @click="activeSection = 'fasilitas'; mobileMenuOpen = false"
                       class="text-gray-700 hover:text-blue-500 hover:bg-blue-50 py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'fasilitas' }">
                        Fasilitas
                    </a>
                    <a href="{{ route('home') }}#tendik" 
                       @click="activeSection = 'tendik'; mobileMenuOpen = false"
                       class="text-gray-700 hover:text-blue-500 hover:bg-blue-50 py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'text-blue-500 bg-blue-50': activeSection === 'tendik' }">
                        Tendik
                    </a>
                    
                    <!-- Akademik Dropdown Mobile -->
                    <div class="mt-2">
                        <button @click="mobileAkademikOpen = !mobileAkademikOpen"
                                class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-200 font-semibold flex items-center justify-between">
                            <span>Akademik</span>
                            <svg class="w-4 h-4 transition-transform duration-200" 
                                 :class="{ 'rotate-180': mobileAkademikOpen }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Mobile Dropdown Items -->
                        <div x-show="mobileAkademikOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-2 space-y-1 bg-gray-50 rounded-lg p-2"
                             style="display: none;">
                            <a href="{{ route('registration.search') }}" 
                               @click="mobileMenuOpen = false"
                               class="flex items-center text-gray-700 hover:text-blue-500 hover:bg-white py-3 px-4 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span class="font-medium">Pendaftaran</span>
                            </a>
                            <a href="#" 
                               @click="mobileMenuOpen = false"
                               class="flex items-center text-gray-700 hover:text-blue-500 hover:bg-white py-3 px-4 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="font-medium">KRS</span>
                            </a>
                            <a href="#" 
                               @click="mobileMenuOpen = false"
                               class="flex items-center text-gray-700 hover:text-blue-500 hover:bg-white py-3 px-4 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <span class="font-medium">UBK</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16 mt-20 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About Column -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        @php
                            $logo = $settings['logo'] ?? null;
                            $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                            $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
                            $universitySlogan = $settings['university_slogan'] ?? 'Sekolah Tinggi Teknologi';
                            $footerDescription = $settings['footer_description'] ?? null;
                        @endphp
                        <img src="{{ $logoUrl }}" alt="{{ $universityShortName }} Logo" class="h-16 w-16 object-contain">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $universityShortName }}</h3>
                            <p class="text-sm text-gray-400">{{ $universitySlogan }}</p>
                        </div>
                    </div>
                    @if($footerDescription)
                    <p class="text-gray-400 leading-relaxed mb-6">
                        {{ $footerDescription }}
                    </p>
                    @else
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Institusi pendidikan tinggi yang berkomitmen menghasilkan lulusan berkualitas dan siap bersaing di era digital.
                    </p>
                    @endif
                    
                    <!-- Social Media -->
                    <div class="flex space-x-3">
                        @if(isset($settings['facebook_url']))
                        <a href="{{ $settings['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        @endif
                        @if(isset($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-gray-800 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        @endif
                        @if(isset($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-300 transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Beranda
                        </a></li>
                        <li><a href="{{ route('home') }}#berita" class="hover:text-blue-300 transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Berita
                        </a></li>
                        <li><a href="{{ route('home') }}#fasilitas" class="hover:text-blue-300 transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Fasilitas
                        </a></li>
                        <li><a href="{{ route('home') }}#tendik" class="hover:text-blue-300 transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Tendik
                        </a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        @if(isset($settings['address']))
                        <li class="flex items-start group">
                            <svg class="h-5 w-5 mr-3 flex-shrink-0 mt-0.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm">{{ $settings['address'] }}</span>
                        </li>
                        @endif
                        @if(isset($settings['phone']))
                        <li class="flex items-center group">
                            <svg class="h-5 w-5 mr-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ $settings['phone'] }}" class="text-sm hover:text-blue-300 transition-colors">{{ $settings['phone'] }}</a>
                        </li>
                        @endif
                        @if(isset($settings['email']))
                        <li class="flex items-center group">
                            <svg class="h-5 w-5 mr-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $settings['email'] }}" class="text-sm hover:text-blue-300 transition-colors">{{ $settings['email'] }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500 mb-4 md:mb-0">
                    &copy; {{ date('Y') }} {{ $settings['university_short_name'] ?? 'STT Pratama Adi' }}. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-blue-300 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-300 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
