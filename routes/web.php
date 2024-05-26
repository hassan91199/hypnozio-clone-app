<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $queryParams = [
        'cid' => request()->query('cid'),
        'sid' => request()->query('sid'),
    ];

    $funnelParams = http_build_query($queryParams);

    $quizLink = route('quiz') . '?' . $funnelParams;

    $maleQuizLink = "$quizLink&g=m";
    $femaleQuizLink = "$quizLink&g=f";
    $otherQuizLink = "$quizLink&g=o";

    return view('landing', compact('maleQuizLink', 'femaleQuizLink', 'otherQuizLink'));
});

Route::get('/quiz', function () {
    return view('quiz.index');
})->name('quiz');

Route::post('/quiz', [QuizController::class, 'submit'])->name('submit-quiz');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');
