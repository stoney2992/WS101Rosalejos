<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\RewardController;
use App\Http\Controllers\Api\MathGameController;
use App\Http\Controllers\Api\AssignClassController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', function () {
    return 'API is working';
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Pupil-specific routes
    Route::get('/myclass-pupils', [AssignClassController::class, 'myclassPupils']);
    Route::get('/mylesson-pupils/{class_id}', [AssignClassController::class, 'mylessonPupils']);
    
    Route::get('/view-quizzes/{class_id}', [AssignClassController::class, 'viewQuizzes']);

    Route::get('/quiz/{id}', [QuizController::class, 'show']);
    Route::post('/quiz/submit/{quizId}', [QuizController::class, 'submit']);

    Route::get('/rewards', [RewardController::class, 'index']);
    Route::post('/rewards/claim/{rewardId}', [RewardController::class, 'claim']);

    Route::get('/math-game', [MathGameController::class, 'index']);
    Route::post('/math-game/submit', [MathGameController::class, 'submit']);
});


