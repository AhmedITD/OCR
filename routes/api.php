<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OcrController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// OCR Status (public)
Route::get('ocr/status', [OcrController::class, 'status']);
Route::get('ocr/rate-limit', [OcrController::class, 'rateLimit']);

// Demo OCR route (no authentication, uses rate limiting by IP)
Route::post('ocr/demo/upload', [OcrController::class, 'upload'])
    ->middleware('ocr.rate_limit');

// Protected routes (require JWT authentication)
Route::middleware('jwt.auth')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    // OCR routes (authenticated)
    Route::prefix('ocr')->group(function () {
        Route::post('upload', [OcrController::class, 'upload']);
        Route::get('files/{id}', [OcrController::class, 'show']);
        Route::get('history', [OcrController::class, 'history']);
    });
});

