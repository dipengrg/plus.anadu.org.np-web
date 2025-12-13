<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\MemberController;

// Public Routes for OTP based authentication
Route::post('otp/request', [OtpController::class, 'requestOtp']);
Route::post('otp/verify', [OtpController::class, 'verifyOtp']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('members', [MemberController::class, 'getMembers']);
    Route::post('members', [MemberController::class, 'postMember']);
    Route::get('members/{member}', [MemberController::class, 'getMember']);
    Route::post('members/{member}/avatar', [MemberController::class, 'postMemberAvatar']);
    Route::put('members/{member}', [MemberController::class, 'updateMember']);
    Route::delete('members/{member}', [MemberController::class, 'deleteMember']);
});

