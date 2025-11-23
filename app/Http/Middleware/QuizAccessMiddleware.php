<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use Symfony\Component\HttpFoundation\Response;

class QuizAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $quizId = $request->route('id'); // Ambil ID dari route
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $quiz = Quiz::find($quizId);
        
        if (!$quiz) {
            abort(404, 'Quiz tidak ditemukan');
        }

        // Cek apakah user sudah mengerjakan quiz ini
        $alreadyTaken = $user->quizzes()->where('quiz_id', $quizId)->exists();
        
        if ($alreadyTaken) {
            return redirect()->route('quiz.result', $quizId)
                           ->with('error', 'Kamu sudah mengerjakan quiz ini sebelumnya.');
        }

        return $next($request);
    }
}