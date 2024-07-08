<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function sendSuccessJsonResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], $code);
    }

    public static function sendErrorJsonResponse(\Exception $e): JsonResponse
    {
        return response()->json([
            'status' => 'failed',
            'errorMessage' => $e->getMessage(),
        ], $e->getCode());
    }
}
