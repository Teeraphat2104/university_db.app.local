<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/documents', function () {
    return view('documents.index');
})->name('documents.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');
