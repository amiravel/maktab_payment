<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('verify', \App\Http\Controllers\VerifyController::class)->name('verify');

Route::resource('refunds', \App\Http\Controllers\RefundController::class)
    ->only(['create', 'store', 'show']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('payments', \App\Http\Controllers\PaymentController::class);

    Route::resource('tags', \App\Http\Controllers\TagController::class);
    Route::resource('drives', \App\Http\Controllers\DriveController::class)
        ->except(['show', 'destroy']);

    Route::resource('refunds', \App\Http\Controllers\RefundController::class)
        ->except(['create', 'store', 'show']);

    Route::resource('cycles', \App\Http\Controllers\CycleController::class);
});

Route::get('test/{payment}', function (\App\Models\Payment $payment) {
    $refID = "123456";
    $authority = "654321";

    $payment->logs()->updateOrCreate([
        'authority' => $authority,
        'refID' => $refID,
    ], [
        'status' => 100,
        'type' => 'after',
        'authority' => $authority,
        'message' => 'پرداخت با موفقیت انجام شد.',
        'refID' => $refID,
    ]);
});
