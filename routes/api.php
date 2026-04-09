<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\HomeController;
use App\Http\Controllers\Api\Public\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\Public\ActivityController as PublicActivityController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\ActivityController as AdminActivityController;

/*
|--------------------------------------------------------------------------
| Public API Routes (No authentication required)
|--------------------------------------------------------------------------
*/
Route::prefix('public')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/categories', [PublicCategoryController::class, 'index']);
    Route::get('/activities', [PublicActivityController::class, 'index']);
    Route::get('/activities/{id}', [PublicActivityController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Public admin route — login only
    Route::post('/login', [AuthController::class, 'login']);

    // Protected admin routes — require Sanctum token + Admin model check
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        Route::apiResource('categories', AdminCategoryController::class);

        // Activities: support both PUT and POST+_method=PUT for file uploads
        Route::apiResource('activities', AdminActivityController::class);
    });
});
