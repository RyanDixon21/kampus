<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'STT Pratama Adi' }}</title>
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-primary-900 via-primary-800 to-blue-900 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-primary-800/95 backdrop-blur-md shadow-lg fixed w-full top-0 z-50 border-b border-primary-700/50" 
         x-data="{ 
             mobileMenuOpen: false, 
             activeSection: 'beranda',
             init() {
                 this.updateActiveSection();
                 window.addEventListener('scroll', () => this.updateActiveSection());
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
         }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    @php
                        $logo = $settings['logo'] ?? null;
                        $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                        $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
                        $universitySlogan = $settings['university_slogan'] ?? 'Sekolah Tinggi Teknologi';
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ $universityShortName }} Logo" class="h-12 w-12 object-contain transform group-hover:scale-105 transition-transform duration-200">
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-white">{{ $universityShortName }}</h1>
                        <p class="text-xs text-blue-100">{{ $universitySlogan }}</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" 
                       @click="activeSection = 'beranda'"
                       class="text-white/90 hover:text-white transition-colors duration-200 font-medium relative py-2"
                       :class="{ 'text-white': activeSection === 'beranda' }">
                        Beranda
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300"
                              :class="activeSection === 'beranda' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                    </a>
                    <a href="{{ route('home') }}#berita" 
                       @click="activeSection = 'berita'"
                       class="text-white/90 hover:text-white transition-colors duration-200 font-medium relative py-2 group"
                       :class="{ 'text-white': activeSection === 'berita' }">
                        Berita
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300"
                              :class="activeSection === 'berita' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                    </a>
                    <a href="{{ route('home') }}#fasilitas" 
                       @click="activeSection = 'fasilitas'"
                       class="text-white/90 hover:text-white transition-colors duration-200 font-medium relative py-2 group"
                       :class="{ 'text-white': activeSection === 'fasilitas' }">
                        Fasilitas
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300"
                              :class="activeSection === 'fasilitas' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                    </a>
                    <a href="{{ route('home') }}#tendik" 
                       @click="activeSection = 'tendik'"
                       class="text-white/90 hover:text-white transition-colors duration-200 font-medium relative py-2 group"
                       :class="{ 'text-white': activeSection === 'tendik' }">
                        Tendik
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300"
                              :class="activeSection === 'tendik' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                    </a>
                    <a href="{{ route('registration.create') }}" 
                       class="ml-2 bg-white text-primary-700 px-6 py-2.5 rounded-lg hover:bg-blue-50 hover:shadow-lg transition-all duration-200 font-bold">
                        Pendaftaran
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden text-white hover:text-blue-100 focus:outline-none">
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
                 class="md:hidden pb-4 bg-primary-900/95 backdrop-blur-md border-t border-primary-700/50">
                <div class="flex flex-col space-y-1 p-4">
                    <a href="{{ route('home') }}" 
                       @click="activeSection = 'beranda'; mobileMenuOpen = false"
                       class="text-white/90 hover:text-white py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'bg-white/10 text-white': activeSection === 'beranda' }">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#berita" 
                       @click="activeSection = 'berita'; mobileMenuOpen = false"
                       class="text-white/90 hover:text-white py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'bg-white/10 text-white': activeSection === 'berita' }">
                        Berita
                    </a>
                    <a href="{{ route('home') }}#fasilitas" 
                       @click="activeSection = 'fasilitas'; mobileMenuOpen = false"
                       class="text-white/90 hover:text-white py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'bg-white/10 text-white': activeSection === 'fasilitas' }">
                        Fasilitas
                    </a>
                    <a href="{{ route('home') }}#tendik" 
                       @click="activeSection = 'tendik'; mobileMenuOpen = false"
                       class="text-white/90 hover:text-white py-3 px-4 rounded-lg transition-all duration-200 font-medium"
                       :class="{ 'bg-white/10 text-white': activeSection === 'tendik' }">
                        Tendik
                    </a>
                    <a href="{{ route('registration.create') }}" 
                       class="bg-white text-primary-700 px-6 py-3 rounded-lg hover:bg-blue-50 transition-all duration-200 font-bold text-center mt-2"
                       @click="mobileMenuOpen = false">
                        Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-primary-800 via-primary-900 to-primary-950 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        @php
                            $logo = $settings['logo'] ?? null;
                            $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                            $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
                            $universitySlogan = $settings['university_slogan'] ?? 'Sekolah Tinggi Teknologi';
                            $footerDescription = $settings['footer_description'] ?? null;
                        @endphp
                        <img src="{{ $logoUrl }}" alt="{{ $universityShortName }} Logo" class="h-12 w-12 object-contain">
                        <div>
                            <h3 class="text-lg font-bold">{{ $universityShortName }}</h3>
                            <p class="text-sm text-primary-100">{{ $universitySlogan }}</p>
                        </div>
                    </div>
                    @if($footerDescription)
                    <p class="text-primary-100 text-sm leading-relaxed">
                        {{ $footerDescription }}
                    </p>
                    @endif
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <div class="space-y-2 text-sm text-primary-100">
                        @if(isset($settings['address']))
                        <p class="flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $settings['address'] }}
                        </p>
                        @endif
                        @if(isset($settings['phone']))
                        <p class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $settings['phone'] }}
                        </p>
                        @endif
                        @if(isset($settings['email']))
                        <p class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $settings['email'] }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        @if(isset($settings['facebook_url']))
                        <a href="{{ $settings['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="bg-primary-800 hover:bg-primary-700 p-3 rounded-full transition-all duration-300 hover:scale-110">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        @endif
                        @if(isset($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="bg-primary-800 hover:bg-primary-700 p-3 rounded-full transition-all duration-300 hover:scale-110">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        @endif
                        @if(isset($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener noreferrer"
                           class="bg-primary-800 hover:bg-primary-700 p-3 rounded-full transition-all duration-300 hover:scale-110">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-primary-800 mt-8 pt-8 text-center text-sm text-primary-100">
                <p>&copy; {{ date('Y') }} {{ $settings['university_short_name'] ?? 'STT Pratama Adi' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button x-data="{ show: false }"
            x-show="show"
            @scroll.window="show = window.pageYOffset > 300"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transition-colors duration-300 z-40">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>
