<?php

use App\Actions\Api\V1\Activities\DeleteAction as DeleteActivityAction;
use App\Actions\Api\V1\Activities\IndexAction as ListActivitiesAction;
use App\Actions\Api\V1\Activities\ShowAction as ShowActivityAction;
use App\Actions\Api\V1\Activities\StoreAction as StoreActivityAction;
use App\Actions\Api\V1\Activities\UpdateAction as UpdateActivityAction;
use App\Actions\Api\V1\Activities\UploadDocumentAction;
use App\Actions\Api\V1\Auth\LoginAction;
use App\Actions\Api\V1\Auth\LogoutAction;
use App\Actions\Api\V1\Categories\DeleteAction as DeleteCategoryAction;
use App\Actions\Api\V1\Categories\IndexAction as ListCategoriesAction;
use App\Actions\Api\V1\Categories\StoreAction as StoreCategoryAction;
use App\Actions\Api\V1\Categories\UpdateAction as UpdateCategoryAction;
use App\Actions\Api\V1\Documents\DeleteAction as DeleteDocumentAction;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('/login', LoginAction::class)->name('api.v1.auth.login');

    Route::post('/logout', LogoutAction::class)
        ->middleware(['auth', 'admin'])
        ->name('api.v1.auth.logout');
});

Route::get('/activities', ListActivitiesAction::class)->name('api.v1.activities.index');
Route::get('/activities/{id}', ShowActivityAction::class)->whereNumber('id')->name('api.v1.activities.show');
Route::get('/categories', ListCategoriesAction::class)->name('api.v1.categories.index');

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::post('/activities', StoreActivityAction::class)->name('api.v1.activities.store');
    Route::put('/activities/{id}', UpdateActivityAction::class)->whereNumber('id')->name('api.v1.activities.update');
    Route::delete('/activities/{id}', DeleteActivityAction::class)->whereNumber('id')->name('api.v1.activities.destroy');

    Route::post('/categories', StoreCategoryAction::class)->name('api.v1.categories.store');
    Route::put('/categories/{id}', UpdateCategoryAction::class)->whereNumber('id')->name('api.v1.categories.update');
    Route::delete('/categories/{id}', DeleteCategoryAction::class)->whereNumber('id')->name('api.v1.categories.destroy');

    Route::post('/activities/{id}/documents', UploadDocumentAction::class)
        ->whereNumber('id')
        ->name('api.v1.documents.store');

    Route::delete('/documents/{id}', DeleteDocumentAction::class)
        ->whereNumber('id')
        ->name('api.v1.documents.destroy');
});
