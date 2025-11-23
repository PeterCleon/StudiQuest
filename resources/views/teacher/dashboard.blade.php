@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('header-title', '👨‍🏫 Dashboard Guru')
@section('header-subtitle', 'Kelola quiz dan pantau siswa')

@section('content')
<div class="max-w-7xl mx-auto mt-8">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
            <div class="text-3xl font-bold text-indigo-600">{{ $totalQuizzes }}</div>
            <div class="text-sm text-gray-600">Total Quiz</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
            <div class="text-3xl font-bold text-green-600">{{ $totalQuestions }}</div>
            <div class="text-sm text-gray-600">Total Soal</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
            <div class="text-3xl font-bold text-blue-600">0</div>
            <div class="text-sm text-gray-600">Siswa Aktif</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('teacher.quizzes') }}" 
                   class="block w-full text-left px-4 py-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                   📚 Kelola Quiz
                </a>
                <a href="{{ route('teacher.quiz.create') }}" 
                   class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">
                   ➕ Buat Quiz Baru
                </a>
            </div>
        </div>

        <!-- Recent Quizzes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quiz Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentQuizzes as $quiz)
                <div class="flex justify-between items-center p-3 border rounded-lg">
                    <div>
                        <h4 class="font-semibold">{{ $quiz->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $quiz->questions_count ?? 0 }} Soal</p>
                    </div>
					<div>
						<a href="{{ route('teacher.quiz.results', $quiz->id) }}" 
							class="px-3 py-1 mx-2 bg-green-600 text-white rounded hover:bg-green-500 transition-colors text-xs">
							📊 Hasil
						</a>
						<a href="{{ route('teacher.questions', $quiz->id) }}" 
						class="px-3 py-1 mx-2 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition-colors">
							Kelola
						</a>
					</div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada quiz</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection