<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OtpController;

// OTP Routes
Route::post('/otp/request', [OtpController::class, 'requestOtp']);
Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
