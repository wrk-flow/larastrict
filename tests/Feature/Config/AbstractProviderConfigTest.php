<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config;

use Tests\LaraStrict\Feature\Config\NotUsingPipe\Config\NotUsingPipeConfig;
use Tests\LaraStrict\Feature\Config\NotUsingPipe\NotUsingPipeServiceProvider;
use Tests\LaraStrict\Feature\Config\Valid\Config\ValidConfig;
use Tests\LaraStrict\Feature\Config\Valid\ValidConfigServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class AbstractProviderConfigTest extends TestCase
{
    public function testValid(): void
    {
        $this->app()
            ->register(provider: ValidConfigServiceProvider::class);
        $config = $this->app()
            ->make(ValidConfig::class);

        $this->assertEquals('value!', $config->getTest());
    }

    public function testNotUsingPipe(): void
    {
        $this->app()
            ->register(provider: NotUsingPipeServiceProvider::class);
        $config = $this->app()
            ->make(NotUsingPipeConfig::class);

        $this->assertEquals('missing file, this is a default', $config->getTest());
    }
}
