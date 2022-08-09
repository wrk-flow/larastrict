<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Health;

use LaraStrict\Health\HealthServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class HealthServiceProviderTest extends TestCase
{
    public function testAlive(): void
    {
        $this->get('/api/health/alive')
            ->assertJson([
                'message' => 'ok',
            ]);
    }

    protected function getPackageProviders($app)
    {
        return [...parent::getPackageProviders($app), HealthServiceProvider::class];
    }
}
