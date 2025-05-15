<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->name('auth.')->group(function () {
    Route::post('/auth/login', LoginController::class)->name('login');
    Route::post('/auth/register', RegisterController::class)->name('register');
});
