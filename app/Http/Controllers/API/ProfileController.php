<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\ApiResponse;

class ProfileController extends Controller
{
    // Get the authenticated user's profile
    public function getProfile()
    {
        $profile = User::find(Auth::id());

        return ApiResponse::success([
            'message' => __('profile.fetched'), 
            'data' => $profile
        ]);
    }
}
