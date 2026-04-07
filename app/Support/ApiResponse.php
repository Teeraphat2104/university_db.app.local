<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse(
        mixed $data = null,
        string $message = 'Request completed successfully.',
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(
        string $message = 'Request failed.',
        mixed $error = null,
        int $statusCode = 400
    ): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }
}
