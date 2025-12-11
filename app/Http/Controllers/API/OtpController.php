<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\PhoneVerificationRequest;
use App\Http\Requests\OtpVerificationRequest;
use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    /**
     * Request OTP for a given phone number
     */
    public function requestOtp(PhoneVerificationRequest $request)
    {
        // Find user by phone (guaranteed to exist by 'exists' validation rule)
        $user = User::where('phone', $request->phone)->first();

        // Generate a 4-digit OTP
        $otp = rand(1000, 9999);

        // Save OTP and timestamp to user record
        $user->update([
            'otp' => $otp,
            'otp_created_at' => now(),
        ]);
        
        // TODO: Integrate your SMS gateway here
        // sendSms($user->phone, "Your OTP is: $otp");

        return ApiResponse::success(__('messages.otp_sent'));
    }

    /**
     * Verify the OTP for a given phone number
     */
    public function verifyOtp(OtpVerificationRequest $request)
    {
        // Find user by phone
        $user = User::where('phone', $request->phone)->first();

        // Check if OTP matches
        if ($user->otp != $request->otp) {
            return ApiResponse::error(__('messages.invalid_otp'), 422);
        }

        // Optional: OTP expiry check (example 3 minutes)
        if ($user->otp_created_at && Carbon::parse($user->otp_created_at)->addMinutes(3)->isPast()) {
            return ApiResponse::error(__('messages.otp_expired'), 410);
        }

        // OTP success → clear OTP
        $user->update([
            'otp' => null,
            'otp_created_at' => null,
        ]);

        // Issue Sanctum token
        $token = $user->createToken('mobile')->plainTextToken;

        // Return success response with token and user info
        return ApiResponse::success(__('messages.otp_verified'), [
            'token' => $token,
            'user' => $user,
        ]);
    }
}
