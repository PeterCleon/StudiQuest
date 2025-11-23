@extends('layouts.app')

@section('title', 'Buat Quiz Baru')
@section('header-title', '➕ Buat Quiz Baru')
@section('header-subtitle', 'Buat quiz baru untuk siswa')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('teacher.quiz.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Quiz Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Quiz *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Contoh: Quiz Dasar Pemrograman" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Deskripsi singkat tentang quiz ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- XP Reward -->
                <div>
                    <label for="xp" class="block text-sm font-medium text-gray-700">XP Reward *</label>
                    <input type="number" name="xp" id="xp" value="{{ old('xp', 50) }}" min="10" max="1000"
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                    <p class="mt-1 text-sm text-gray-500">XP yang didapat siswa saat menyelesaikan quiz (10-1000)</p>
                    @error('xp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="text-blue-600 text-lg">💡</div>
                        <div>
                            <h4 class="font-semibold text-blue-800">Info</h4>
                            <p class="text-sm text-blue-600 mt-1">
                                Setelah membuat quiz, Anda dapat menambahkan soal-soal pada halaman kelola quiz.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('teacher.quizzes') }}" 
                       class="flex-1 px-4 py-2 bg-gray-500 text-white text-center rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors font-semibold">
                        Buat Quiz
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection