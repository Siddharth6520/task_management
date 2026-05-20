<?php

namespace App\Helpers;

class CommonHelper
{
    public static function response(
        bool $success,
        int $code,
        mixed $data = null,
        $message = []
    ) {

        $response = [
            'success' => $success,
            'code' => $code,
            'data' => $data,
            'message' => $message,
            'server_time' => now()->format('Y-m-d H:i:s'),
            'timezone' => config('app.timezone'),
        ];
        
        return response()->json(
            $response,
            $code
        );
    }
}
