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

            'server_time' => now()->format('Y-m-d H:i:s'),
            'timezone' => config('app.timezone'),
        ];

        // if ($success) {

            $response['data'] = $data;

        // } else {

            $response['message'] = $message;
        // }

        return response()->json(
            $response,
            $code
        );
    }
}