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
            'status' => $statusCode,
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
            'status' => $statusCode,
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }

    protected function validationErrorResponse(
        mixed $errors,
        string $message = 'The given data was invalid.',
        int $statusCode = 422
    ): JsonResponse {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
