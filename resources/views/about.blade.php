@extends('layouts.app')

@section('content')
<!-- Sejarah Section -->
<section class="py-16 bg-white relative overflow-hidden">
    <!-- Tech Pattern Background -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="tech-pattern" x="0" y="0" width="120" height="120" patternUnits="userSpaceOnUse">
                    <!-- Circuit lines -->
                    <path d="M0 60 L30 60 L30 30 L60 30 L60 60 L90 60 L90 90 L120 90" stroke="#3b82f6" fill="none" stroke-width="1.5"/>
                    <path d="M60 0 L60 30 M60 60 L60 90 M60 90 L60 120" stroke="#3b82f6" fill="none" stroke-width="1.5"/>
                    <!-- Dots/nodes -->
                    <circle cx="30" cy="60" r="3" fill="#3b82f6"/>
                    <circle cx="60" cy="30" r="3" fill="#3b82f6"/>
                    <circle cx="90" cy="90" r="3" fill="#3b82f6"/>
                    <circle cx="60" cy="60" r="4" fill="#3b82f6"/>
                    <!-- Small circles -->
                    <circle cx="15" cy="15" r="8" stroke="#3b82f6" fill="none" stroke-width="1"/>
                    <circle cx="105" cy="105" r="8" stroke="#3b82f6" fill="none" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#tech-pattern)"/>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-8">
            @if($sejarah->count() > 0 && $sejarah->first()->title)
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">{{ $sejarah->first()->title }}</h2>
            @else
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Sejarah Kami</h2>
            @endif
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>
        
        <div class="bg-gray-50 rounded-2xl shadow-lg p-8 md:p-12">
            @php
                $logo = $settings['logo'] ?? null;
                $logoUrl = $logo ? Storage::url($logo) : asset('logo.png');
                $universityName = $settings['university_name'] ?? 'Sekolah Tinggi Teknologi Pratama Adi';
            @endphp
            
            <!-- Logo Center -->
            <div class="flex justify-center mb-10">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
                    <img src="{{ $logoUrl }}" 
                         alt="{{ $universityName }} Logo" 
                         class="relative h-48 w-48 md:h-64 md:w-64 object-contain drop-shadow-2xl transform hover:scale-105 transition-transform duration-300"
                         onerror="this.style.display='none';">
                </div>
            </div>
            
            <div class="prose prose-xl max-w-none">
                @if($sejarah->count() > 0)
                    @foreach($sejarah as $item)
                    <div class="mb-6">
                        <div class="text-gray-700 text-lg leading-relaxed text-justify" style="word-break: break-word; overflow-wrap: break-word;">
                            {!! nl2br(e($item->content)) !!}
                        </div>
                    </div>
                    @endforeach
                @else
                <p class="text-gray-700 text-lg leading-relaxed mb-6 text-justify" style="word-break: break-word;">
                    {{ $settings['history'] ?? 'Sekolah Tinggi Teknologi Pratama Adi didirikan dengan visi untuk menjadi institusi pendidikan tinggi yang unggul dalam bidang teknologi. Sejak awal berdirinya, kami berkomitmen untuk menghasilkan lulusan yang tidak hanya kompeten secara teknis, tetapi juga memiliki karakter yang kuat dan siap menghadapi tantangan di era digital.' }}
                </p>
                <p class="text-gray-700 text-lg leading-relaxed text-justify" style="word-break: break-word;">
                    Dengan dukungan tenaga pengajar yang berpengalaman dan fasilitas yang modern, kami terus berinovasi dalam metode pembelajaran untuk memastikan mahasiswa mendapatkan pendidikan terbaik yang relevan dengan kebutuhan industri.
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Visi -->
            <div class="bg-white rounded-2xl p-8 border-t-4 border-blue-600 shadow-lg flex flex-col h-full">
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi</h2>
                </div>
                <div class="flex-grow">
                    @if($visi->count() > 0 && $visi->first()->content)
                    <div class="text-gray-700 text-lg leading-relaxed text-justify" style="word-break: break-word;">
                        {!! nl2br(e($visi->first()->content)) !!}
                    </div>
                    @else
                    <p class="text-gray-700 text-lg leading-relaxed text-justify" style="word-break: break-word;">
                        {{ $settings['vision'] ?? 'Menjadi institusi pendidikan tinggi teknologi yang unggul, inovatif, dan berdaya saing global dalam menghasilkan lulusan yang profesional dan berakhlak mulia.' }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- Misi -->
            <div class="bg-white rounded-2xl p-8 border-t-4 border-blue-600 shadow-lg flex flex-col h-full">
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Misi</h2>
                </div>
                <div class="flex-grow">
                    @if($misi->count() > 0)
                    <ul class="space-y-3 text-gray-700 text-lg">
                        @php
                            $misiContent = $misi->first()->content;
                            $misiList = array_filter(explode("\n", $misiContent));
                        @endphp
                        @foreach($misiList as $item)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-justify">{{ trim($item) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <ul class="space-y-3 text-gray-700 text-lg">
                        @php
                            $missions = $settings['mission'] ?? [
                                'Menyelenggarakan pendidikan tinggi teknologi yang berkualitas',
                                'Mengembangkan penelitian dan pengabdian kepada masyarakat',
                                'Membangun kerjasama dengan industri dan institusi lain',
                                'Menciptakan lingkungan akademik yang kondusif'
                            ];
                            if(is_string($missions)) {
                                $missions = explode("\n", $missions);
                            }
                        @endphp
                        @foreach($missions as $mission)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-justify">{{ trim($mission) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nilai-Nilai Section -->
<section class="py-20 bg-blue-600 relative overflow-hidden">
    <!-- Tech Pattern Background -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="tech-pattern-nilai" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
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
            <rect width="100%" height="100%" fill="url(#tech-pattern-nilai)"/>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                {{ $nilaiHeader->title ?? 'Nilai-Nilai Kami' }}
            </h2>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                {{ $nilaiHeader->content ?? 'Prinsip yang menjadi landasan dalam setiap kegiatan kami' }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @if($nilaiNilai->count() > 0)
                @foreach($nilaiNilai as $index => $nilai)
                @php
                    // Get icon from database or fallback to order-based icon
                    $iconName = $nilai->icon ?? match($nilai->order) {
                        1 => 'shield',
                        2 => 'lightbulb',
                        3 => 'star',
                        default => 'users',
                    };
                    
                    // Map icon name to SVG path
                    $iconPath = match($iconName) {
                        'shield' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'lightbulb' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                        'star' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                        'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                        'heart' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                        'rocket' => 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122',
                        'trophy' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                        default => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    };
                @endphp
                <div class="text-center group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $nilai->title }}</h3>
                    <p class="text-gray-600 text-justify">{{ $nilai->content }}</p>
                </div>
                @endforeach
            @else
            <!-- Default values if no data -->
            <div class="text-center group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Integritas</h3>
                <p class="text-gray-600">Menjunjung tinggi kejujuran dan etika dalam setiap tindakan</p>
            </div>
            <div class="text-center group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h3>
                <p class="text-gray-600">Mendorong kreativitas dan pemikiran yang out of the box</p>
            </div>
            <div class="text-center group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Keunggulan</h3>
                <p class="text-gray-600">Berkomitmen untuk selalu memberikan yang terbaik</p>
            </div>
            <div class="text-center group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kolaborasi</h3>
                <p class="text-gray-600">Membangun kerjasama yang saling menguntungkan</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Akreditasi & Penghargaan Section -->
<section class="py-20 bg-gray-50 relative overflow-hidden">
    <!-- Dot Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                {{ $akreditasiHeader->title ?? 'Akreditasi & Penghargaan' }}
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                {{ $akreditasiHeader->content ?? 'Pengakuan atas komitmen kami terhadap kualitas pendidikan' }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if($akreditasiItems->count() > 0)
                @foreach($akreditasiItems as $index => $akreditasi)
                @php
                    // Get icon from database or fallback to order-based icon
                    $iconName = $akreditasi->icon ?? match($akreditasi->order) {
                        1 => 'badge',
                        2 => 'shield',
                        default => 'sparkles',
                    };
                    
                    // Map icon name to SVG path
                    $iconPath = match($iconName) {
                        'badge' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                        'shield' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'sparkles' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                        'award' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                        'check-circle' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'academic-cap' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
                        'star-badge' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                        default => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                    };
                @endphp
                <div class="bg-white rounded-2xl p-8 shadow-lg text-center border-t-4 border-blue-600">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $akreditasi->title }}</h3>
                    <p class="text-gray-600 text-justify">{{ $akreditasi->content }}</p>
                </div>
                @endforeach
            @else
            <!-- Default values if no data -->
            <div class="bg-white rounded-2xl p-8 shadow-lg text-center border-t-4 border-blue-600">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Akreditasi BAN-PT</h3>
                <p class="text-gray-600">Terakreditasi dengan peringkat {{ $accreditation }}</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-lg text-center border-t-4 border-blue-600">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sertifikasi ISO</h3>
                <p class="text-gray-600">Sistem manajemen mutu terjamin</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-lg text-center border-t-4 border-blue-600">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Penghargaan</h3>
                <p class="text-gray-600">Berbagai prestasi di tingkat nasional</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white relative overflow-hidden">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">
            {{ $cta->title ?? 'Siap Bergabung Bersama Kami?' }}
        </h2>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
            {{ $cta->content ?? 'Wujudkan impian Anda untuk menjadi profesional di bidang teknologi' }}
        </p>
        <a href="{{ $ctaButton->content ?? route('registration.create') }}" 
           class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 md:px-12 md:py-5 rounded-full font-bold text-base md:text-lg transition-all duration-300 shadow-lg hover:scale-105">
            {{ $ctaButton->title ?? 'Daftar Sekarang' }}
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>

@endsection
