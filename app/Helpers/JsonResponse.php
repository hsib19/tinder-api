<?php

namespace App\Helpers;

class JsonResponse
{
    public static function success(string $message = 'Success', array $data = [], int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(string $message = 'Error', int $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
