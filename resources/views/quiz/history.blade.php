@extends('layouts.app')

@section('title', 'History Quiz')
@section('header-title', 'Riwayat Quiz')
@section('header-subtitle', 'Lihat semua quiz yang pernah kamu kerjakan')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl mt-6 shadow-sm">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
    @if($history->count() > 0)
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-1">
            @foreach($history as $quiz)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $quiz->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            Dikerjakan: {{ $quiz->pivot->created_at->format('d M Y H:i') }}
                        </p>
                        
                        <div class="flex items-center gap-4 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm font-medium text-gray-700">
                                    Score: <span class="text-blue-600">{{ $quiz->pivot->score }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-sm font-medium text-gray-700">
                                    XP: <span class="text-green-600">{{ $quiz->xp }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('quiz.result', $quiz->id) }}" 
                           class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors duration-200 text-center">
                           📊 Lihat Detail
                        </a>
                    </div>
                </div>
                
                <!-- Progress bar - FIXED Division by Zero -->
                @php
                    // Cek apakah questions_count ada dan tidak nol
                    $totalQuestions = $quiz->questions_count ?? 0;
                    if ($totalQuestions > 0) {
                        $percentage = $quiz->pivot->score > 0 ? round(($quiz->pivot->score / $totalQuestions) * 100) : 0;
                    } else {
                        $percentage = 0;
                    }
                    $progressColor = $percentage >= 80 ? 'bg-green-500' : ($percentage >= 60 ? 'bg-yellow-500' : 'bg-red-500');
                @endphp
                <div class="mt-3">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $progressColor }}" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada riwayat quiz</h3>
            <p class="text-gray-500 mb-6">Yuk kerjakan quiz pertama kamu!</p>
            <a href="{{ route('quiz.index') }}" 
               class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                Mulai Quiz
            </a>
        </div>
    @endif
    
    <!-- Pagination -->
    @if($history->hasPages())
        <div class="mt-6">
            {{ $history->links() }}
        </div>
    @endif
</div>
@endsection