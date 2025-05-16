<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobAdController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->name('auth.')->group(function () {
    Route::post('auth/login', LoginController::class)->name('login');
    Route::post('auth/register', RegisterController::class)->name('register');
});

Route::middleware([JwtMiddleware::class])->name('auth.')->group(function () {
    Route::post('auth/refresh', RefreshTokenController::class)->name('refresh');
});

Route::middleware([JwtMiddleware::class])->name('job-ad.')->group(function () {
    Route::post('job-ad', [JobAdController::class, 'store'])->name('store');
});
