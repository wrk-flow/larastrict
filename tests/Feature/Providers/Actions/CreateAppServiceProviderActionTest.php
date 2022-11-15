<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Actions;

use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Actions\CreateAppServiceProviderAction;
use LaraStrict\Testing\Laravel\TestingServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class CreateAppServiceProviderActionTest extends TestCase
{
    public function testTestingProvider(): void
    {
        $action = new CreateAppServiceProviderAction();

        $provider = new TestingServiceProvider($this->app());
        $result = $action->execute($this->app(), $provider);
        $this->assertEquals('Laravel', $result->serviceName);
        $this->assertEquals('laravel', $result->serviceFileName);
        $this->assertStringEndsWith('src/Testing/Laravel', $result->serviceRootDir);
        $this->assertEquals('LaraStrict\\Testing\\Laravel', $result->namespace);
        $this->assertSame($this->app(), $result->application);
        $this->assertSame($provider, $result->serviceProvider);
    }

    public function testAnonymousServiceProvider(): void
    {
        $action = new CreateAppServiceProviderAction();

        $provider = new class($this->app()) extends AbstractServiceProvider {
        };
        $result = $action->execute($this->app(), $provider);
        $this->assertEquals('Providers', $result->serviceName);
        $this->assertEquals('providers', $result->serviceFileName);
        $this->assertStringEndsWith('tests/Feature/Providers/Actions', $result->serviceRootDir);
        $this->assertEquals('LaraStrict\Providers', $result->namespace);
        $this->assertSame($this->app(), $result->application);
        $this->assertSame($provider, $result->serviceProvider);
    }
}
