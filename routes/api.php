<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\TenureController;
use App\Http\Controllers\API\EventController;

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

    // Tenure Routes
    Route::get('tenures', [TenureController::class, 'getTenures']);
    Route::post('tenures', [TenureController::class, 'postTenure']);
    Route::get('tenures/{tenure}', [TenureController::class, 'getTenure']);
    Route::delete('tenures/{tenure}', [TenureController::class, 'deleteTenure']);
    Route::post('tenures/{tenure}/committees', [TenureController::class, 'postTenureMember']);
    Route::delete('tenures/{tenure}/committees/{member}', [TenureController::class, 'deleteTenureMember']);

    // Event Routes
    Route::get('events', [EventController::class, 'getEvents']);
    Route::post('events', [EventController::class, 'postEvent']);
    Route::get('events/{event}', [EventController::class, 'getEvent']);
    Route::put('events/{event}', [EventController::class, 'updateEvent']);
    Route::delete('events/{event}', [EventController::class, 'deleteEvent']);
});

