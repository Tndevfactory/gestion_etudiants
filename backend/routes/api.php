<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\RoleController;

// Route test simple
Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne']);
});

// Routes Auth (register/login) - pas besoin de CSRF pour Bearer token
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// Routes protégées par Sanctum avec Bearer token
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/me', [ApiAuthController::class, 'me']);

    // CRUD complet pour roles
    Route::apiResource('roles', RoleController::class);
});
