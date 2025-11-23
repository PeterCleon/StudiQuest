@extends('layouts.app')

@section('title', 'Kelola Soal')
@section('header-title', '✏️ Kelola Soal')
@section('header-subtitle', 'Kelola soal untuk: ' . $quiz->title)

@section('content')
<div class="max-w-6xl mx-auto mt-8">
	<div class="mb-6">
        <a href="{{ route('teacher.quizzes') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 duration-200 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
			Kembali
        </a>
    </div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h2>
            <p class="text-gray-600">{{ $questions->count() }} Soal • +{{ $quiz->xp }} XP</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teacher.quiz.create') }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
                📚 Quiz Lain
            </a>
            <a href="{{ route('teacher.question.create', $quiz->id) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors font-semibold">
                ➕ Tambah Soal
            </a>
        </div>
    </div>

    @if($questions->isEmpty())
    <div class="text-center py-12 bg-white rounded-xl shadow-sm border">
        <div class="text-6xl mb-4">❓</div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada soal</h3>
        <p class="text-gray-500 mb-6">Tambahkan soal pertama untuk quiz ini</p>
        <a href="{{ route('teacher.question.create', $quiz->id) }}" 
           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors">
            Tambah Soal Pertama
        </a>
    </div>
    @else
    <!-- Questions List -->
    <div class="space-y-4">
        @foreach($questions as $question)
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Soal #{{ $loop->iteration }}
                </h3>
                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm">
                    {{ $question->choices->count() }} Pilihan
                </span>
            </div>
            
            <p class="text-gray-700 mb-4 text-lg">{{ $question->question }}</p>
            
            <!-- Choices -->
            <div class="space-y-2">
                @foreach($question->choices as $choice)
                <div class="flex items-center gap-3 p-3 border rounded-lg 
                    {{ $choice->is_correct ? 'bg-green-50 border-green-200' : 'bg-gray-50' }}">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full 
                        {{ $choice->is_correct ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }} text-sm font-bold">
                        {{ chr(65 + $loop->index) }}
                    </span>
                    <span class="flex-1 {{ $choice->is_correct ? 'text-green-800 font-medium' : 'text-gray-700' }}">
                        {{ $choice->choice }}
                    </span>
                    @if($choice->is_correct)
                    <span class="px-2 py-1 bg-green-500 text-white rounded text-xs">Jawaban Benar</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection