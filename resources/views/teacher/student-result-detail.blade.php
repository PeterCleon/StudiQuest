@extends('layouts.app')

@section('title', 'Detail Hasil Siswa')
@section('header-title', '📋 Detail Hasil Siswa')
@section('header-subtitle', 'Quiz: ' . $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $student->name }}</h2>
                <p class="text-gray-600">{{ $student->email }}</p>
                <p class="text-gray-600">{{ $student->kelas ?? '-' }} {{ $student->jurusan ?? '' }}</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-indigo-600">{{ $student->pivot->score }}</div>
                <div class="text-sm text-gray-600">Score</div>
                <div class="text-sm text-gray-500 mt-1">
                    {{ $student->pivot->created_at->format('d M Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('teacher.quiz.results', $quiz->id) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Hasil Quiz
        </a>
    </div>

    <!-- Detail Jawaban -->
    <div class="space-y-6">
        @foreach($details as $index => $item)
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-sm font-bold">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Soal #{{ $index + 1 }}</h3>
                        @if($item['is_correct'])
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">✅ Benar</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">❌ Salah</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pertanyaan -->
            <p class="text-lg font-medium text-gray-900 mb-4">{{ $item['question'] }}</p>

            <!-- Pilihan Jawaban -->
            <div class="space-y-2">
                @foreach($item['choices'] as $choice)
                    @php
                        $isCorrect = $choice['id'] == $item['correct_answer'];
                        $isSelected = $choice['id'] == $item['selected'];
                    @endphp

                    <div class="p-3 rounded-lg border transition-all
                        @if($isCorrect) bg-green-50 border-green-200 @endif
                        @if($isSelected && !$isCorrect) bg-red-50 border-red-200 @endif
                        @if(!$isCorrect && !$isSelected) bg-gray-50 @endif">
                        
                        <div class="flex items-center gap-3">
                            <!-- Indicator -->
                            <div class="flex items-center gap-2">
                                @if($isCorrect)
                                    <span class="text-green-600 font-bold">✓</span>
                                @elseif($isSelected && !$isCorrect)
                                    <span class="text-red-600 font-bold">✗</span>
                                @else
                                    <span class="text-gray-400">○</span>
                                @endif
                            </div>

                            <!-- Label -->
                            <span class="font-bold text-gray-700 min-w-6">
                                {{ $choice['label'] ?? chr(64 + $loop->iteration) }}
                            </span>

                            <!-- Text Jawaban -->
                            <span class="flex-1 @if($isCorrect) text-green-800 font-medium @else text-gray-700 @endif">
                                {{ $choice['text'] }}
                            </span>

                            <!-- Badge -->
                            <div class="flex gap-1">
                                @if($isCorrect)
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">Jawaban Benar</span>
                                @endif
                                @if($isSelected)
                                    <span class="px-2 py-1 bg-blue-500 text-white text-xs rounded">Pilihan Siswa</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Keterangan -->
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    @if($item['is_correct'])
                        ✅ Siswa menjawab <strong>benar</strong>
                    @else
                        ❌ Siswa menjawab <strong>salah</strong>. 
                        Jawaban yang dipilih: 
                        <strong>
                            {{ collect($item['choices'])->firstWhere('id', $item['selected'])['text'] ?? 'Tidak menjawab' }}
                        </strong>
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Summary -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Ringkasan Hasil</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">
                    {{ collect($details)->where('is_correct', true)->count() }}
                </div>
                <div class="text-sm text-gray-600">Jawaban Benar</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">
                    {{ collect($details)->where('is_correct', false)->count() }}
                </div>
                <div class="text-sm text-gray-600">Jawaban Salah</div>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">
                    {{ round((collect($details)->where('is_correct', true)->count() / count($details)) * 100) }}%
                </div>
                <div class="text-sm text-gray-600">Persentase Benar</div>
            </div>
        </div>
    </div>
</div>
@endsection