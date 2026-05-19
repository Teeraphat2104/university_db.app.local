<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activities', function () {
    return view('activities');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/activities', function () {
    return view('admin.activities');
});

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
