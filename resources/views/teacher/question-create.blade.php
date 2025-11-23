@extends('layouts.app')

@section('title', 'Tambah Soal')
@section('header-title', '❓ Tambah Soal')
@section('header-subtitle', 'Tambah soal untuk: ' . $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('teacher.question.store', $quiz->id) }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Question -->
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan *</label>
                    <textarea name="question" id="question" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Tulis pertanyaan di sini..." required>{{ old('question') }}</textarea>
                    @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Choices -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Pilihan Jawaban *</label>
                    <div class="space-y-3" id="choices-container">
                        <!-- Choice 1 -->
                        <div class="flex items-center gap-3 p-3 border rounded-lg bg-white">
                            <span class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full text-sm font-bold">A</span>
                            <input type="text" name="choices[0][text]" 
                                   class="flex-1 border-none focus:ring-0 px-0 py-0"
                                   placeholder="Teks pilihan A" required>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="correct_choice" value="0" class="text-indigo-600" required>
                                <span class="text-sm text-gray-600">Benar</span>
                            </label>
                        </div>

                        <!-- Choice 2 -->
                        <div class="flex items-center gap-3 p-3 border rounded-lg bg-white">
                            <span class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full text-sm font-bold">B</span>
                            <input type="text" name="choices[1][text]" 
                                   class="flex-1 border-none focus:ring-0 px-0 py-0"
                                   placeholder="Teks pilihan B" required>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="correct_choice" value="1" class="text-indigo-600">
                                <span class="text-sm text-gray-600">Benar</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Add More Choices Button -->
                    <button type="button" onclick="addChoice()" 
                            class="mt-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                        ➕ Tambah Pilihan
                    </button>
                    
                    <p class="mt-2 text-sm text-gray-500">Minimal 2 pilihan, maksimal 5 pilihan</p>
                    @error('choices')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('correct_choice')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('teacher.questions', $quiz->id) }}" 
                       class="flex-1 px-4 py-2 bg-gray-500 text-white text-center rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors font-semibold">
                        Simpan Soal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let choiceCount = 2; // Mulai dari 2 pilihan
    
    function addChoice() {
        if (choiceCount >= 5) {
            alert('Maksimal 5 pilihan');
            return;
        }
        
        const choices = ['A', 'B', 'C', 'D', 'E'];
        const container = document.getElementById('choices-container');
        
        const choiceDiv = document.createElement('div');
        choiceDiv.className = 'flex items-center gap-3 p-3 border rounded-lg bg-white';
        choiceDiv.innerHTML = `
            <span class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full text-sm font-bold">
                ${choices[choiceCount]}
            </span>
            <input type="text" name="choices[${choiceCount}][text]" 
                   class="flex-1 border-none focus:ring-0 px-0 py-0"
                   placeholder="Teks pilihan ${choices[choiceCount]}" required>
            <label class="flex items-center gap-2">
                <input type="radio" name="correct_choice" value="${choiceCount}" class="text-indigo-600">
                <span class="text-sm text-gray-600">Benar</span>
            </label>
        `;
        
        container.appendChild(choiceDiv);
        choiceCount++;
    }
</script>
@endsection