<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config;

use LaraStrict\Config\Contracts\AppConfigContract;
use LaraStrict\Config\Laravel\AppConfig;
use LaraStrict\Testing\Providers\Concerns\AssertProviderBindings;
use Tests\LaraStrict\Feature\TestCase;

class ConfigServiceProviderTest extends TestCase
{
    use AssertProviderBindings;

    public function testBindings(): void
    {
        $this->assertBindings($this->app(), [
            AppConfigContract::class => AppConfig::class,
        ]);
    }
}
