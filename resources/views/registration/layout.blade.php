<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-10">
                    <span class="font-bold text-gray-900">{{ config('app.name') }}</span>
                </a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 text-sm">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Progress Indicator -->
    @if(isset($currentStep))
    <div class="bg-white border-b">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                @php
                    $steps = [
                        1 => 'Pilih Jalur',
                        2 => 'Isi Formulir',
                        3 => 'Konfirmasi',
                        4 => 'Pembayaran'
                    ];
                @endphp
                @foreach($steps as $num => $label)
                    <div class="flex items-center {{ $num < count($steps) ? 'flex-1' : '' }}">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                                {{ $num < $currentStep ? 'bg-green-500 text-white' : '' }}
                                {{ $num == $currentStep ? 'bg-blue-600 text-white' : '' }}
                                {{ $num > $currentStep ? 'bg-gray-200 text-gray-500' : '' }}">
                                @if($num < $currentStep)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    {{ $num }}
                                @endif
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $num == $currentStep ? 'text-blue-600' : 'text-gray-500' }} hidden sm:block">
                                {{ $label }}
                            </span>
                        </div>
                        @if($num < count($steps))
                            <div class="flex-1 h-0.5 mx-4 {{ $num < $currentStep ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                {{ session('info') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
