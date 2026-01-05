@extends('layouts.app')

@section('content')
<!-- News Grid Section -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Decorative Shapes -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full -translate-y-1/2 translate-x-1/2 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-200 rounded-full translate-y-1/2 -translate-x-1/2 opacity-50"></div>
    <div class="absolute top-1/2 left-1/4 w-32 h-32 border-4 border-blue-300 rounded-lg rotate-45 opacity-30"></div>
    <div class="absolute top-20 right-1/4 w-24 h-24 bg-blue-50 rounded-full opacity-70"></div>
    <div class="absolute bottom-20 right-1/3 w-40 h-40 border-4 border-blue-200 rounded-full opacity-40"></div>
    
    <!-- Dot Pattern Background -->
    <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(circle, #1e40af 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                {{ $settings['news_section_title'] ?? 'Berita Terkini' }}
            </h2>
            <p class="text-blue-600 text-lg font-medium">{{ $settings['news_section_description'] ?? 'Informasi terkini terkait Civitas Academica' }}</p>
        </div>
        
        @if($allNews->count() > 0)
        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($allNews as $index => $news)
            <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                <a href="{{ route('news.show', $news->slug) }}" class="block">
                    @if($news->thumbnail)
                    <div class="relative overflow-hidden h-56">
                        <img src="{{ Storage::url($news->thumbnail) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        <!-- Category Badge -->
                        @if($news->category)
                        <div class="absolute top-4 right-4">
                            <span class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-lg">
                                {{ $news->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="w-full h-56 bg-blue-500 flex items-center justify-center">
                        <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $news->title }}
                        </h3>
                        <p class="text-gray-600 text-sm uppercase tracking-wide font-semibold">
                            BACA SELENGKAPNYA
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $allNews->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <p class="text-gray-600 text-lg">Belum ada berita tersedia.</p>
        </div>
        @endif
    </div>
</section>
@endsection
