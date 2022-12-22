<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Context;

use LaraStrict\Context\ContextServiceProvider;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Services\ContextEventsService;
use LaraStrict\Context\Services\ContextService;
use LaraStrict\Testing\Providers\Concerns\AssertProviderBindings;
use LaraStrict\Testing\Providers\Concerns\AssertProviderSingletons;
use Tests\LaraStrict\Feature\TestCase;

class ContextServiceProviderTest extends TestCase
{
    use AssertProviderSingletons;
    use AssertProviderBindings;

    public function testBindings(): void
    {
        $this->assertBindings(
            application: $this->app(),
            expectedMap: [
                ContextEventsService::class => ContextEventsService::class,
                ContextServiceContract::class => ContextService::class,
            ],
            registerServiceProvider: ContextServiceProvider::class
        );
    }

    public function testSingletons(): void
    {
        $this->assertSingletons(
            application: $this->app(),
            expectedMap: [ContextEventsService::class, ContextServiceContract::class],
            registerServiceProvider: ContextServiceProvider::class
        );
    }
}
