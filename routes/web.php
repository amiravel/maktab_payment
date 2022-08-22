<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('verify', \App\Http\Controllers\VerifyController::class)->name('verify');

Route::resource('refunds', \App\Http\Controllers\RefundController::class)
    ->only(['create', 'store']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->except(['create', 'store']);

    Route::resource('tags', \App\Http\Controllers\TagController::class);
    Route::resource('drives', \App\Http\Controllers\DriveController::class)
        ->except(['show', 'destroy']);

    Route::resource('refunds', \App\Http\Controllers\RefundController::class)
        ->except(['create', 'store']);

    Route::resource('cycles', \App\Http\Controllers\CycleController::class)->only(['index']);
});
