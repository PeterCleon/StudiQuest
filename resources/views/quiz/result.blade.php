@extends('layouts.app')

@section('title', 'Hasil Quiz')
@section('header-title', 'Hasil Quiz')
@section('header-subtitle', '')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl mt-6 shadow">

    {{-- Header Result --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h1>
        <div class="mt-4 inline-block bg-blue-100 text-blue-800 px-6 py-3 rounded-full">
            <span class="text-2xl font-bold">{{ $result['score'] }}</span>
            <span class="text-lg">/ {{ $result['total'] }}</span>
        </div>
        <p class="text-gray-600 mt-2">
            @if($result['score'] == $result['total'])
                🎉 Perfect! Semua jawaban benar!
            @elseif($result['score'] >= $result['total'] * 0.7)
                👍 Good job! Hasilnya bagus!
            @else
                💪 Tetap semangat, lanjut belajar!
            @endif
        </p>
    </div>

    {{-- List Soal --}}
    @foreach ($result['details'] as $index => $item)
    <div x-data="{ open: false }" class="mb-6 border border-gray-300 rounded-lg p-5 bg-white hover:shadow-md transition-shadow">

        {{-- Header Soal --}}
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                {{-- Nomor Soal --}}
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                
                {{-- Status Jawaban --}}
                <div class="flex items-center gap-2">
                    @if($item['is_correct'])
                        <span class="text-green-600 font-semibold">✅ Benar</span>
                    @else
                        <span class="text-red-600 font-semibold">❌ Salah</span>
                    @endif
                </div>
            </div>

            @php
                $selectedChoice = collect($item['choices'])->firstWhere('id', $item['selected']);
            @endphp
        </div>

        {{-- Jawaban User --}}
        <div class="mt-3 ml-12">
            <p class="text-sm text-gray-600">Jawaban kamu:</p>
            <p class="font-medium {{ $item['is_correct'] ? 'text-green-700' : 'text-red-700' }}">
                {{ $selectedChoice['text'] ?? 'Tidak menjawab' }}
            </p>
        </div>

        {{-- Detail Jawaban (Expandable) --}}
        <div x-show="open" x-collapse class="mt-4 pl-3 border-l-2 border-gray-300">
            <p class="font-semibold text-gray-900 mb-3 text-lg">{{ $item['question'] }}</p>

            <div class="space-y-2">
                @foreach ($item['choices'] as $choice)
                    @php
                        $isCorrect = $choice['id'] == $item['correct_answer'];
                        $isChosen = $choice['id'] == $item['selected'];
                    @endphp

                    <div class="p-3 rounded-lg border transition-all
                        @if($isCorrect) bg-green-100 border-green-300 @endif
                        @if($isChosen && !$isCorrect) bg-red-100 border-red-300 @endif
                        @if(!$isCorrect && !$isChosen) bg-gray-50 border-gray-200 @endif">
                        
                        <div class="flex items-center gap-3">
                            {{-- Indicator --}}
                            <div class="flex items-center gap-2">
                                @if($isCorrect)
                                    <span class="text-green-600 font-bold">✓</span>
                                @elseif($isChosen && !$isCorrect)
                                    <span class="text-red-600 font-bold">✗</span>
                                @else
                                    <span class="text-gray-400">○</span>
                                @endif
                            </div>

                            {{-- Label (A/B/C/D) --}}
                            <span class="font-bold text-gray-700 min-w-6">
                                {{ $choice['label'] ?? chr(64 + $loop->iteration) }}
                            </span>

                            {{-- Text Jawaban --}}
                            <span class="flex-1 @if($isCorrect) text-green-800 font-medium @else text-gray-700 @endif">
                                {{ $choice['text'] }}
                            </span>

                            {{-- Badge --}}
                            <div class="flex gap-1">
                                @if($isCorrect)
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">Jawaban Benar</span>
                                @endif
                                @if($isChosen)
                                    <span class="px-2 py-1 bg-blue-500 text-white text-xs rounded">Pilihan Kamu</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    @endforeach

    {{-- Action Buttons --}}
    <div class="flex gap-4 justify-center mt-8">
        <a href="{{ route('quiz.index') }}" 
           class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            🎯 Kerjakan Quiz Lain
        </a>
		<a href="{{ route('dashboard') }}" 
           class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg hover:bg-blue-600 transition-colors">
            🏠 Kembali ke Dashboard
        </a>
        <a href="{{ route('quiz.history') }}" 
           class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            📚 Lihat History
        </a>
    </div>

</div>
@endsection