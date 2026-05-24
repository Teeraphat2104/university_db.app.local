<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Public API Routes (No authentication required)
|--------------------------------------------------------------------------
*/
Route::prefix('public')->group(function () {
    Route::get('/home',            [PublicController::class, 'home']);
    Route::get('/categories',      [PublicController::class, 'categories']);
    Route::get('/activities',      [PublicController::class, 'activities']);
    Route::get('/activities/{id}', [PublicController::class, 'activityDetail']);
    Route::get('/search',          [PublicController::class, 'search']);
    Route::post('/activities/{id}/track', [PublicController::class, 'getViewDownload']);
});

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Public admin route — login only
    Route::post('/login', [AdminAuthController::class, 'login']);

    // Protected admin routes — require Sanctum token + Admin model check
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/logout',  [AdminAuthController::class, 'logout']);
        Route::get('/profile',  [AdminAuthController::class, 'profile']);

        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('activities', ActivityController::class);

        // Settings management
        Route::get('/settings',  [SettingController::class, 'index']);
        Route::put('/settings',  [SettingController::class, 'update']);

        // Excel import & participants management
        Route::post('/activities/{id}/import-excel',     [ActivityController::class, 'importExcel']);
        Route::get('/activities/{id}/participants',      [ActivityController::class, 'participants']);
        Route::delete('/activities/{id}/participants',   [ActivityController::class, 'clearParticipants']);
    });
});
