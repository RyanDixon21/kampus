@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <!-- Success Animation -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4 animate-bounce">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ujian Selesai!</h1>
            <p class="text-gray-600">Terima kasih telah menyelesaikan ujian CBT</p>
        </div>

        <!-- Result Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <h2 class="text-2xl font-bold text-white text-center">Hasil Ujian CBT</h2>
            </div>

            <!-- Content -->
            <div class="px-8 py-8">
                <!-- Score Display -->
                <div class="text-center mb-8">
                    <p class="text-gray-600 mb-2">Skor Anda</p>
                    <div class="relative inline-block">
                        <svg class="transform -rotate-90 w-40 h-40">
                            <circle 
                                cx="80" 
                                cy="80" 
                                r="70" 
                                stroke="#e5e7eb" 
                                stroke-width="12" 
                                fill="none"
                            />
                            <circle 
                                cx="80" 
                                cy="80" 
                                r="70" 
                                stroke="{{ $result['score'] >= 70 ? '#10b981' : ($result['score'] >= 50 ? '#f59e0b' : '#ef4444') }}" 
                                stroke-width="12" 
                                fill="none"
                                stroke-dasharray="{{ 2 * 3.14159 * 70 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 70 * (1 - $result['score'] / 100) }}"
                                stroke-linecap="round"
                                class="transition-all duration-1000 ease-out"
                            />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-5xl font-bold" style="color: {{ $result['score'] >= 70 ? '#10b981' : ($result['score'] >= 50 ? '#f59e0b' : '#ef4444') }}">
                                    {{ $result['score'] }}
                                </p>
                                <p class="text-gray-600 text-sm">dari 100</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="text-center mb-8">
                    @if($result['score'] >= 70)
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Lulus</span>
                    </div>
                    @elseif($result['score'] >= 50)
                    <div class="inline-flex items-center px-6 py-3 bg-yellow-100 text-yellow-800 rounded-full">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Perlu Ditingkatkan</span>
                    </div>
                    @else
                    <div class="inline-flex items-center px-6 py-3 bg-red-100 text-red-800 rounded-full">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Belum Lulus</span>
                    </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Hasil</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Nomor Pendaftaran</span>
                            <span class="font-semibold text-gray-900">{{ $registration->registration_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Nama</span>
                            <span class="font-semibold text-gray-900">{{ $registration->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Total Soal</span>
                            <span class="font-semibold text-gray-900">{{ $result['total_questions'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Jawaban Benar</span>
                            <span class="font-semibold text-green-600">{{ $result['correct_answers'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Jawaban Salah</span>
                            <span class="font-semibold text-red-600">{{ $result['total_questions'] - $result['correct_answers'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Waktu Selesai</span>
                            <span class="font-semibold text-gray-900">{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Message -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Hasil ujian Anda telah tersimpan. Tim kami akan menghubungi Anda untuk informasi lebih lanjut mengenai proses seleksi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a 
                        href="{{ route('home') }}"
                        class="flex-1 flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    <button 
                        onclick="window.print()"
                        class="flex-1 flex justify-center items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200"
                    >
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Hasil
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Langkah Selanjutnya</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Simpan atau cetak hasil ujian Anda sebagai bukti</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Tunggu pengumuman hasil seleksi melalui email atau WhatsApp</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Hubungi admin jika ada pertanyaan mengenai hasil ujian</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Pantau terus website untuk informasi terbaru</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        nav, footer, button, .no-print {
            display: none !important;
        }
        
        body {
            background: white !important;
        }
        
        .bg-gradient-to-br {
            background: white !important;
        }
    }
</style>
@endsection
