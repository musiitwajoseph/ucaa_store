<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Public Support Route (accessible without authentication)
Route::get('/support', function () {
    return view('support');
})->name('support.public');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::put('/profile', [LoginController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [LoginController::class, 'updatePassword'])->name('profile.password');

    // Example: Route for a specific page
    Route::get('/example', function () {
        return view('example');
    });
});
