@extends('layouts.app')

@section('title', 'Hasil Quiz')
@section('header-title', '📊 Hasil Quiz')
@section('header-subtitle', 'Lihat hasil siswa untuk: ' . $quiz->title)

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h2>
            <p class="text-gray-600">{{ $results->count() }} Siswa mengerjakan</p>
        </div>
        <div class="mb-6">
        <a href="{{ route('teacher.quizzes') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 duration-200 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
			Kembali
        </a>
    </div>
    </div>

    @if($results->isEmpty())
    <div class="text-center py-12 bg-white rounded-xl shadow-sm border">
        <div class="text-6xl mb-4">📝</div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada hasil</h3>
        <p class="text-gray-500">Belum ada siswa yang mengerjakan quiz ini</p>
    </div>
    @else
    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($result->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ asset('storage/' . $result->avatar) }}" 
                                             alt="{{ $result->name }}">
                                    @else
                                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-indigo-600">
                                                {{ strtoupper(substr($result->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $result->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $result->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $result->kelas ?? '-' }} {{ $result->jurusan ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                {{ $result->pivot->score }} Poin
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $result->pivot->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
							<a href="{{ route('teacher.student.result.detail', [$quiz->id, $result->id]) }}" 
							class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition-colors text-xs">
								📋 Lihat Detail
							</a>
						</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-indigo-600">{{ $results->count() }}</div>
            <div class="text-sm text-gray-600">Total Peserta</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-green-600">
                {{ $results->max('pivot.score') }}
            </div>
            <div class="text-sm text-gray-600">Score Tertinggi</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-blue-600">
                {{ round($results->avg('pivot.score'), 1) }}
            </div>
            <div class="text-sm text-gray-600">Rata-rata Score</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-orange-600">
                {{ $results->min('pivot.score') }}
            </div>
            <div class="text-sm text-gray-600">Score Terendah</div>
        </div>
    </div>
    @endif
</div>
@endsection