<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::resource('payments', \App\Http\Controllers\PaymentController::class)
    ->only(['show']);
Route::get('verify', \App\Http\Controllers\VerifyController::class)->name('verify');

Route::resource('refunds', \App\Http\Controllers\RefundController::class)
    ->only(['create', 'store', 'show']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('payments', \App\Http\Controllers\PaymentController::class)
        ->except(['show']);

    Route::resource('tags', \App\Http\Controllers\TagController::class);
    Route::resource('drives', \App\Http\Controllers\DriveController::class)
        ->except(['show', 'destroy']);

    Route::resource('refunds', \App\Http\Controllers\RefundController::class)
        ->except(['create', 'store', 'show']);
});
