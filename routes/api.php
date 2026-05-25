<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;

Route::prefix('public')->group(function () {
    Route::post('/home',                [PublicController::class, 'home']);
    Route::post('/categories',          [PublicController::class, 'categories']);
    Route::post('/activities',          [PublicController::class, 'activities']);
    Route::post('/activities/detail/{id}', [PublicController::class, 'activityDetail']);
    Route::post('/search',              [PublicController::class, 'search']);
    Route::post('/activities/{id}/track', [PublicController::class, 'getViewDownload']);
});

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/logout',  [AdminAuthController::class, 'logout']);
        Route::post('/profile', [AdminAuthController::class, 'profile']);

        Route::post('/categories/list',      [CategoryController::class, 'index']);
        Route::post('/categories/store',      [CategoryController::class, 'store']);
        Route::post('/categories/detail/{id}', [CategoryController::class, 'show']);
        Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
        Route::post('/categories/delete/{id}', [CategoryController::class, 'destroy']);

        Route::post('/activities/list',       [ActivityController::class, 'index']);
        Route::post('/activities/store',       [ActivityController::class, 'store']);
        Route::post('/activities/detail/{id}',  [ActivityController::class, 'show']);
        Route::post('/activities/update/{id}',  [ActivityController::class, 'update']);
        Route::post('/activities/delete/{id}',  [ActivityController::class, 'destroy']);

        Route::post('/settings',        [SettingController::class, 'index']);
        Route::post('/settings/update', [SettingController::class, 'update']);

        Route::post('/activities/{id}/import-excel',      [ActivityController::class, 'importExcel']);
        Route::post('/activities/{id}/participants',       [ActivityController::class, 'participants']);
        Route::post('/activities/{id}/participants/clear',  [ActivityController::class, 'clearParticipants']);

        Route::post('/dashboard', [DashboardController::class, 'index']);
    });
});
