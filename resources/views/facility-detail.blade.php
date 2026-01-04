@extends('layouts.app')

@section('content')
<!-- Facility Detail Hero -->
<section class="relative bg-gradient-to-br from-teal-600 to-teal-800 text-white py-20 mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ $facility->name }}
            </h1>
            <p class="text-teal-100 text-lg">
                Fasilitas Kampus
            </p>
        </div>
    </div>
</section>

<!-- Facility Content -->
<section class="py-12 bg-primary-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Image -->
        @if($facility->image)
        <div class="mb-8 rounded-xl overflow-hidden shadow-2xl">
            <img src="{{ Storage::url($facility->image) }}" 
                 alt="{{ $facility->name }}" 
                 class="w-full h-auto object-cover">
        </div>
        @endif

        <!-- Description -->
        <div class="bg-teal-800/70 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-teal-700 mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">Deskripsi</h2>
            <div class="prose prose-lg prose-invert max-w-none">
                <p class="text-teal-100 leading-relaxed">{{ $facility->description }}</p>
            </div>
        </div>

        <!-- Gallery Images -->
        @if($facility->images && count($facility->images) > 0)
        <div class="bg-teal-800/70 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-teal-700 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Galeri Foto</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($facility->images as $image)
                <div class="rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <img src="{{ Storage::url($image) }}" 
                         alt="{{ $facility->name }}" 
                         class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('home') }}#fasilitas" 
               class="inline-flex items-center text-teal-300 hover:text-teal-200 font-semibold transition-colors duration-300">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

<!-- Related Facilities -->
@if($relatedFacilities->count() > 0)
<section class="py-16 bg-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-8 text-center">
            Fasilitas Lainnya
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedFacilities as $related)
            <div class="bg-teal-800/70 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-teal-700 hover:border-teal-400">
                @if($related->image)
                <div class="relative overflow-hidden group">
                    <img src="{{ Storage::url($related->image) }}" 
                         alt="{{ $related->name }}" 
                         class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-teal-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                @endif
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-2 hover:text-teal-200 transition-colors duration-300">
                        {{ $related->name }}
                    </h3>
                    <p class="text-teal-100 line-clamp-2 mb-3">{{ $related->description }}</p>
                    <a href="{{ route('facility.show', $related->slug) }}" 
                       class="inline-flex items-center text-teal-300 hover:text-teal-200 font-semibold transition-colors duration-300">
                        Selengkapnya
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
@endsection
