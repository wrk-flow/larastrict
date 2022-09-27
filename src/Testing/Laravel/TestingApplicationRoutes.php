<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\CachesRoutes;

/**
 * A testing application class that helps you to not use mocks.
 */
class TestingApplicationRoutes extends TestingApplication implements CachesRoutes
{
    private bool $routesAreCached = false;

    public function setRoutesAreCached(bool $routesAreCached = true): self
    {
        $this->routesAreCached = $routesAreCached;

        return $this;
    }

    public function routesAreCached()
    {
        return $this->routesAreCached;
    }

    public function getCachedRoutesPath()
    {
        return 'routes-path';
    }
}
