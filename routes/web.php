<?php

use Illuminate\Support\Facades\Route;

Route::resource('payments', \App\Http\Controllers\PaymentController::class)
    ->only(['show']);
Route::get('verify', \App\Http\Controllers\VerifyController::class)->name('verify');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('payments', \App\Http\Controllers\PaymentController::class)
        ->except(['show']);

    Route::resource('tags', \App\Http\Controllers\TagController::class);
});
