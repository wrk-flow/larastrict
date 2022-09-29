<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Health;

use Illuminate\Routing\Route;
use LaraStrict\Health\HealthServiceProvider;
use LaraStrict\Testing\Providers\Concerns\AssertProviderRegistersRoutes;
use Tests\LaraStrict\Feature\TestCase;

class HealthServiceProviderTest extends TestCase
{
    use AssertProviderRegistersRoutes;

    public function testAlive(): void
    {
        $this->assertRoutes($this->app, [
            'GET' => [
                'api/health/alive' => function (Route $route) {
                    $this->assertEquals(['api'], $route->gatherMiddleware());
                    $this->assertEquals(['api'], $route->excludedMiddleware());
                },
            ],
        ], HealthServiceProvider::class);

        $this->get('/api/health/alive')
            ->assertJson([
                'message' => 'ok',
            ]);
    }
}
