@extends('layouts.app')

@section('title', 'Semua Quiz')
@section('header-title', 'Semua Quiz')
@section('header-subtitle', 'Temukan semua quiz-mu di sini!')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Info Pagination --}}
    @if($quizzes->total() > 0)
        <div class="mb-4 text-sm text-gray-600">
            Menampilkan {{ $quizzes->firstItem() }} - {{ $quizzes->lastItem() }} dari {{ $quizzes->total() }} quiz
        </div>
    @endif

    @if($quizzes->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada quiz tersedia</h3>
            <p class="text-gray-500">Semua quiz sudah dikerjakan atau belum ada quiz yang dibuat.</p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition">
                Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($quizzes as $quiz)
            <div class="border p-5 flex flex-col bg-white shadow-sm hover:shadow-md transition rounded-xl">

                <span class="text-xs font-medium text-indigo-600 border border-indigo-400 
                                px-2 py-1 rounded w-max mb-3">
                    Quiz
                </span>

                <p class="text-lg font-bold text-gray-700">
                    {{ $quiz->title }}
                </p>

                <p class="text-sm text-gray-500 mt-1 mb-4">
                    {{ $quiz->description }}
                </p>

                <p class="text-xs text-gray-500 mb-3">+{{ $quiz->xp }} XP</p>

                <a href="{{ route('quiz.start', $quiz->id) }}"
                    class="mt-auto bg-indigo-600 text-white text-center py-2 rounded 
                            hover:bg-indigo-500 transition">
                    Mulai Quiz
                </a>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($quizzes->hasPages())
        <div class="flex justify-center mt-8">
            <nav class="inline-flex rounded-md shadow-sm">
                {{-- Previous Page Link --}}
                @if($quizzes->onFirstPage())
                    <span class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-400 rounded-l-md cursor-not-allowed">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $quizzes->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 rounded-l-md hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </a>
                @endif

                {{-- Pagination Elements - MAX 7 Pages --}}
                @php
                    $current = $quizzes->currentPage();
                    $last = $quizzes->lastPage();
                    $start = max(1, $current - 3);
                    $end = min($last, $current + 3);
                @endphp

                {{-- First Page --}}
                @if($start > 1)
                    <a href="{{ $quizzes->url(1) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        1
                    </a>
                    @if($start > 2)
                        <span class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            ...
                        </span>
                    @endif
                @endif

                {{-- Page Numbers --}}
                @for($page = $start; $page <= $end; $page++)
                    @if($page == $quizzes->currentPage())
                        <span class="inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-500 text-sm font-medium text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $quizzes->url($page) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Last Page --}}
                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            ...
                        </span>
                    @endif
                    <a href="{{ $quizzes->url($last) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ $last }}
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if($quizzes->hasMorePages())
                    <a href="{{ $quizzes->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 rounded-r-md hover:bg-gray-50 transition-colors">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-400 rounded-r-md cursor-not-allowed">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
        @endif
    @endif
</div>
@endsection