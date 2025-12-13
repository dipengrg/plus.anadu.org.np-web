<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\MessageController;

// Public Routes for OTP based authentication
Route::post('otp/request', [OtpController::class, 'requestOtp']);
Route::post('otp/verify', [OtpController::class, 'verifyOtp']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Account Routes
    Route::get('profile', [ProfileController::class, 'getProfile']);

    // Member Management Routes
    Route::get('members', [MemberController::class, 'getMembers']);
    Route::post('members', [MemberController::class, 'postMember']);
    Route::get('members/{member}', [MemberController::class, 'getMember']);
    Route::post('members/{member}/avatar', [MemberController::class, 'postMemberAvatar']);
    Route::put('members/{member}', [MemberController::class, 'updateMember']);
    Route::delete('members/{member}', [MemberController::class, 'deleteMember']);

    // Message Routes
    Route::post('messages', [MessageController::class, 'postMessage']);
});

