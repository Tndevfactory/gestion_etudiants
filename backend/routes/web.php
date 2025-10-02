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

route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});


//Admin Routes
route::middleware(['auth', 'role'])->group(function () {
    Route::get('/admin', function () {return view('admin.Dashboard');})

->name('dashboard');
});


// auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// fallback
Route::fallback(function () {
     return view('lib.notfound')
;});
