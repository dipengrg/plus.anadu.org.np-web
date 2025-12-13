<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Jobs\MessageMember;

class MessageController extends Controller
{
    // Send SMS message to members
    public function postMessage(Request $request)
    {
        // Dispatch job to send message asynchronously
        MessageMember::dispatch($request->get('message'));

        return ApiResponse::success(__('message.sent'));
    }
}
