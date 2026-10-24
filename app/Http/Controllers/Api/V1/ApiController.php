<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiController
 *
 * Base controller for all version 1 (v1) REST API endpoints.
 * Enforces standardized JSON envelopes for success and error responses.
 *
 * @package App\Http\Controllers\Api\V1
 */
abstract class ApiController extends Controller
{
    /**
     * Return a standardized JSON success response.
     *
     * @param mixed $data Primary payload
     * @param string $message User-friendly message
     * @param int $statusCode HTTP status code (default: 200)
     * @param array $meta Optional metadata (e.g. pagination, timestamps)
     * @return JsonResponse
     */
    protected function success($data = null, string $message = 'Success', int $statusCode = 200, array $meta = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a standardized JSON error response.
     *
     * @param string $message Error summary
     * @param int $statusCode HTTP error code (400, 401, 403, 404, 422, 500)
     * @param mixed $errors Detailed field errors or validation bags
     * @return JsonResponse
     */
    protected function error(string $message = 'Error', int $statusCode = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ];

        return response()->json($response, $statusCode);
    }
}
