@extends('layouts.app')

@section('content')
<!-- Main Content -->
<section class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('home') }}#fasilitas" class="hover:text-primary-600 transition-colors">Fasilitas</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900 font-semibold truncate">{{ Str::limit($facility->name, 50) }}</li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">
            {{ $facility->name }}
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Featured Image Card -->
                @if($facility->image)
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ Storage::url($facility->image) }}" 
                         alt="{{ $facility->name }}" 
                         class="w-full h-auto object-cover"
                         onerror="this.style.display='none';">
                </div>
                @endif

                <!-- Description Card -->
                <div class="bg-gray-50 rounded-2xl shadow-lg p-8 lg:p-10 border border-gray-200">
                    <div class="prose prose-lg max-w-none facility-content">
                        {!! $facility->description !!}
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home') }}#fasilitas" 
                       class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Fasilitas
                    </a>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center justify-center bg-primary-700 hover:bg-primary-600 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-primary-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- Sidebar - Gallery -->
            <div class="lg:col-span-1">
                @if($facility->images && count($facility->images) > 0)
                <div class="bg-gray-50 rounded-2xl shadow-lg p-6 border border-gray-200 sticky top-24">
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($facility->images as $index => $image)
                        <button onclick="openModal({{ $index }})" class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 group cursor-pointer">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="{{ $facility->name }}" 
                                 class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                <svg class="h-10 w-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    @if($facility->images && count($facility->images) > 0)
        @foreach($facility->images as $image)
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
.facility-content {
    color: #374151;
    font-size: 1.125rem;
    line-height: 1.75;
}
.facility-content h1, 
.facility-content h2, 
.facility-content h3, 
.facility-content h4 {
    color: #111827;
    font-weight: bold;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
}
.facility-content h1 { font-size: 2em; }
.facility-content h2 { font-size: 1.5em; }
.facility-content h3 { font-size: 1.25em; }
.facility-content p {
    margin-bottom: 1.25em;
    line-height: 1.8;
}
.facility-content a {
    color: #2563eb;
    text-decoration: underline;
}
.facility-content a:hover {
    color: #1d4ed8;
}
.facility-content ul, 
.facility-content ol {
    margin-left: 1.5em;
    margin-bottom: 1.25em;
}
.facility-content li {
    margin-bottom: 0.5em;
}
.facility-content strong {
    color: #111827;
    font-weight: 600;
}
.facility-content blockquote {
    border-left: 4px solid #10b981;
    padding-left: 1em;
    font-style: italic;
    color: #6b7280;
    margin: 1.5em 0;
}
.facility-content img {
    border-radius: 0.5em;
    margin: 1.5em 0;
    max-width: 100%;
    height: auto;
}
</style>
@endsection
