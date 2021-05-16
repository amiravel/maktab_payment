<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('payments', [\App\Http\Controllers\PaymentController::class, 'store']);
Route::post('refunds', [\App\Http\Controllers\RefundController::class, 'store']);

Route::resource('tags', \App\Http\Controllers\API\TagAPIController::class)
    ->only(['index']);
