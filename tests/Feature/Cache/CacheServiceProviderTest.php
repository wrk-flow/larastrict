<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Cache;

use LaraStrict\Cache\CacheServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class CacheServiceProviderTest extends TestCase
{
    public function testBooted(): void
    {
        $this->assertTrue($this->app?->providerIsLoaded(CacheServiceProvider::class));
    }
}
