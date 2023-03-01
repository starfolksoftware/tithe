<?php

use Illuminate\Support\Facades\Route;
use Tithe\Http\Controllers;
use Tithe\Http\Middleware\Authenticate;

Route::middleware([])->group(function () {
    // Login routes...
    Route::get('login', [Controllers\AuthenticatedSessionController::class, 'create'])->name('tithe.login');
    Route::post('login', [Controllers\AuthenticatedSessionController::class, 'store']);

    // Forgot password routes...
    Route::get('forgot-password', [Controllers\PasswordResetLinkController::class, 'create'])->name('tithe.password.request');
    Route::post('forgot-password', [Controllers\PasswordResetLinkController::class, 'store'])->name('tithe.password.email');

    // Reset password routes...
    Route::get('reset-password/{token}', [Controllers\NewPasswordController::class, 'create'])->name('tithe.password.reset');
    Route::post('reset-password', [Controllers\NewPasswordController::class, 'store'])->name('tithe.password.update');

    // Logout routes...
    Route::get('logout', [Controllers\AuthenticatedSessionController::class, 'destroy'])->name('tithe.logout');
});

Route::middleware([Authenticate::class])->group(function () {
    //
});
