@extends('layouts.app')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')
@section('header-subtitle', 'Selamat datang kembali, ' . ($user->name ?? 'User') . ' 👋')

@section('content')
@if($user->role === 'guru')
    {{ route('teacher.dashboard') }}
@endif

<div class="p-6 flex gap-6">

    <!-- LEFT CONTENT -->
    <div class="flex-1 space-y-8">

        <!-- PROGRESS LEVEL -->
        <div>
            <h2 class="text-xl font-bold text-gray-700 mb-3">
                Progress Level
            </h2>

            <div class="border p-6 bg-white shadow-sm hover:shadow-md transition rounded-xl">
                <div class="flex items-center gap-6">
                    
                    <!-- LEVEL BOX -->
                    <div class="w-28 h-28 border rounded-lg flex flex-col 
                                items-center justify-center bg-gray-50">
                        <p class="text-sm text-gray-600 font-medium">Level</p>
                        <p class="text-4xl font-extrabold text-indigo-500">
                            {{ $player->level }}
                        </p>
                    </div>

                    <!-- XP BAR SECTION -->
                    <div class="flex-1">
                        <p class="font-semibold text-gray-700 mb-2">Progress Level</p>

                        <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                            <div class="h-3 bg-indigo-500 rounded-full transition-all"
                                style="width: {{ ($player->xp / $player->xp_needed) * 100 }}%">
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mt-2">
                            {{ $player->xp }} / {{ $player->xp_needed }} XP
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUIZ -->
        <div>
            <a href="{{ route('quiz.index') }}" class="text-xl font-bold text-gray-700">Quiz -></a>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                @if($quizzes->isEmpty())
                    <p class="text-gray-600">Belum ada quiz tersedia.</p>
                @endif
                @foreach($quizzes->take(6) as $quiz)
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
        </div>
    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="w-80">

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-xl font-bold text-gray-700">Challenge</h2>
            <a href="{{ route('challenges.daily') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Lihat semua -></a>
        </div>

        <div class="space-y-4">
            {{-- PERBAIKAN: Gunakan count() untuk array --}}
            @if(count($userChallenges) === 0)
                <p class="text-gray-600 text-center py-4">Tidak ada challenge hari ini</p>
            @else
                @foreach($userChallenges as $userChallenge)
                <div class="border p-5 flex flex-col bg-white shadow-sm hover:shadow-md transition rounded-xl 
                            {{ $userChallenge->is_completed ? 'border-green-400 bg-green-50' : '' }}">

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

                    <p class="text-lg font-bold text-gray-700">
                        {{ $userChallenge->dailyChallenge->title }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1 mb-4">
                        {{ $userChallenge->dailyChallenge->description }}
                    </p>

                    <div class="mb-3">
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
                            <div class="h-2 rounded-full 
                                        {{ $userChallenge->is_completed ? 'bg-green-500' : 'bg-indigo-500' }}" 
                                style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

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
            @endif
        </div>

    </div>

</div>

@endsection