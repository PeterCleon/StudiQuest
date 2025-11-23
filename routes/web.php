<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::middleware(['auth'])->group(callback: function () {
    Route::get('/', [Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/add-xp', [Controllers\DashboardController::class, 'addXp'])
    ->name('add.xp')
    ->middleware('auth');


Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/quizzes', [Controllers\QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quizzes/start/{id}', [Controllers\QuizController::class, 'start'])->name('quiz.start')->middleware(['auth', 'quiz.access']);
    Route::post('/quizzes/submit/{id}', [Controllers\QuizController::class, 'submit'])->name('quiz.submit')->middleware(['auth', 'quiz.access']);
    Route::get('/quizzes/{id}/result', [Controllers\QuizController::class, 'result'])->name('quiz.result');
    Route::get('/quizzes/history', [Controllers\QuizController::class, 'history'])->name('quiz.history');
    Route::get('/challenges/daily', [Controllers\DailyChallengeController::class, 'index'])->name('challenges.daily');
    Route::post('/challenges/generate-manual', [Controllers\DailyChallengeController::class, 'generateManually'])
        ->name('challenges.generate.manual');
});

Route::get('/login', [Controllers\LoginController::class, 'index'])->name('login')->middleware(['guest']);

Route::get('/register', [Controllers\RegisterController::class, 'index'])->name('register')->middleware(['guest']);

Route::post('/register', [Controllers\RegisterController::class, 'register'])->name('register')->middleware(['guest']);

Route::post('/login', [Controllers\LoginController::class, 'login'])->name('login')->middleware(['guest']);

Route::post('/logout', [Controllers\LogoutController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [Controllers\TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/quizzes', [Controllers\TeacherController::class, 'quizzes'])->name('teacher.quizzes');
    Route::get('/quiz/create', [Controllers\TeacherController::class, 'createQuiz'])->name('teacher.quiz.create');
    Route::post('/quiz/store', [Controllers\TeacherController::class, 'storeQuiz'])->name('teacher.quiz.store');
    Route::get('/quiz/{quizId}/questions', [Controllers\TeacherController::class, 'questions'])->name('teacher.questions');
    Route::get('/quiz/{quizId}/question/create', [Controllers\TeacherController::class, 'createQuestion'])->name('teacher.question.create');
    Route::post('/quiz/{quizId}/question/store', [Controllers\TeacherController::class, 'storeQuestion'])->name('teacher.question.store');
    Route::get('/quiz/{quizId}/results', [Controllers\TeacherController::class, 'quizResults'])->name('teacher.quiz.results');
    Route::patch('/quiz/{quizId}/toggle', [Controllers\TeacherController::class, 'toggleQuizStatus'])->name('teacher.quiz.toggle');
    Route::delete('/quiz/{quizId}/delete', [Controllers\TeacherController::class, 'deleteQuiz'])->name('teacher.quiz.delete');
    Route::get('/quiz/{quizId}/student/{studentId}/detail', [Controllers\TeacherController::class, 'studentResultDetail'])->name('teacher.student.result.detail');
});