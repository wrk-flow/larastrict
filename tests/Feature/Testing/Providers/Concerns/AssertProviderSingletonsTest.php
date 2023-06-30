<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Providers\Concerns;

use LaraStrict\Testing\Providers\Concerns\AssertProviderSingletons;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestAction;

class AssertProviderSingletonsTest extends TestCase
{
    use AssertProviderSingletons;
    final public const KeyBinding = 'test-action';

    public function test(): void
    {
        $this->app()
            ->singleton(self::KeyBinding, TestAction::class);

        $this->assertSingletons($this->app(), [self::KeyBinding]);
    }
}
