@extends('layouts.app')

@section('title', 'Kelola Quiz')
@section('header-title', '📚 Kelola Quiz')
@section('header-subtitle', 'Buat dan kelola quiz Anda')

@section('content')
<div class="max-w-7xl mx-auto mt-8">
	<div class="mb-6">
        <a href="{{ route('teacher.dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 duration-200 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
			Kembali
        </a>
    </div>
    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Quiz</h2>
            <p class="text-gray-600">Total: {{ $quizzes->total() }} quiz</p>
        </div>
        <a href="{{ route('teacher.quiz.create') }}" 
           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors font-semibold">
            ➕ Buat Quiz Baru
        </a>
    </div>

    @if($quizzes->isEmpty())
    <div class="text-center py-12 bg-white rounded-xl shadow-sm border">
        <div class="text-6xl mb-4">📚</div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada quiz</h3>
        <p class="text-gray-500 mb-6">Mulai dengan membuat quiz pertama Anda!</p>
        <a href="{{ route('teacher.quiz.create') }}" 
           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors">
            Buat Quiz Pertama
        </a>
    </div>
    @else
    <!-- Quiz List -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">XP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($quizzes as $quiz)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $quiz->title }}</h4>
                                <p class="text-sm text-gray-500">{{ Str::limit($quiz->description, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                {{ $quiz->questions_count }} Soal
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            +{{ $quiz->xp }} XP
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($quiz->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                    ✅ Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                    ❌ Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('teacher.questions', $quiz->id) }}" 
                                   class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition-colors text-xs">
                                    ✏️ Soal
                                </a>
                                <a href="{{ route('teacher.quiz.results', $quiz->id) }}" 
                                   class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-500 transition-colors text-xs">
                                    📊 Hasil
                                </a>
                                
                                <!-- Toggle Status Button -->
                                <form action="{{ route('teacher.quiz.toggle', $quiz->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($quiz->is_active)
                                        <button type="submit" 
                                                class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-500 transition-colors text-xs">
                                            ⏸️ Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit" 
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-500 transition-colors text-xs">
                                            ▶️ Aktifkan
                                        </button>
                                    @endif
                                </form>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('teacher.quiz.delete', $quiz->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Hapus quiz ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 transition-colors text-xs">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($quizzes->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $quizzes->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection