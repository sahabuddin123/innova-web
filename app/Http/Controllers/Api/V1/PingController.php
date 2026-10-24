<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;

/**
 * Class PingController
 *
 * Provides a stateless foundation health check and API version verification endpoint.
 *
 * @package App\Http\Controllers\Api\V1
 */
class PingController extends ApiController
{
    /**
     * Return API v1 baseline status and metadata.
     *
     * @return JsonResponse
     */
    public function ping(): JsonResponse
    {
        return $this->success([
            'name'        => config('app.name', 'INNOVA Web'),
            'api_version' => 'v1',
            'environment' => config('app.env', 'production'),
            'timestamp'   => now()->toIso8601String(),
        ], 'API v1 foundation operational');
    }
}
