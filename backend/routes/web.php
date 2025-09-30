<?php

use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('home.Accueil');
});

Route::get('/about', function () {
    return view('home.About');
});

Route::get('/contact', function () {
    return view('home.Contact');
});

// Admin Routes
Route::get('/admin', function () {
    return view('admin.Dashboard');
});

// auth Routes
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

// fallback
Route::fallback(function () {
     return view('lib.notfound')
;});
