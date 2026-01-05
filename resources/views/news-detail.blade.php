@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<section class="bg-primary-900 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-blue-200">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('news.index') }}" class="hover:text-white transition-colors">Berita</a>
            <span>/</span>
            <span class="text-white font-semibold">Detail Berita</span>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Article -->
            <div class="lg:col-span-2">
                <!-- Article Card -->
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Featured Image -->
                    @if($news->thumbnail)
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ Storage::url($news->thumbnail) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                        <!-- Category Badge -->
                        @if($news->category)
                        <div class="absolute top-6 left-6">
                            <span class="bg-red-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg">
                                {{ $news->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="p-8 lg:p-12">
                        <!-- Title -->
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                            {{ $news->title }}
                        </h1>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-6 mb-8 pb-6 border-b border-gray-200">
                            @if($news->author)
                            <div class="flex items-center text-gray-600">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">{{ $news->author->name }}</span>
                            </div>
                            @endif
                            <div class="flex items-center text-gray-600">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $news->published_at->format('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Article Body -->
                        <div class="prose prose-lg max-w-none article-content">
                            {!! $news->content !!}
                        </div>
                    </div>
                </article>

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="{{ route('news.index') }}" 
                       class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Semua Berita
                    </a>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Related News -->
                @if($relatedNews->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('news.show', $related->slug) }}" class="group block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            @if($related->thumbnail)
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ Storage::url($related->thumbnail) }}" 
                                     alt="{{ $related->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                            </div>
                            @else
                            <div class="h-48 bg-blue-100 flex items-center justify-center">
                                <svg class="h-16 w-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="p-5">
                                <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $related->title }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $related->published_at->format('d M Y') }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Gallery Images -->
                @if($news->images && count($news->images) > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($news->images as $index => $image)
                        <button onclick="openModal({{ $index }})" class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 group cursor-pointer">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="{{ $news->title }}" 
                                 class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <svg class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden items-center justify-center p-4" onclick="closeModal()">
    <!-- Close Button -->
    <button onclick="closeModal()" class="absolute top-6 right-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-300 z-10 group">
        <svg class="h-6 w-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    
    <!-- Previous Button -->
    <button onclick="prevImage(event)" class="absolute left-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-4 rounded-full transition-all duration-300 hover:scale-110 z-10">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    
    <!-- Image -->
    <img id="modalImage" src="" alt="" class="max-h-full max-w-full object-contain rounded-lg shadow-2xl" onclick="event.stopPropagation()">
    
    <!-- Next Button -->
    <button onclick="nextImage(event)" class="absolute right-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-4 rounded-full transition-all duration-300 hover:scale-110 z-10">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
const images = [
    @if($news->images && count($news->images) > 0)
        @foreach($news->images as $image)
            "{{ Storage::url($image) }}",
        @endforeach
    @endif
];

let currentImageIndex = 0;

function openModal(index) {
    currentImageIndex = index;
    updateModalImage();
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function updateModalImage() {
    document.getElementById('modalImage').src = images[currentImageIndex];
}

function nextImage(event) {
    event.stopPropagation();
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateModalImage();
}

function prevImage(event) {
    event.stopPropagation();
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateModalImage();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('imageModal');
    if (!modal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowRight') nextImage(e);
        if (e.key === 'ArrowLeft') prevImage(e);
    }
});
</script>

<style>
.article-content {
    color: #374151;
    font-size: 1.125rem;
    line-height: 1.75;
}
.article-content h1, 
.article-content h2, 
.article-content h3, 
.article-content h4 {
    color: #111827;
    font-weight: bold;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
}
.article-content h1 { font-size: 2em; }
.article-content h2 { font-size: 1.5em; }
.article-content h3 { font-size: 1.25em; }
.article-content p {
    margin-bottom: 1.25em;
    line-height: 1.8;
}
.article-content a {
    color: #2563eb;
    text-decoration: underline;
}
.article-content a:hover {
    color: #1d4ed8;
}
.article-content ul, 
.article-content ol {
    margin-left: 1.5em;
    margin-bottom: 1.25em;
}
.article-content li {
    margin-bottom: 0.5em;
}
.article-content strong {
    color: #111827;
    font-weight: 600;
}
.article-content blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1em;
    font-style: italic;
    color: #6b7280;
    margin: 1.5em 0;
}
.article-content img {
    border-radius: 0.5em;
    margin: 1.5em 0;
    max-width: 100%;
    height: auto;
}
</style>
@endsection
