<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('payments', [\App\Http\Controllers\PaymentController::class, 'store']);

Route::resource('tags', \App\Http\Controllers\API\TagAPIController::class)
    ->only(['index']);
