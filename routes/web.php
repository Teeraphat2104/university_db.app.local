<?php

use App\Actions\Web\Admin\Activities\CreateAction as CreateAdminActivityAction;
use App\Actions\Web\Admin\Activities\DeleteAction as DeleteAdminActivityAction;
use App\Actions\Web\Admin\Activities\EditAction as EditAdminActivityAction;
use App\Actions\Web\Admin\Activities\IndexAction as ListAdminActivitiesAction;
use App\Actions\Web\Admin\Activities\ShowAction as ShowAdminActivityAction;
use App\Actions\Web\Admin\Activities\StoreAction as StoreAdminActivityAction;
use App\Actions\Web\Admin\Activities\UpdateAction as UpdateAdminActivityAction;
use App\Actions\Web\Admin\Categories\CreateAction as CreateAdminCategoryAction;
use App\Actions\Web\Admin\Categories\DeleteAction as DeleteAdminCategoryAction;
use App\Actions\Web\Admin\Categories\EditAction as EditAdminCategoryAction;
use App\Actions\Web\Admin\Categories\IndexAction as ListAdminCategoriesAction;
use App\Actions\Web\Admin\Categories\StoreAction as StoreAdminCategoryAction;
use App\Actions\Web\Admin\Categories\UpdateAction as UpdateAdminCategoryAction;
use App\Actions\Web\Admin\Auth\LoginAction as AdminLoginAction;
use App\Actions\Web\Admin\Auth\LogoutAction as AdminLogoutAction;
use App\Actions\Web\Admin\Auth\ShowLoginAction;
use App\Actions\Web\Admin\Dashboard\IndexAction as AdminDashboardAction;
use App\Actions\Web\Public\Activities\IndexAction as ListPublicActivitiesAction;
use App\Actions\Web\Public\Activities\ShowAction as ShowPublicActivityAction;
use App\Actions\Web\Public\HomeAction;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeAction::class)->name('home');
Route::get('/activities', ListPublicActivitiesAction::class)->name('activities.index');
Route::get('/activities/{activity}', ShowPublicActivityAction::class)
    ->whereNumber('activity')
    ->name('activities.show');
Route::get('/search', ListPublicActivitiesAction::class)->name('activities.search');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', ShowLoginAction::class)->name('login');
        Route::post('/login', AdminLoginAction::class)->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('/logout', AdminLogoutAction::class)->name('logout');
        Route::get('/dashboard', AdminDashboardAction::class)->name('dashboard');

        Route::get('/activities', ListAdminActivitiesAction::class)->name('activities.index');
        Route::get('/activities/create', CreateAdminActivityAction::class)->name('activities.create');
        Route::post('/activities', StoreAdminActivityAction::class)->name('activities.store');
        Route::get('/activities/{activity}', ShowAdminActivityAction::class)
            ->whereNumber('activity')
            ->name('activities.show');
        Route::get('/activities/{activity}/edit', EditAdminActivityAction::class)
            ->whereNumber('activity')
            ->name('activities.edit');
        Route::put('/activities/{activity}', UpdateAdminActivityAction::class)
            ->whereNumber('activity')
            ->name('activities.update');
        Route::delete('/activities/{activity}', DeleteAdminActivityAction::class)
            ->whereNumber('activity')
            ->name('activities.destroy');

        Route::get('/categories', ListAdminCategoriesAction::class)->name('categories.index');
        Route::get('/categories/create', CreateAdminCategoryAction::class)->name('categories.create');
        Route::post('/categories', StoreAdminCategoryAction::class)->name('categories.store');
        Route::get('/categories/{category}/edit', EditAdminCategoryAction::class)
            ->whereNumber('category')
            ->name('categories.edit');
        Route::put('/categories/{category}', UpdateAdminCategoryAction::class)
            ->whereNumber('category')
            ->name('categories.update');
        Route::delete('/categories/{category}', DeleteAdminCategoryAction::class)
            ->whereNumber('category')
            ->name('categories.destroy');
    });
});
