<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\Public\ActivitiesController as PublicActivitiesController;
use App\Http\Controllers\Web\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\ActivitiesController as AdminActivitiesController;
use App\Http\Controllers\Web\Admin\CategoriesController as AdminCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, '__invoke'])->name('home');
Route::get('/activities', [PublicActivitiesController::class, 'index'])->name('activities.index');
Route::get('/activities/{activity}', [PublicActivitiesController::class, 'show'])
    ->whereNumber('activity')
    ->name('activities.show');
Route::get('/search', [PublicActivitiesController::class, 'index'])->name('activities.search');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/activities', [AdminActivitiesController::class, 'index'])->name('activities.index');
        Route::get('/activities/create', [AdminActivitiesController::class, 'create'])->name('activities.create');
        Route::post('/activities', [AdminActivitiesController::class, 'store'])->name('activities.store');
        Route::get('/activities/{activity}', [AdminActivitiesController::class, 'show'])
            ->whereNumber('activity')
            ->name('activities.show');
        Route::get('/activities/{activity}/edit', [AdminActivitiesController::class, 'edit'])
            ->whereNumber('activity')
            ->name('activities.edit');
        Route::put('/activities/{activity}', [AdminActivitiesController::class, 'update'])
            ->whereNumber('activity')
            ->name('activities.update');
        Route::delete('/activities/{activity}', [AdminActivitiesController::class, 'destroy'])
            ->whereNumber('activity')
            ->name('activities.destroy');

        Route::get('/categories', [AdminCategoriesController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategoriesController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategoriesController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoriesController::class, 'edit'])
            ->whereNumber('category')
            ->name('categories.edit');
        Route::put('/categories/{category}', [AdminCategoriesController::class, 'update'])
            ->whereNumber('category')
            ->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoriesController::class, 'destroy'])
            ->whereNumber('category')
            ->name('categories.destroy');
    });
});