<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ujian CBT - STT Pratama Adi</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div x-data="cbtExam()" x-init="init()" class="min-h-screen">
        <!-- Header with Timer -->
        <div class="bg-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('logo.png') }}" alt="STT Pratama Adi" class="h-10 w-10">
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">Ujian CBT</h1>
                            <p class="text-sm text-gray-600">{{ $registration->name }}</p>
                        </div>
                    </div>
                    
                    <!-- Timer -->
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Sisa Waktu</p>
                            <p class="text-2xl font-bold" :class="timeRemaining < 300 ? 'text-red-600' : 'text-primary-600'" x-text="formatTime(timeRemaining)"></p>
                        </div>
                        <div class="hidden sm:block">
                            <svg class="h-12 w-12" :class="timeRemaining < 300 ? 'text-red-600' : 'text-primary-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Question Panel -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Question Number -->
                        <div class="flex justify-between items-center mb-6 pb-4 border-b">
                            <h2 class="text-xl font-bold text-gray-900">
                                Soal <span x-text="currentQuestion + 1"></span> dari <span x-text="questions.length"></span>
                            </h2>
                            <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium">
                                <span x-text="questions[currentQuestion]?.category || 'Umum'"></span>
                            </span>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-8">
                            <p class="text-lg text-gray-800 leading-relaxed whitespace-pre-wrap" x-text="questions[currentQuestion]?.question"></p>
                        </div>

                        <!-- Options -->
                        <div class="space-y-3">
                            <template x-for="(option, index) in questions[currentQuestion]?.options" :key="index">
                                <label 
                                    class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:border-primary-300 hover:bg-primary-50"
                                    :class="answers[currentQuestion] === index ? 'border-primary-600 bg-primary-50' : 'border-gray-200'"
                                >
                                    <input 
                                        type="radio" 
                                        :name="'question_' + currentQuestion"
                                        :value="index"
                                        x-model="answers[currentQuestion]"
                                        class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500"
                                    >
                                    <span class="ml-3 text-gray-700 flex-1">
                                        <span class="font-medium mr-2" x-text="String.fromCharCode(65 + index) + '.'"></span>
                                        <span x-text="option.text"></span>
                                    </span>
                                </label>
                            </template>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center mt-8 pt-6 border-t">
                            <button 
                                @click="previousQuestion()"
                                :disabled="currentQuestion === 0"
                                class="flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Sebelumnya
                            </button>

                            <button 
                                @click="nextQuestion()"
                                :disabled="currentQuestion === questions.length - 1"
                                class="flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                Selanjutnya
                                <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Question Navigator -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Navigasi Soal</h3>
                        
                        <!-- Progress -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Terjawab</span>
                                <span><span x-text="Object.keys(answers).length"></span>/<span x-text="questions.length"></span></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div 
                                    class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                                    :style="'width: ' + (Object.keys(answers).length / questions.length * 100) + '%'"
                                ></div>
                            </div>
                        </div>

                        <!-- Question Grid -->
                        <div class="grid grid-cols-5 gap-2 mb-6">
                            <template x-for="(question, index) in questions" :key="index">
                                <button
                                    @click="goToQuestion(index)"
                                    class="aspect-square rounded-lg text-sm font-medium transition-all duration-200"
                                    :class="{
                                        'bg-primary-600 text-white': currentQuestion === index,
                                        'bg-green-100 text-green-700 hover:bg-green-200': currentQuestion !== index && answers[index] !== undefined,
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200': currentQuestion !== index && answers[index] === undefined
                                    }"
                                    x-text="index + 1"
                                ></button>
                            </template>
                        </div>

                        <!-- Legend -->
                        <div class="space-y-2 text-sm mb-6">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-primary-600 rounded mr-2"></div>
                                <span class="text-gray-600">Soal aktif</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-green-100 border border-green-300 rounded mr-2"></div>
                                <span class="text-gray-600">Sudah dijawab</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-gray-100 border border-gray-300 rounded mr-2"></div>
                                <span class="text-gray-600">Belum dijawab</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            @click="confirmSubmit()"
                            class="w-full py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium"
                        >
                            Selesai & Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div 
            x-show="showConfirmModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 px-4"
            style="display: none;"
        >
            <div 
                @click.away="showConfirmModal = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-white rounded-lg shadow-xl max-w-md w-full p-6"
            >
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Submit</h3>
                    <p class="text-gray-600 mb-6">
                        Anda telah menjawab <span class="font-bold" x-text="Object.keys(answers).length"></span> dari <span class="font-bold" x-text="questions.length"></span> soal.
                        <br><br>
                        Apakah Anda yakin ingin menyelesaikan ujian?
                    </p>
                    <div class="flex space-x-3">
                        <button 
                            @click="showConfirmModal = false"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        >
                            Batal
                        </button>
                        <button 
                            @click="submitExam()"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200"
                        >
                            Ya, Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Form for Submission -->
        <form id="submitForm" action="{{ route('cbt.submit') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="answers" :value="JSON.stringify(formatAnswersForSubmit())">
        </form>
    </div>

    @push('scripts')
    <script>
        function cbtExam() {
            return {
                questions: @json($questions),
                duration: {{ $duration }},
                currentQuestion: 0,
                answers: {},
                timeRemaining: {{ $duration * 60 }},
                timerInterval: null,
                showConfirmModal: false,

                init() {
                    this.startTimer();
                    
                    // Prevent page refresh
                    window.addEventListener('beforeunload', (e) => {
                        if (Object.keys(this.answers).length > 0) {
                            e.preventDefault();
                            e.returnValue = '';
                        }
                    });
                },

                startTimer() {
                    this.timerInterval = setInterval(() => {
                        this.timeRemaining--;
                        
                        if (this.timeRemaining <= 0) {
                            this.autoSubmit();
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const secs = seconds % 60;
                    
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                },

                nextQuestion() {
                    if (this.currentQuestion < this.questions.length - 1) {
                        this.currentQuestion++;
                    }
                },

                previousQuestion() {
                    if (this.currentQuestion > 0) {
                        this.currentQuestion--;
                    }
                },

                goToQuestion(index) {
                    this.currentQuestion = index;
                },

                confirmSubmit() {
                    this.showConfirmModal = true;
                },

                formatAnswersForSubmit() {
                    const formattedAnswers = [];
                    
                    for (let i = 0; i < this.questions.length; i++) {
                        if (this.answers[i] !== undefined) {
                            formattedAnswers.push({
                                question_id: this.questions[i].id,
                                selected_option: this.answers[i]
                            });
                        }
                    }
                    
                    return formattedAnswers;
                },

                submitExam() {
                    clearInterval(this.timerInterval);
                    document.getElementById('submitForm').submit();
                },

                autoSubmit() {
                    clearInterval(this.timerInterval);
                    alert('Waktu ujian telah habis. Jawaban Anda akan otomatis disubmit.');
                    document.getElementById('submitForm').submit();
                }
            }
        }
    </script>
    @endpush
</body>
</html>
