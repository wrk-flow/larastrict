<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig;

use Tests\LaraStrict\Feature\Config\Valid\ValidConfigServiceProvider;
use Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\Invalid\InvalidConfigServiceProvider;
use Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\NoConfig\NoConfigServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class LoadProviderConfigTest extends TestCase
{
    public function testInvalidDoesNothing(): void
    {
        $provider = $this->app()
            ->register(provider: InvalidConfigServiceProvider::class);
        $this->assertInstanceOf(expected: InvalidConfigServiceProvider::class, actual: $provider);
    }

    public function testMissingConfigFile(): void
    {
        $this->expectExceptionMessage(message: 'tests/Feature/Config/NoConfig/Config/no_config.php');
        $this->expectExceptionMessage(message: 'Failed to load config at');
        $this->app()
            ->register(provider: NoConfigServiceProvider::class);
    }

    public function testValid(): void
    {
        $provider = $this->app()
            ->register(provider: ValidConfigServiceProvider::class);
        $this->assertInstanceOf(expected: ValidConfigServiceProvider::class, actual: $provider);
    }
}
