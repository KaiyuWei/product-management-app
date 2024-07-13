<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function sendSuccessJsonResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    public static function sendErrorJsonResponse(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'error' => $message,
        ], $code);
    }
}
