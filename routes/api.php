<?php

use App\Http\Controllers\Auth\CurrentUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Job\JobAdApproveController;
use App\Http\Controllers\Job\JobAdController;
use App\Http\Controllers\Job\JobAdRejectController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\UserReadNotificationController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->name('auth.')
    ->group(function () {
        Route::post('auth/login', LoginController::class)->name('login');
        Route::post('auth/register', RegisterController::class)->name(
            'register'
        );
    });

Route::middleware([JwtMiddleware::class])
    ->name('auth.')
    ->group(function () {
        Route::post('auth/refresh', RefreshTokenController::class)->name(
            'refresh'
        );
        Route::get('auth/current', CurrentUserController::class)->name(
            'current'
        );
    });

Route::name('job-ad.')->group(function () {
    Route::get('job-ad/{id}', [JobAdController::class, 'show'])->name('show');
    Route::get('job-ad', [JobAdController::class, 'index'])->name('index');
});

Route::middleware([JwtMiddleware::class])
    ->name('job-ad.')
    ->group(function () {
        Route::post('job-ad', [JobAdController::class, 'store'])->name('store');
        Route::patch(
            'job-ad/{id}/approve',
            JobAdApproveController::class
        )->name('approve');
        Route::patch('job-ad/{id}/reject', JobAdRejectController::class)->name(
            'reject'
        );
    });

Route::middleware([JwtMiddleware::class])
    ->name('user.')
    ->prefix('user')
    ->group(function () {
        Route::get('notification', UserNotificationController::class)->name(
            'notification.index'
        );

        Route::post(
            'notification',
            UserReadNotificationController::class
        )->name('notification.read');
    });
