<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetChangeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InvestmentAssetController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionLevelController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RiskProfileController;
use App\Http\Controllers\ShortsController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\UserInvestmentChangeController;
use App\Http\Controllers\UserInvestmentController;
use App\Http\Controllers\UserSkillsInventoryController;
use App\Http\Controllers\UserXpController;
use App\Http\Middleware\AuthorizeAdmin;
use App\Models\Asset_change;
use App\Models\Question_level;
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

        Route::middleware(['auth:sanctum', 'auth.user'])->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::delete('logout', [AuthController::class, 'logout']);
            Route::patch('reset_password', [AuthController::class, 'reset_password']);
        });

        Route::prefix('admin')->group(function () {
            Route::post('register', [AdminController::class, 'register']);
            Route::post('login', [AdminController::class, 'login']);
    
            Route::middleware(['auth:sanctum', 'auth.admin'])->group(function () {
                Route::get('me', [AuthController::class, 'me']);
                Route::delete('logout', [AuthController::class, 'logout']);
                Route::patch('reset_password', [AuthController::class, 'reset_password']);
            });
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('xp')->group(function () {
            Route::get('/', [UserXpController::class, 'index']);
            Route::middleware('auth.user')->group(function () {
                Route::patch('/', [UserXpController::class, 'update']);
            });
        });

        Route::prefix('quiz')->group(function () {
            Route::get('/', [QuizController::class, 'index']);
            Route::get('/{id}', [QuizController::class, 'show'])->where('id', '[0-9]+');
            Route::get('/levels', [QuestionLevelController::class, 'index']);

            Route::prefix('{id}/question')->group(function () {
                Route::get('/{offset}', [QuestionController::class, 'show'])->where('id', '[0-9]+');
            });

            Route::middleware('auth.admin')->group(function () {
                Route::post('/', [QuizController::class, 'create']);
    
                Route::prefix('{id}/question')->group(function () {
                    Route::post('/', [QuestionController::class, 'create'])->where('id', '[0-9]+');
                });
            });
        });

        Route::prefix('shorts')->group(function () {
            Route::get('/', [ShortsController::class, 'index']);
            Route::get('/{id}', [ShortsController::class, 'show'])->where('id', '[0-9]+');

            Route::middleware('auth.admin')->group(function () {
                Route::post('/', [ShortsController::class, 'create']);
            });
        });

        Route::prefix('course')->group(function () {
            Route::get('/', [CourseController::class, 'index']);
            Route::get('/{id}', [CourseController::class, 'show'])->where('id', '[0-9]+');

            Route::middleware('auth.admin')->group(function () {
                Route::post('/', [CourseController::class, 'create']);
            });
        });

        Route::prefix('investment')->group(function () {
            Route::middleware('auth.user')->group(function () {
                Route::get('/', [UserInvestmentController::class, 'index']);

                Route::prefix('buy')->group(function () {
                    Route::get('/list', [InvestmentAssetController::class, 'getAllCurrentPrice']);
                });
            });
            
            Route::get('/asset-changes', [AssetChangeController::class, 'index']);
            Route::get('/risk-profiles', [RiskProfileController::class, 'index']);
        });

        Route::prefix('skills')->group(function () { 
            Route::get('/', [SkillsController::class, 'index']);

            Route::middleware('auth.user')->group(function () {
                Route::get('/me', [UserSkillsInventoryController::class, 'index']);
                Route::post('/buy/{id}', [SkillsController::class, 'buy'])->where('id', '[0-9]+');
            });
            
            Route::middleware('auth.admin')->group(function () {
                Route::post('/', [SkillsController::class, 'create']);
            });
        });
    });
});
