@extends('layouts.app')

@section('content')
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Success Icon -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="mt-4 text-3xl font-bold text-gray-900">Pendaftaran Berhasil!</h1>
                <p class="mt-2 text-gray-600">Terima kasih telah mendaftar. Silakan lakukan pembayaran untuk menyelesaikan pendaftaran.</p>
            </div>

            <!-- Registration Number -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                <p class="text-sm text-blue-600 font-medium">Nomor Pendaftaran Anda</p>
                <p class="text-3xl font-bold text-blue-700 mt-2">{{ $registration->registration_number }}</p>
                <p class="text-sm text-gray-500 mt-2">Simpan nomor ini untuk keperluan selanjutnya</p>
            </div>

            <!-- Registration Details -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pendaftaran</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Nama</span>
                        <span class="font-medium text-gray-900">{{ $registration->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Email</span>
                        <span class="font-medium text-gray-900">{{ $registration->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Jalur Pendaftaran</span>
                        <span class="font-medium text-gray-900">{{ $registration->registrationPath->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Program Studi Pilihan 1</span>
                        <span class="font-medium text-gray-900">{{ $registration->firstChoiceProgram->name ?? '-' }}</span>
                    </div>
                    @if($registration->secondChoiceProgram)
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Program Studi Pilihan 2</span>
                        <span class="font-medium text-gray-900">{{ $registration->secondChoiceProgram->name }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Status Pembayaran</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $registration->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $registration->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($registration->final_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($paymentInstructions && count($paymentInstructions) > 0)
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Instruksi Pembayaran</h2>
                <ol class="space-y-3 list-decimal list-inside">
                    @foreach($paymentInstructions as $instruction)
                        <li class="text-gray-600">{{ $instruction }}</li>
                    @endforeach
                </ol>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('home') }}" 
                   class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    Kembali ke Beranda
                </a>
                @if(isset($whatsappMessage))
                <a href="https://wa.me/6281234567890?text={{ urlencode($whatsappMessage) }}" 
                   target="_blank"
                   class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Konfirmasi via WhatsApp
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
