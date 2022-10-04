<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use LaraStrict\Core\LaraStrictServiceProvider;
use LaraStrict\Database\Actions\RunInTransactionAction;
use LaraStrict\Database\Actions\SafeUniqueSaveAction;
use LaraStrict\Database\Contracts\RunInTransactionActionContract;
use LaraStrict\Database\Contracts\SafeUniqueSaveActionContract;
use LaraStrict\Testing\Actions\GetBasePathForStubsAction;
use LaraStrict\Testing\Actions\GetNamespaceForStubsAction;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Providers\Concerns\AssertProviderBindings;
use Tests\LaraStrict\Feature\Database\Models\Test;
use Tests\LaraStrict\Feature\TestCase;

class LaraStrictServiceProviderTest extends TestCase
{
    use AssertProviderBindings;

    public function testAppServiceProvider(): void
    {
        /** @var LaraStrictServiceProvider $serviceProvider */
        $serviceProvider = $this->app->getProvider(LaraStrictServiceProvider::class);
        $result = $serviceProvider->getAppServiceProvider();

        $this->assertEquals('LaraStrict', $result->serviceName);
        $this->assertEquals('lara_strict', $result->serviceFileName);
        $this->assertStringEndsWith('src/Core', $result->serviceRootDir);
        $this->assertEquals('LaraStrict\\Core', $result->namespace);
        $this->assertSame($this->app, $result->application);
        $this->assertSame($serviceProvider, $result->serviceProvider);
    }

    public function testBootResolveFactory(): void
    {
        $result = Test::factory(1)->make()->first();

        $this->assertNotNull($result);
        $this->assertEquals($result->test, 1);
    }

    public function testBindingsFromAllServiceProviders(): void
    {
        $this->assertBindings($this->app, [
            RunInTransactionActionContract::class => RunInTransactionAction::class,
            SafeUniqueSaveActionContract::class => SafeUniqueSaveAction::class,
            GetBasePathForStubsActionContract::class => GetBasePathForStubsAction::class,
            GetNamespaceForStubsActionContract::class => GetNamespaceForStubsAction::class,
        ], null);
    }
}
