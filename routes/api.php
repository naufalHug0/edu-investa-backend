<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Middleware\AuthorizeAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::delete('logout', [AuthController::class, 'logout']);
            Route::patch('reset_password', [AuthController::class, 'reset_password']);
        });

        Route::prefix('admin')->group(function () {
            Route::post('register', [AdminController::class, 'register']);
            Route::post('login', [AuthController::class, 'login']);
    
            Route::middleware(['auth:sanctum', 'auth.admin'])->group(function () {
                Route::get('me', [AuthController::class, 'me']);
                Route::delete('logout', [AuthController::class, 'logout']);
                Route::patch('reset_password', [AuthController::class, 'reset_password']);
            });
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('quiz')->group(function () {
            Route::get('/', [QuizController::class, 'index']);
            Route::get('/{id}', [QuizController::class, 'show'])->where('id', '[0-9]+');

            Route::middleware('auth.admin')->group(function () {
                Route::post('/', [QuizController::class, 'create']);

                Route::prefix('{id}/question')->group(function () { 
                    Route::post('/', [QuestionController::class, 'create'])->where('id', '[0-9]+');
                });
            });
        });
        
    });
});
