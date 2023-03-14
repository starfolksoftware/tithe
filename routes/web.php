<?php

use Illuminate\Support\Facades\Route;
use Tithe\Http\Controllers;
use Tithe\Http\Middleware\Authenticate;
use Tithe\Tithe;

Route::middleware(Tithe::middlewares())->prefix('tithe')->group(function () {
    // Login routes...
    Route::get('login', [Controllers\AuthenticatedSessionController::class, 'create'])->name('tithe.login');
    Route::post('login', [Controllers\AuthenticatedSessionController::class, 'store'])->name('tithe.authenticate');

    // Forgot password routes...
    Route::get('forgot-password', [Controllers\PasswordResetLinkController::class, 'create'])->name('tithe.password.request');
    Route::post('forgot-password', [Controllers\PasswordResetLinkController::class, 'store'])->name('tithe.password.email');

    // Reset password routes...
    Route::get('reset-password/{token}', [Controllers\NewPasswordController::class, 'create'])->name('tithe.password.reset');
    Route::post('reset-password', [Controllers\NewPasswordController::class, 'store'])->name('tithe.password.update');

    // Logout routes...
    Route::get('logout', [Controllers\AuthenticatedSessionController::class, 'destroy'])->name('tithe.logout');
});

Route::middleware(array_merge(Tithe::middlewares(), [Authenticate::class]))->prefix('tithe')->group(function () {
    Route::get('/', Controllers\HomeController::class)->name('tithe.home');

    Route::resource('plans', Controllers\PlanController::class);

    Route::post('/plans/{planId}/attach-feature', Controllers\FeaturePlanAttachmentController::class)->name('tithe.plans.attach-feature');
    Route::post('/plans/{planId}/detach-feature', Controllers\FeaturePlanDetachmentController::class)->name('tithe.plans.detach-feature');
    Route::resource('features', Controllers\FeatureController::class);
});
