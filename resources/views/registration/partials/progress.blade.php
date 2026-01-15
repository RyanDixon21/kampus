@php
    $steps = [
        1 => 'Pilih Jalur',
        2 => 'Isi Formulir',
        3 => 'Konfirmasi',
        4 => 'Pembayaran'
    ];
@endphp

<div class="bg-white rounded-xl shadow-sm border p-4">
    <div class="flex items-center justify-between">
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
