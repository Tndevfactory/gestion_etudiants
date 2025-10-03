<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Public Routes
Route::get('/', function () {
    return view('home.Accueil');
})->name('home');

Route::get('/about', function () {
    return view('home.About');
});

Route::get('/contact', function () {
    return view('home.Contact');
});

// auth Routes for guests only
route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});
// auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Admin Routes
route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () { return view('admin.Dashboard');})->name('dashboard');
        Route::resource('users', UserController::class);

    });
});
//teacher Routes
route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher', function () {
        return view('espace_enseignants.Dashboard');
    })
        ->name('dashboard.teacher');
});
//students Routes
route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student', function () {
        return view('espace_etudiants.Dashboard');
    })
        ->name('dashboard.student');

    Route::resource('/students', StudentController::class);
    Route::get('students/{id}/pdf', [StudentController::class, 'generatePdf'])->name('students.pdf');

});
// fallback
Route::fallback(function () {
    return view('lib.notfound');
});
