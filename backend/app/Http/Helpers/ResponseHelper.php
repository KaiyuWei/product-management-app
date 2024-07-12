<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function sendSuccessJsonResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    public static function sendErrorJsonResponse(\Exception $e): JsonResponse
    {
        return response()->json([
            'error' => $e->getMessage(),
        ], $e->getCode());
    }
}
