<?php

namespace App\Http\Responses;

class ApiResponse
{
    // Success response
    public static function success($message, $data = null, $code = 200)
    {
        $response = ['message' => $message];
        
        if ($data !== null) {
            $response = array_merge($response, (array) $data);
        }
        
        return response()->json($response, $code);
    }

    // Error response
    public static function error($message, $code = 422)
    {
        return response()->json(['message' => $message], $code);
    }

    // Not found response
    public static function notFound($message = 'Resource not found.')
    {
        return self::error($message, 404);
    }
}