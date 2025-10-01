<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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
//Route::get('/login', function () { / return view('auth.login');});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// fallback
Route::fallback(function () {
     return view('lib.notfound')
;});
