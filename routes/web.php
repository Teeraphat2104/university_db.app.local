<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activities', function () {
    return view('activities');
});

Route::get('/activities/{id}', function () {
    return view('activity-detail');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/activities', function () {
    return view('admin.activities');
})->name('admin.activities');

Route::get('/admin/categories', function () {
    return view('admin.categories');
})->name('admin.categories.index');

Route::get('/admin/students', function () {
    return view('admin.dashboard');
});

Route::get('/admin/participants', function () {
    return view('admin.dashboard');
});

Route::get('/admin/reports', function () {
    return view('admin.dashboard');
});

Route::get('/admin/settings', function () {
    return view('admin.dashboard');
});
