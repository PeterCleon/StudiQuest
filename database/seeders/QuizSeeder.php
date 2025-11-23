<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // === QUIZ ===
        $quiz = Quiz::create([
            'title' => 'Dasar Pemrograman',
            'description' => 'Quiz untuk menguji pengetahuan dasar coding.',
            'xp' => 150,
        ]);

        // === SOAL 1 ===
        $q1 = Question::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa kepanjangan dari HTML?',
        ]);

        Choice::insert([
            ['question_id' => $q1->id, 'choice' => 'Hyper Text Markup Language', 'is_correct' => true],
            ['question_id' => $q1->id, 'choice' => 'HighText Machine Language', 'is_correct' => false],
            ['question_id' => $q1->id, 'choice' => 'Hyper Tool Multi Language', 'is_correct' => false],
            ['question_id' => $q1->id, 'choice' => 'Hyperlinks Text Mode Language', 'is_correct' => false],
        ]);

        // === SOAL 2 ===
        $q2 = Question::create([
            'quiz_id' => $quiz->id,
            'question' => 'Mana yang termasuk bahasa pemrograman?',
        ]);

        Choice::insert([
            ['question_id' => $q2->id, 'choice' => 'Python', 'is_correct' => true],
            ['question_id' => $q2->id, 'choice' => 'Chrome', 'is_correct' => false],
            ['question_id' => $q2->id, 'choice' => 'Google', 'is_correct' => false],
            ['question_id' => $q2->id, 'choice' => 'HTML', 'is_correct' => false],
        ]);

        // === SOAL 3 ===
        $q3 = Question::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa fungsi dari if dalam pemrograman?',
        ]);

        Choice::insert([
            ['question_id' => $q3->id, 'choice' => 'Untuk mengambil keputusan berdasarkan kondisi tertentu', 'is_correct' => true],
            ['question_id' => $q3->id, 'choice' => 'Untuk mencetak teks ke layar', 'is_correct' => false],
            ['question_id' => $q3->id, 'choice' => 'Untuk mengulang perintah', 'is_correct' => false],
            ['question_id' => $q3->id, 'choice' => 'Untuk menghentikan program', 'is_correct' => false],
        ]);
    }
}
