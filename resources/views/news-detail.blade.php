@extends('layouts.app')

@section('content')
<!-- News Detail Hero -->
<section class="relative bg-gradient-to-br from-primary-600 to-primary-800 text-white py-20 mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="flex items-center justify-center text-blue-200 text-sm mb-4">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $news->published_at->format('d F Y') }}
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ $news->title }}
            </h1>
            @if($news->author)
            <p class="text-blue-100">
                Oleh {{ $news->author->name }}
            </p>
            @endif
        </div>
    </div>
</section>

<!-- News Content -->
<section class="py-12 bg-primary-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Image -->
        @if($news->thumbnail)
        <div class="mb-8 rounded-xl overflow-hidden shadow-2xl">
            <img src="{{ Storage::url($news->thumbnail) }}" 
                 alt="{{ $news->title }}" 
                 class="w-full h-auto object-cover">
        </div>
        @endif

        <!-- Content -->
        <div class="bg-primary-800/70 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-primary-700 mb-8">
            <div class="prose prose-lg prose-invert max-w-none">
                {!! $news->content !!}
            </div>
        </div>

        <!-- Gallery Images -->
        @if($news->images && count($news->images) > 0)
        <div class="bg-primary-800/70 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-primary-700 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Galeri Foto</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($news->images as $image)
                <div class="rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <img src="{{ Storage::url($image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('home') }}#berita" 
               class="inline-flex items-center text-blue-300 hover:text-blue-200 font-semibold transition-colors duration-300">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

<!-- Related News -->
@if($relatedNews->count() > 0)
<section class="py-16 bg-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-8 text-center">
            Berita Terkait
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedNews as $related)
            <div class="bg-primary-800/70 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-primary-700 hover:border-blue-400">
                @if($related->thumbnail)
                <div class="relative overflow-hidden group">
                    <img src="{{ Storage::url($related->thumbnail) }}" 
                         alt="{{ $related->title }}" 
                         class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                @endif
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-2 hover:text-blue-200 transition-colors duration-300">
                        {{ $related->title }}
                    </h3>
                    <div class="flex items-center text-blue-200 text-sm mb-3">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $related->published_at->format('d M Y') }}
                    </div>
                    <a href="{{ route('news.show', $related->slug) }}" 
                       class="inline-flex items-center text-blue-300 hover:text-blue-200 font-semibold transition-colors duration-300">
                        Baca Selengkapnya
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Add custom styles for prose -->
<style>
.prose-invert {
    color: #dbeafe;
}
.prose-invert h1, .prose-invert h2, .prose-invert h3, .prose-invert h4 {
    color: #ffffff;
    font-weight: bold;
    margin-top: 1.5em;
    margin-bottom: 0.5em;
}
.prose-invert h1 { font-size: 2em; }
.prose-invert h2 { font-size: 1.5em; }
.prose-invert h3 { font-size: 1.25em; }
.prose-invert p {
    margin-bottom: 1em;
    line-height: 1.75;
}
.prose-invert a {
    color: #93c5fd;
    text-decoration: underline;
}
.prose-invert a:hover {
    color: #bfdbfe;
}
.prose-invert ul, .prose-invert ol {
    margin-left: 1.5em;
    margin-bottom: 1em;
}
.prose-invert li {
    margin-bottom: 0.5em;
}
.prose-invert strong {
    color: #ffffff;
    font-weight: 600;
}
.prose-invert blockquote {
    border-left: 4px solid #60a5fa;
    padding-left: 1em;
    font-style: italic;
    color: #bfdbfe;
}
.prose-invert code {
    background-color: #1e3a8a;
    padding: 0.2em 0.4em;
    border-radius: 0.25em;
    font-size: 0.875em;
}
.prose-invert pre {
    background-color: #1e3a8a;
    padding: 1em;
    border-radius: 0.5em;
    overflow-x: auto;
    margin-bottom: 1em;
}
</style>
@endsection
