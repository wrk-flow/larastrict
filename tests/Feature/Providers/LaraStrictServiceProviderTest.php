<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

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

    public function testBootResolveFactory(): void
    {
        $result = Test::factory(1)->make()->first();

        $this->assertNotNull($result);
        $this->assertEquals($result->test, 1);
    }

    public function testBindingsFromAllServiceProviders(): void
    {
        $this->assertBindings($this->app, null, [
            RunInTransactionActionContract::class => RunInTransactionAction::class,
            SafeUniqueSaveActionContract::class => SafeUniqueSaveAction::class,
            GetBasePathForStubsActionContract::class => GetBasePathForStubsAction::class,
            GetNamespaceForStubsActionContract::class => GetNamespaceForStubsAction::class,
        ]);
    }
}
