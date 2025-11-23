@extends('layouts.app')

@section('title', $quiz->title)
@section('header-title', $quiz->title)
@section('header-subtitle', 'Kerjakan quiz dengan fokus satu per satu!')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-xl border border-gray-200">

    {{-- TITLE --}}
    <h2 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h2>
    <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>

    {{-- Progress --}}
    <div class="mb-4 text-sm font-semibold text-gray-700" id="progressText">
        Soal 1 dari {{ $quiz->questions->count() }}
    </div>

    <form id="quizForm" action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
        @csrf

        {{-- =====================
            SOAL (Hidden Semua)
        ===================== --}}
        @foreach ($quiz->questions as $index => $question)
            <div class="question-item hidden" data-index="{{ $index }}">

                <p class="font-bold mb-4">
                    {{ $question->question }}
                </p>

                {{-- Pilihan A/B/C/D --}}
                @foreach ($question->choices as $i => $choice)
                    <button 
                        type="button"
                        class="w-full flex items-center gap-4 p-4 border rounded-xl mb-3 
                               hover:bg-study-primary/10 transition font-semibold text-left choice-btn"
                        data-question="{{ $question->id }}"
                        data-choice="{{ $choice->id }}"
                    >
                        <span class="w-10 h-10 flex items-center justify-center rounded-full 
                                     bg-study-primary text-white font-bold">
                            {{ chr(65 + $i) }}
                        </span>
                        {{ $choice->choice }}
                    </button>
                @endforeach

            </div>
        @endforeach

        {{-- Submit Final --}}
        <button id="finishButton" type="submit"
            class="hidden mt-6 w-full bg-study-secondary text-white py-3 rounded-xl font-bold">
            Selesai Quiz
        </button>

    </form>
</div>

<script>
    let current = 0;
    const questions = document.querySelectorAll('.question-item');
    const total = questions.length;

    // Tampilkan soal pertama
    questions[0].classList.remove('hidden');

    // Update progress text
    function updateProgress() {
        document.getElementById("progressText").innerText =
            `Soal ${current + 1} dari ${total}`;
    }

    updateProgress();

    // Pilihan jawaban button event
    document.querySelectorAll('.choice-btn').forEach(btn => {
        btn.addEventListener('click', () => {

            // Save jawaban ke hidden input
            let qId = btn.dataset.question;
            let cId = btn.dataset.choice;

            let inputName = `question_${qId}`;

            let existing = document.querySelector(`input[name="${inputName}"]`);
            if (existing) existing.remove();

            // Tambahkan input
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = inputName;
            input.value = cId;
            document.getElementById("quizForm").appendChild(input);

            // Pindah soal berikutnya
            questions[current].classList.add('hidden');
            current++;

            if (current < total) {
                questions[current].classList.remove('hidden');
                updateProgress();
            } else {
                // Habis soal → tampilkan tombol finish
                document.getElementById("progressText").innerText =
                    `Semua soal terjawab`;
                document.getElementById("finishButton").classList.remove('hidden');
            }
        });
    });
</script>

@endsection
