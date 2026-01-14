@extends('layouts.app')

@section('content')
<section class="relative py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-600">Langkah 2 dari 6</span>
                <span class="text-sm text-gray-500">Pilih Program Studi</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 33.33%"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pilih Program Studi</h1>
            <p class="text-gray-600">Jalur: <span class="font-semibold text-blue-600">{{ $selectedPath }}</span></p>
            <p class="text-sm text-gray-500 mt-2">Pilih maksimal 2 program studi (pilihan 1 wajib)</p>
        </div>

        <!-- Form -->
        <form action="{{ route('registration.multi-step.programs.store') }}" method="POST" x-data="programSelection()">
            @csrf
            
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <!-- First Choice -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Program Studi Pilihan 1 <span class="text-red-500">*</span>
                    </label>
                    <select name="first_choice_program_id" x-model="firstChoice" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programs as $faculty => $progs)
                            <optgroup label="{{ $faculty }}">
                                @foreach($progs as $program)
                                    <option value="{{ $program->id }}">
                                        {{ $program->name }} ({{ $program->degree_level }})
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('first_choice_program_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Second Choice -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Program Studi Pilihan 2 <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <select name="second_choice_program_id" x-model="secondChoice"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programs as $faculty => $progs)
                            <optgroup label="{{ $faculty }}">
                                @foreach($progs as $program)
                                    <option value="{{ $program->id }}" 
                                            :disabled="firstChoice == '{{ $program->id }}'">
                                        {{ $program->name }} ({{ $program->degree_level }})
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('second_choice_program_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pilihan 2 tidak boleh sama dengan Pilihan 1
                    </p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center">
                <a href="{{ route('registration.multi-step.paths') }}" 
                   class="text-gray-600 hover:text-gray-900 font-medium">
                    ← Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl">
                    Lanjutkan →
                </button>
            </div>
        </form>

    </div>
</section>

@push('scripts')
<script>
function programSelection() {
    return {
        firstChoice: '',
        secondChoice: '',
    }
}
</script>
@endpush
@endsection
