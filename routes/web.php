<?php

use Illuminate\Support\Facades\Route;
use Tithe\Http\Controllers;
use Tithe\Http\Middleware\Authenticate;

Route::middleware(config('tithe.admin_middlewares'))->prefix(config('tithe.routes.admin'))->group(function () {
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

    Route::middleware(Authenticate::class)->group(function () {
        Route::get('/', Controllers\HomeController::class)->name('tithe.home');

        Route::resource('plans', Controllers\PlanController::class);

        Route::post('/plans/{planId}/attach-feature', Controllers\FeaturePlanAttachmentController::class)->name('tithe.plans.attach-feature');
        Route::post('/plans/{planId}/detach-feature', Controllers\FeaturePlanDetachmentController::class)->name('tithe.plans.detach-feature');
        Route::resource('features', Controllers\FeatureController::class);
    });
});

Route::middleware(config('tithe.ui_middlewares'))->prefix(config('tithe.routes.ui'))->group(function () {
    Route::get('/', Controllers\BillingController::class)->name('tithe.billing.index');
    Route::get('/invoices/{invoiceId}', Controllers\ShowInvoiceController::class)->name('tithe.billing.invoices.show');
    Route::get('/create-authorization', Controllers\CreateAuthorizationController::class)->name('tithe.billing.create-authorization');
    Route::delete('/remove-authorization', Controllers\RemoveAuthorizationController::class)->name('tithe.billing.remove-authorization');
    Route::patch('/set-default-authorization', Controllers\SetDefaultAuthorizationController::class)->name('tithe.billing.set-default-authorization');
    Route::post('/upgrade-subscription', Controllers\UpgradeSubscriptionController::class)->name('tithe.billing.upgrade-subscription');
    Route::post('/downgrade-subscription', Controllers\DowngradeSubscriptionController::class)->name('tithe.billing.downgrade-subscription');
    Route::post('/cancel-pending-downgrade', Controllers\CancelPendingDowngradeController::class)->name('tithe.billing.cancel-pending-downgrade');
});
