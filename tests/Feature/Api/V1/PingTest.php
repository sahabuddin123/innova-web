<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;

/**
 * Class PingTest
 *
 * Verifies that the API v1 baseline ping endpoint conforms strictly to the
 * standardized success envelope specification without requiring database access.
 *
 * @package Tests\Feature\Api\V1
 */
class PingTest extends TestCase
{
    /**
     * Set up test environment with normalized root URL for testing.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');
    }

    /**
     * Test that GET /api/v1/ping returns HTTP 200 and standard success envelope.
     *
     * @return void
     */
    public function test_api_v1_ping_returns_ok_envelope()
    {
        $response = $this->getJson('/api/v1/ping');

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'success' => true,
                'message' => 'API v1 foundation operational',
                'data'    => [
                    'api_version' => 'v1',
                ],
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'name',
                    'api_version',
                    'environment',
                    'timestamp',
                ],
            ]);
    }

    /**
     * Test that an invalid endpoint under /api/v1 returns HTTP 404.
     *
     * @return void
     */
    public function test_api_v1_nonexistent_endpoint_returns_404()
    {
        $response = $this->getJson('/api/v1/nonexistent-endpoint');

        $response->assertStatus(404);
    }
}
