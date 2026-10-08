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
            ->register(InvalidConfigServiceProvider::class);
        $this->assertInstanceOf(InvalidConfigServiceProvider::class, $provider);
    }

    public function testMissingConfigFile(): void
    {
        $this->expectExceptionMessage('tests/Feature/Config/NoConfig/Config/no_config.php');
        $this->expectExceptionMessage('Failed to load config at');
        $this->app()
            ->register(NoConfigServiceProvider::class);
    }

    public function testValid(): void
    {
        $provider = $this->app()
            ->register(ValidConfigServiceProvider::class);
        $this->assertInstanceOf(ValidConfigServiceProvider::class, $provider);
    }
}
