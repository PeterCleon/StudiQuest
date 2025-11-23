@extends('layouts.app')

@section('title', 'Daily Challenges')
@section('header-title', 'Daily Challenges')
@section('header-subtitle', 'Selesaikan misi harian dan dapatkan XP bonus!')

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
    @if($todayChallenges->total() > 0)
        <div class="mb-4 text-sm text-gray-600">
            Menampilkan {{ $todayChallenges->firstItem() }} - {{ $todayChallenges->lastItem() }} dari {{ $todayChallenges->total() }} challenge
        </div>
    @endif

    @if(count($userChallenges) === 0)
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🎯</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada challenge hari ini</h3>
            <p class="text-gray-500">Coba lagi besok untuk challenge baru!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-8">
            @foreach($userChallenges as $userChallenge)
            <div class="border p-5 flex flex-col bg-white shadow-sm hover:shadow-md transition rounded-xl 
                        {{ $userChallenge->is_completed ? 'border-green-400 bg-green-50' : '' }}">

                {{-- Badge Status --}}
                <div class="flex justify-between items-start mb-3">
                    <span class="text-xs font-medium 
                                {{ $userChallenge->is_completed ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }} 
                                px-2 py-1 rounded">
                        {{ $userChallenge->is_completed ? '✅ Selesai' : '🕒 Progress' }}
                    </span>
                    <span class="text-xs font-bold text-indigo-600">
                        +{{ $userChallenge->dailyChallenge->xp_reward }} XP
                    </span>
                </div>

                {{-- Title & Description --}}
                <p class="text-lg font-bold text-gray-700">
                    {{ $userChallenge->dailyChallenge->title }}
                </p>

                <p class="text-sm text-gray-500 mt-1 mb-4">
                    {{ $userChallenge->dailyChallenge->description }}
                </p>

                {{-- Progress Bar --}}
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $userChallenge->progress }}/{{ $userChallenge->dailyChallenge->target_count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $percentage = $userChallenge->dailyChallenge->target_count > 0 
                                ? round(($userChallenge->progress / $userChallenge->dailyChallenge->target_count) * 100)
                                : 0;
                        @endphp
                        <div class="h-2 rounded-full bg-indigo-500" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>

                {{-- Action Button --}}
                @if($userChallenge->is_completed)
                    <button class="mt-auto bg-green-500 text-white text-center py-2 rounded font-medium cursor-default">
                        🎉 Selesai
                    </button>
                @else
                    <button class="mt-auto bg-gray-400 text-white text-center py-2 rounded font-medium cursor-not-allowed">
                        Dalam Progress
                    </button>
                @endif
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($todayChallenges->hasPages())
        <div class="flex justify-center mt-8">
            <nav class="inline-flex rounded-md shadow-sm">
                {{-- Previous Page Link --}}
                @if($todayChallenges->onFirstPage())
                    <span class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-400 rounded-l-md cursor-not-allowed">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $todayChallenges->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 rounded-l-md hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </a>
                @endif

                {{-- Pagination Elements - MAX 10 Pages --}}
                @php
                    $current = $todayChallenges->currentPage();
                    $last = $todayChallenges->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                {{-- First Page --}}
                @if($start > 1)
                    <a href="{{ $todayChallenges->url(1) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
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
                    @if($page == $todayChallenges->currentPage())
                        <span class="inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-500 text-sm font-medium text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $todayChallenges->url($page) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
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
                    <a href="{{ $todayChallenges->url($last) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ $last }}
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if($todayChallenges->hasMorePages())
                    <a href="{{ $todayChallenges->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 rounded-r-md hover:bg-gray-50 transition-colors">
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

        {{-- Info Section --}}
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div>
                    <h4 class="font-semibold text-blue-800">Tips Meningkatkan Level</h4>
                    <p class="text-sm text-blue-600 mt-1">
                        Selesaikan daily challenges setiap hari untuk mendapatkan XP bonus dan naik level lebih cepat!
                        Challenge baru akan tersedia setiap hari.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection