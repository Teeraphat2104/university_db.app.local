<?php

use App\Http\Controllers\Api\V1\ActivitiesController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\DocumentsController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('/login', [AuthController::class, 'login'])->name('api.v1.auth.login');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware(['auth', 'admin'])
        ->name('api.v1.auth.logout');
});

Route::get('/activities', [ActivitiesController::class, 'index'])->name('api.v1.activities.index');
Route::get('/activities/{id}', [ActivitiesController::class, 'show'])->whereNumber('id')->name('api.v1.activities.show');
Route::get('/categories', [CategoriesController::class, 'index'])->name('api.v1.categories.index');

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::post('/activities', [ActivitiesController::class, 'store'])->name('api.v1.activities.store');
    Route::put('/activities/{id}', [ActivitiesController::class, 'update'])->whereNumber('id')->name('api.v1.activities.update');
    Route::delete('/activities/{id}', [ActivitiesController::class, 'destroy'])->whereNumber('id')->name('api.v1.activities.destroy');

    Route::post('/categories', [CategoriesController::class, 'store'])->name('api.v1.categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->whereNumber('id')->name('api.v1.categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->whereNumber('id')->name('api.v1.categories.destroy');

    Route::post('/activities/{id}/documents', [ActivitiesController::class, 'uploadDocument'])
        ->whereNumber('id')
        ->name('api.v1.documents.store');

    Route::delete('/documents/{id}', [DocumentsController::class, 'destroy'])
        ->whereNumber('id')
        ->name('api.v1.documents.destroy');
});